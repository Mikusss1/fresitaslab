<?php
include 'conexion.php';

header('Content-Type: application/json');

if (isset($_GET['cita_id'])) {
    $cita_id = intval($_GET['cita_id']);
    
    $sql = "SELECT servicioID as servicio_id FROM citaservicio WHERE citaID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cita_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $servicios = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $servicios[] = $row;
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    echo json_encode($servicios);
} else {
    echo json_encode([]);
}
?>