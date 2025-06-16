<?php
session_start();

// Control de acceso
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
    <h1>Bienvenido Administrador: <?php echo $_SESSION['usuario']; ?></h1>

    <p>Aquí podés ver el panel de administración.</p>
</body>
</html>