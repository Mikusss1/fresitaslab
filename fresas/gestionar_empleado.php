<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $empleado_id = $_POST['empleado_id'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $especialidad = trim($_POST['especialidad'] ?? '');
    $contra = $_POST['contra'] ?? '';

    // Validaciones del backend
    if (empty($nombre) || empty($apellidos) || empty($correo) || empty($especialidad)) {
        $_SESSION['mensaje_error'] = "Todos los campos son obligatorios";
        header('Location: admin.php');
        exit;
    }

    // Validar formato de email
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensaje_error'] = "El formato del correo electrónico no es válido";
        header('Location: admin.php');
        exit;
    }

    if ($accion === 'agregar') {
        // Verificar si el correo ya existe
        $sql_check = "SELECT empleadoID FROM empleado WHERE correo = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $correo);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $_SESSION['mensaje_error'] = "El correo ya está registrado";
            mysqli_stmt_close($stmt_check);
            header('Location: admin.php');
            exit;
        }
        mysqli_stmt_close($stmt_check);

        // Validar que se proporcionó contraseña al agregar
        if (empty($contra)) {
            $_SESSION['mensaje_error'] = "La contraseña es obligatoria para nuevo empleado";
            header('Location: admin.php');
            exit;
        }

        // Encriptar contraseña
        $contra_hash = contra_hash($contra, contra_DEFAULT);

        // Insertar nuevo empleado
        $sql = "INSERT INTO empleado (nombre, apellidos, correo, especialidad, contra) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $apellidos, $correo, $especialidad, $contra_hash);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensaje_exito'] = "Empleado agregado correctamente";
        } else {
            $_SESSION['mensaje_error'] = "Error al agregar el empleado: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
        
    } elseif ($accion === 'editar') {
        // Verificar si el correo ya existe (excluyendo el empleado actual)
        $sql_check = "SELECT empleadoID FROM empleado WHERE correo = ? AND empleadoID != ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "si", $correo, $empleado_id);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $_SESSION['mensaje_error'] = "El correo ya está registrado por otro empleado";
            mysqli_stmt_close($stmt_check);
            header('Location: admin.php');
            exit;
        }
        mysqli_stmt_close($stmt_check);

        // Si se proporcionó nueva contraseña, actualizarla
        if (!empty($contra)) {
            $contra_hash = contra_hash($contra, contra_DEFAULT);
            $sql = "UPDATE empleado SET nombre = ?, apellidos = ?, correo = ?, especialidad = ?, contra = ? WHERE empleadoID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssi", $nombre, $apellidos, $correo, $especialidad, $contra_hash, $empleado_id);
        } else {
            // Mantener la contraseña actual
            $sql = "UPDATE empleado SET nombre = ?, apellidos = ?, correo = ?, especialidad = ? WHERE empleadoID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $apellidos, $correo, $especialidad, $empleado_id);
        }
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensaje_exito'] = "Empleado actualizado correctamente";
        } else {
            $_SESSION['mensaje_error'] = "Error al actualizar el empleado: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
        
    } elseif ($accion === 'eliminar') {
        // Verificar si el empleado tiene citas asignadas
        $sql_check_citas = "SELECT citaID FROM cita WHERE empleadoID = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check_citas);
        mysqli_stmt_bind_param($stmt_check, "i", $empleado_id);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $_SESSION['mensaje_error'] = "No se puede eliminar el empleado porque tiene citas asignadas. Primero reasigna las citas a otro empleado.";
            mysqli_stmt_close($stmt_check);
            header('Location: admin.php');
            exit;
        }
        mysqli_stmt_close($stmt_check);

        // Eliminar empleado
        $sql = "DELETE FROM empleado WHERE empleadoID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $empleado_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensaje_exito'] = "Empleado eliminado correctamente";
        } else {
            $_SESSION['mensaje_error'] = "Error al eliminar el empleado: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
} else {
    $_SESSION['mensaje_error'] = "Método no permitido";
}

mysqli_close($conn);
header('Location: admin.php');
exit;
?>