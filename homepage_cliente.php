<?php
session_start();

// Control de acceso
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'cliente') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida Cliente</title>
</head>
<body>
    <h1>Bienvenido Cliente: <?php echo $_SESSION['usuario']; ?></h1>

    <p>Gracias por usar nuestros servicios.</p>

</body>
</html>
