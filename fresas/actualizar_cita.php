<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cita_id = intval($_POST['cita_id'] ?? 0);
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $empleado_id = $_POST['empleado_id'] ?? '';
    $servicios = $_POST['servicios'] ?? [];

    // Actualizar cita
    $sql = "UPDATE cita SET fecha = ?, hora = ?, estado = ?, empleadoID = ? WHERE citaID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssii", $fecha, $hora, $estado, $empleado_id, $cita_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Eliminar servicios actuales
        $sql_delete = "DELETE FROM citaservicio WHERE citaID = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $cita_id);
        mysqli_stmt_execute($stmt_delete);
        mysqli_stmt_close($stmt_delete);
        
        // Insertar nuevos servicios
        if (!empty($servicios)) {
            $sql_insert = "INSERT INTO citaservicio (citaID, servicioID) VALUES (?, ?)";
            $stmt_insert = mysqli_prepare($conn, $sql_insert);
            
            foreach ($servicios as $servicio_id) {
                mysqli_stmt_bind_param($stmt_insert, "ii", $cita_id, $servicio_id);
                mysqli_stmt_execute($stmt_insert);
            }
            mysqli_stmt_close($stmt_insert);
        }
        
        $_SESSION['mensaje_exito'] = "Cita actualizada correctamente";
    } else {
        $_SESSION['mensaje_error'] = "Error al actualizar la cita";
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
header('Location: admin.php');
exit;
?>