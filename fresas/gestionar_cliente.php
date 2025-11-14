<?php
session_start();
include 'conexion.php';

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['mensaje_error'] = "Método no permitido";
    header('Location: admin.php');
    exit;
}



// Obtener y sanitizar datos
$accion = isset($_POST['accion']) ? trim($_POST['accion']) : '';
$cliente_id = isset($_POST['cliente_id']) ? intval($_POST['cliente_id']) : 0;
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : '';
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$password_hash = isset($_POST['password_hash']) ? trim($_POST['password_hash']) : '';

// Validaciones básicas
if (empty($accion) || !in_array($accion, ['agregar', 'editar', 'eliminar'])) {
    $_SESSION['mensaje_error'] = "Acción no válida";
    header('Location: admin.php');
    exit;
}

// Validaciones según la acción
if ($accion === 'agregar' || $accion === 'editar') {
    if (empty($nombre) || empty($apellidos) || empty($correo)) {
        $_SESSION['mensaje_error'] = "Todos los campos obligatorios deben ser completados";
        header('Location: admin.php');
        exit;
    }
    
    // Validar formato de nombre y apellidos (solo letras y espacios)
    if (!preg_match('/^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/', $nombre)) {
        $_SESSION['mensaje_error'] = "El nombre solo puede contener letras y espacios";
        header('Location: admin.php');
        exit;
    }
    
    if (!preg_match('/^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/', $apellidos)) {
        $_SESSION['mensaje_error'] = "Los apellidos solo pueden contener letras y espacios";
        header('Location: admin.php');
        exit;
    }
    
    // Validar formato de email
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensaje_error'] = "El formato del correo electrónico no es válido";
        header('Location: admin.php');
        exit;
    }
    
    // Validar longitud de campos
    if (strlen($nombre) < 2 || strlen($nombre) > 50) {
        $_SESSION['mensaje_error'] = "El nombre debe tener entre 2 y 50 caracteres";
        header('Location: admin.php');
        exit;
    }
    
    if (strlen($apellidos) < 2 || strlen($apellidos) > 80) {
        $_SESSION['mensaje_error'] = "Los apellidos deben tener entre 2 y 80 caracteres";
        header('Location: admin.php');
        exit;
    }
}

// Procesar según la acción
switch ($accion) {
    case 'agregar':
        agregarCliente($conn, $nombre, $apellidos, $correo, $password_hash);
        break;
        
    case 'editar':
        editarCliente($conn, $cliente_id, $nombre, $apellidos, $correo, $password_hash);
        break;
        
    case 'eliminar':
        eliminarCliente($conn, $cliente_id);
        break;
        
    default:
        $_SESSION['mensaje_error'] = "Acción no reconocida";
        header('Location: admin.php');
        exit;
}

// Cerrar conexión
mysqli_close($conn);

// Función para agregar cliente
function agregarCliente($conn, $nombre, $apellidos, $correo, $password_hash) {
    // Verificar si el correo ya existe
    $sql_verificar = "SELECT clienteID FROM cliente WHERE correo = ?";
    $stmt_verificar = mysqli_prepare($conn, $sql_verificar);
    mysqli_stmt_bind_param($stmt_verificar, "s", $correo);
    mysqli_stmt_execute($stmt_verificar);
    mysqli_stmt_store_result($stmt_verificar);
    
    if (mysqli_stmt_num_rows($stmt_verificar) > 0) {
        mysqli_stmt_close($stmt_verificar);
        $_SESSION['mensaje_error'] = "El correo electrónico ya está registrado";
        header('Location: admin.php');
        exit;
    }
    mysqli_stmt_close($stmt_verificar);
    
    // Validar que se proporcionó contraseña para agregar
    if (empty($password_hash)) {
        $_SESSION['mensaje_error'] = "La contraseña es obligatoria para crear un cliente";
        header('Location: admin.php');
        exit;
    }
    
    // Insertar nuevo cliente
    $sql = "INSERT INTO cliente (nombre, apellidos, correo, password, fecha_registro) 
            VALUES (?, ?, ?, ?, NOW())";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        $_SESSION['mensaje_error'] = "Error al preparar la consulta: " . mysqli_error($conn);
        header('Location: admin.php');
        exit;
    }
    
    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $apellidos, $correo, $password_hash);
    
    if (mysqli_stmt_execute($stmt)) {
        $nuevo_id = mysqli_insert_id($conn);
        $_SESSION['mensaje_exito'] = "Cliente agregado correctamente (ID: $nuevo_id)";
    } else {
        $_SESSION['mensaje_error'] = "Error al agregar el cliente: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);
    header('Location: admin.php');
    exit;
}

// Función para editar cliente
function editarCliente($conn, $cliente_id, $nombre, $apellidos, $correo, $password_hash) {
    // Verificar que el cliente existe
    $sql_verificar = "SELECT clienteID FROM cliente WHERE clienteID = ?";
    $stmt_verificar = mysqli_prepare($conn, $sql_verificar);
    mysqli_stmt_bind_param($stmt_verificar, "i", $cliente_id);
    mysqli_stmt_execute($stmt_verificar);
    mysqli_stmt_store_result($stmt_verificar);
    
    if (mysqli_stmt_num_rows($stmt_verificar) === 0) {
        mysqli_stmt_close($stmt_verificar);
        $_SESSION['mensaje_error'] = "El cliente no existe";
        header('Location: admin.php');
        exit;
    }
    mysqli_stmt_close($stmt_verificar);
    
    // Verificar si el correo ya existe en otro cliente
    $sql_verificar_correo = "SELECT clienteID FROM cliente WHERE correo = ? AND clienteID != ?";
    $stmt_verificar_correo = mysqli_prepare($conn, $sql_verificar_correo);
    mysqli_stmt_bind_param($stmt_verificar_correo, "si", $correo, $cliente_id);
    mysqli_stmt_execute($stmt_verificar_correo);
    mysqli_stmt_store_result($stmt_verificar_correo);
    
    if (mysqli_stmt_num_rows($stmt_verificar_correo) > 0) {
        mysqli_stmt_close($stmt_verificar_correo);
        $_SESSION['mensaje_error'] = "El correo electrónico ya está registrado por otro cliente";
        header('Location: admin.php');
        exit;
    }
    mysqli_stmt_close($stmt_verificar_correo);
    
    // Preparar la consulta de actualización
    if (!empty($password_hash)) {
        // Actualizar con nueva contraseña
        $sql = "UPDATE cliente SET nombre = ?, apellidos = ?, correo = ?, password = ? WHERE clienteID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $apellidos, $correo, $password_hash, $cliente_id);
    } else {
        // Actualizar sin cambiar contraseña
        $sql = "UPDATE cliente SET nombre = ?, apellidos = ?, correo = ? WHERE clienteID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $nombre, $apellidos, $correo, $cliente_id);
    }
    
    if (!$stmt) {
        $_SESSION['mensaje_error'] = "Error al preparar la consulta: " . mysqli_error($conn);
        header('Location: admin.php');
        exit;
    }
    
    if (mysqli_stmt_execute($stmt)) {
        if (!empty($password_hash)) {
            $_SESSION['mensaje_exito'] = "Cliente actualizado correctamente (contraseña cambiada)";
        } else {
            $_SESSION['mensaje_exito'] = "Cliente actualizado correctamente";
        }
    } else {
        $_SESSION['mensaje_error'] = "Error al actualizar el cliente: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);
    header('Location: admin.php');
    exit;
}

// Función para eliminar cliente
function eliminarCliente($conn, $cliente_id) {
    // Verificar que el cliente existe
    $sql_verificar = "SELECT clienteID FROM cliente WHERE clienteID = ?";
    $stmt_verificar = mysqli_prepare($conn, $sql_verificar);
    mysqli_stmt_bind_param($stmt_verificar, "i", $cliente_id);
    mysqli_stmt_execute($stmt_verificar);
    mysqli_stmt_store_result($stmt_verificar);
    
    if (mysqli_stmt_num_rows($stmt_verificar) === 0) {
        mysqli_stmt_close($stmt_verificar);
        $_SESSION['mensaje_error'] = "El cliente no existe";
        header('Location: admin.php');
        exit;
    }
    mysqli_stmt_close($stmt_verificar);
    
    // Verificar si el cliente tiene citas asociadas
    $sql_verificar_citas = "SELECT citaID FROM cita WHERE clienteID = ?";
    $stmt_verificar_citas = mysqli_prepare($conn, $sql_verificar_citas);
    mysqli_stmt_bind_param($stmt_verificar_citas, "i", $cliente_id);
    mysqli_stmt_execute($stmt_verificar_citas);
    mysqli_stmt_store_result($stmt_verificar_citas);
    
    if (mysqli_stmt_num_rows($stmt_verificar_citas) > 0) {
        mysqli_stmt_close($stmt_verificar_citas);
        $_SESSION['mensaje_error'] = "No se puede eliminar el cliente porque tiene citas asociadas. Elimine primero las citas.";
        header('Location: admin.php');
        exit;
    }
    mysqli_stmt_close($stmt_verificar_citas);
    
    // Eliminar cliente
    $sql = "DELETE FROM cliente WHERE clienteID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['mensaje_exito'] = "Cliente eliminado correctamente";
    } else {
        $_SESSION['mensaje_error'] = "Error al eliminar el cliente: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);
    header('Location: admin.php');
    exit;
}
?>