<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido Cliente</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?> (cliente)</h1>
    <p>Gracias por usar nuestros servicios.</p>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
