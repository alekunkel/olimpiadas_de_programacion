<?php
$host = "sql312.infinityfree.com";  // Host proporcionado por InfinityFree
$user = "if0_39315917";  
$password = "aZLKnKCIA9";  
$dbname = "if0_39315917_XXX";  // El nombre de tu base de datos
// Crear la conexión
$conexion = new mysqli($host, $user, $password, $dbname);
if ($conexion->connect_error) {
    die("<div class='alert alert-danger'>Error de conexión: " . $conexion->connect_error . "</div>");
}
?>
