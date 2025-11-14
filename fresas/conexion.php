<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "fresitaslab";
$puerto = 3307; 


$conn = mysqli_connect($host, $usuario, $contrasena, $bd, $puerto);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
} 
?>

