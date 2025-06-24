<?php
ob_start();
session_start();

$conexion = new mysqli("localhost", "root", "", "turismo");

if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["iniciar_sesion"])) {
    $usuario = trim($_POST["usuario"]);
    $contrasena = trim($_POST["contrasena"]);

    if ($usuario === "admin" && $contrasena === "Admin1234") {
        $_SESSION["usuario"] = "admin";
        $_SESSION["rol"] = "admin";
        header("Location: homepage_admin.php");
        exit;
    }

    $sql = "SELECT * FROM cliente WHERE Usuario = ? OR Email = ? LIMIT 1";
    $stmt = $conexion->prepare($sql);   
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $datos = $resultado->fetch_assoc()) {
        if (password_verify($contrasena, $datos["Contraseña"])) {
                $_SESSION["usuario_id"] = $datos["Email"];
    $_SESSION["usuario_nombre"] = $datos["Nombre"];
    $_SESSION["usuario_usuario"] = $datos["Usuario"];
    $_SESSION["usuario"] = $datos["Usuario"]; // ← Línea añadida
    $_SESSION["rol"] = "cliente";
    $_SESSION["ID_cliente"] = $datos["ID_cliente"];
            header("Location: homepage_cliente.php");
            exit;
        }
    }

    $mensaje = "<div class='alert alert-danger mt-3'>Usuario o contraseña incorrectos.</div>";

    $stmt->close();
}

$conexion->close();
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
                <button type="button" onclick="togglePassword('contrasena', this)" style="margin-left: 10px;">Mostrar</button>
            </div>
            <input type="submit" name="iniciar_sesion" value="Iniciar Sesión" class="btn btn-success">
        </form>

        <hr>
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>

    <script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        btn.textContent = "Ocultar";
    } else {
        input.type = "password";
        btn.textContent = "Mostrar";
    }
}
</script>

</body>
</html>
