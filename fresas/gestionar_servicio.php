<?php
session_start();
include 'conexion.php';

//ESTO ES PARA QUE SE EDITE EN LA TABLA DE SERVICIOS

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    
    if ($accion === 'agregar') {
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
        $precio = floatval($_POST['precio']);
        
        $sql = "INSERT INTO servicio (nombre, descripcion, precio) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssd", $nombre, $descripcion, $precio);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensaje_exito'] = "Servicio agregado correctamente";
        } else {
            $_SESSION['mensaje_error'] = "Error al agregar servicio: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
        
    } elseif ($accion === 'editar') {
        $servicio_id = intval($_POST['servicio_id']);
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
        $precio = floatval($_POST['precio']);
        
        $sql = "UPDATE servicio SET nombre = ?, descripcion = ?, precio = ? WHERE servicioID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdi", $nombre, $descripcion, $precio, $servicio_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensaje_exito'] = "Servicio actualizado correctamente";
        } else {
            $_SESSION['mensaje_error'] = "Error al actualizar servicio: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
        
    } elseif ($accion === 'eliminar') {
        $servicio_id = intval($_POST['servicio_id']);
        
        $sql_check = "SELECT COUNT(*) as total FROM citaservicio WHERE servicioID = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "i", $servicio_id);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        $row = mysqli_fetch_assoc($result_check);
        mysqli_stmt_close($stmt_check);
        
        if ($row['total'] > 0) {
            $_SESSION['mensaje_error'] = "No se puede eliminar el servicio porque tiene citas asociadas";
        } else {
            $sql = "DELETE FROM servicio WHERE servicioID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $servicio_id);
            
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['mensaje_exito'] = "Servicio eliminado correctamente";
            } else {
                $_SESSION['mensaje_error'] = "Error al eliminar servicio: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    }
}

mysqli_close($conn);
header("Location: admin.php");
exit();
?>