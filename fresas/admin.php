<?php
session_start();
include 'conexion.php';

// Procesar eliminación de cita
if (isset($_GET['eliminar_cita'])) {
    $cita_id = intval($_GET['eliminar_cita']);
    
    $sql_delete_servicios = "DELETE FROM citaservicio WHERE citaID = ?";
    $stmt1 = mysqli_prepare($conn, $sql_delete_servicios);
    mysqli_stmt_bind_param($stmt1, "i", $cita_id);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
    
    $sql = "DELETE FROM cita WHERE citaID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cita_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['mensaje_exito'] = "Cita eliminada correctamente";
    } else {
        $_SESSION['mensaje_error'] = "Error al eliminar la cita";
    }
    mysqli_stmt_close($stmt);
    header('Location: admin.php');
    exit;
}

// Función optimizada para obtener datos
function obtenerDatos($conn, $tabla, $campos = '*', $join = '', $where = '') {
    $sql = "SELECT $campos FROM $tabla $join $where ORDER BY 1 DESC";
    $result = mysqli_query($conn, $sql);
    $datos = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $datos[] = $row;
        }
    }
    return $datos;
}

// Obtener datos
$citas = obtenerDatos($conn, 
    'cita c', 
    "c.citaID as id, CONCAT(cl.nombre, ' ', cl.apellidos) as cliente, c.fecha, c.hora, c.estado, CONCAT(e.nombre, ' ', e.apellidos) as empleado, GROUP_CONCAT(s.nombre SEPARATOR ', ') as servicios",
    "LEFT JOIN cliente cl ON c.clienteID = cl.clienteID 
     LEFT JOIN empleado e ON c.empleadoID = e.empleadoID 
     LEFT JOIN citaservicio cs ON c.citaID = cs.citaID 
     LEFT JOIN servicio s ON cs.servicioID = s.servicioID",
    "GROUP BY c.citaID"
);

$clientes = obtenerDatos($conn, 'cliente', 'clienteID as id, nombre, apellidos, correo');
$empleados = obtenerDatos($conn, 'empleado', 'empleadoID as id, nombre, apellidos, correo, especialidad');
$servicios = obtenerDatos($conn, 'servicio', 'servicioID as id, nombre, precio, descripcion');

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- En el head de admin.php -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-sha256/0.9.0/sha256.min.js"></script>
    <link rel="stylesheet" href="style_admin.css">
</head>
<body>
    <div id="app" class="flex flex-col min-h-screen">
        <header class="header flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-500">FRESITASLAB | ADMINISTRADOR</h1>
            <div class="flex items-center space-x-4">
                <a href="logout.php" class="btn-primary flex items-center bg-gray-600 hover:bg-gray-700">
                    Cerrar Sesión
                </a>
            </div>
        </header>

        <main class="flex-grow p-4 md:p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Panel de Administración</h2>
            
            <?php if (isset($_SESSION['mensaje_exito'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['mensaje_error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?>
                </div>
            <?php endif; ?>
            
            <!-- En la sección de botones, cambiar onclick -->
<div class="flex flex-wrap gap-4 mb-8">
    <button id="btn-citas" class="view-btn btn-primary bg-pink-500" onclick="changeAdminView('citas')">
        Citas
    </button>
    <button id="btn-clientes" class="view-btn btn-primary bg-gray-400 hover:bg-gray-500" onclick="changeAdminView('clientes')">
        Clientes
    </button>
    <button id="btn-empleados" class="view-btn btn-primary bg-gray-400 hover:bg-gray-500" onclick="changeAdminView('empleados')">
        Empleados
    </button>
    <button id="btn-servicios" class="view-btn btn-primary bg-gray-400 hover:bg-gray-500" onclick="changeAdminView('servicios')">
        Servicios
    </button>
</div>

            <div id="admin-view-content" class="card p-6">
                <!-- El contenido se carga dinámicamente via JavaScript -->
            </div>
        </main>
    </div>
    <?php include 'modals.php'; ?>
<!-- Agregar esto antes de incluir admin.js -->
<script>
// Pasar datos PHP a JavaScript
window.citasData = <?php echo json_encode($citas); ?>;
window.clientesData = <?php echo json_encode($clientes); ?>;
window.empleadosData = <?php echo json_encode($empleados); ?>;
window.serviciosData = <?php echo json_encode($servicios); ?>;
</script>
<script src="admin.js"></script>
    <script src="admin.js"></script>

</body>
</html>