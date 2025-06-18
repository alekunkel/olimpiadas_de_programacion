<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida Administrador</title>
</head>
<body>
    <h1>Bienvenido Administrador</h1>
<a href="index.html">cerrar sesión</a>
    <br> 
<a href="tabla_historica.php">ver tabla histórica de ventas</a>
<br>
    <a href="carrito.php">Ver carrito de clientes</a>
</body>
</html>