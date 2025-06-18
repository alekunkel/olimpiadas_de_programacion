<?php
session_start();

// Control de acceso
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "admin") {
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
<button onclick=""modificar">modificar carrito</button>
<br>
<button onclick=""ver_viajes">aceptar o rechazar pedidos</button>

</body>
</html>