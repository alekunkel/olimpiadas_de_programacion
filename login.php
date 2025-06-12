<?php
ob_start();
session_start();

$conexion = mysqli_connect("localhost", "root", "", "turismo");

if (!$conexion) {
    die("Error al conectar con la base de datos.");
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["iniciar_sesion"])) {
    $usuario = trim($_POST["usuario"]);
    $contrasena = trim($_POST["contrasena"]);

    $sql = "SELECT * FROM cliente WHERE Nombre = ? OR Email = ?";
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $usuario, $usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado && $datos = mysqli_fetch_assoc($resultado)) {
            if ($datos["Contraseña"] === $contrasena) {
                $_SESSION["usuario_id"] = $datos["Email"];
                $_SESSION["usuario_nombre"] = $datos["Nombre"];
                $_SESSION["usuario"] = $datos["Nombre"];
                $_SESSION["rol"] = "cliente";

                header("Location: homepage_cliente.php");
                exit;
            }
        }

        $mensaje = "<div class='alert alert-danger mt-3'>Usuario o contraseña incorrectos.</div>";
        mysqli_stmt_close($stmt);
    } else {
        $mensaje = "<div class='alert alert-danger mt-3'>Error al preparar la consulta.</div>";
    }
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles/login.css" />
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1>Iniciar Sesión</h1>
        <a href="index.html" class="btn btn-outline-light mb-3">Inicio</a>

        <?php if (!empty($mensaje)) echo $mensaje; ?>

        <form method="post">
            <div class="mb-3">
                <label for="usuario">Nombre de usuario o correo electrónico</label>
                <input type="text" name="usuario" id="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
            </div>
            <input type="submit" name="iniciar_sesion" value="Iniciar Sesión" class="btn btn-success">
        </form>

        <hr>
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
