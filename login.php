<?php
session_start();
$nombre_bd = "turismo";
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$conexion = mysqli_connect($servidor, $usuario, $contraseña, $nombre_bd);
if (!$conexion) {
    die("Error al conectar con la base de datos.");
}
$mensaje = "";

// INICIO DE SESIÓN
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["iniciar_sesion"])) {
    $usuariosesion = trim($_POST["usuario"]);
    $contrasena_sesion = trim($_POST["contrasena"]);
    $sql = "SELECT * FROM cliente WHERE (Nombre = ? OR Email = ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $usuariosesion, $usuariosesion);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    if ($resultado && $usuario_datos = mysqli_fetch_assoc($resultado)) {
        // Comparar contraseña en texto plano (versión simple)
        if ($usuario_datos["Contraseña"] === $contrasena_sesion) {
            $_SESSION["usuario_id"] = $usuario_datos["Email"];
            $_SESSION["usuario_nombre"] = $usuario_datos["Nombre"];
            header("Location: homepage_cliente.php");
            exit;
        } else {
            $mensaje = "<div class='alert alert-danger mt-3'>Contraseña incorrecta.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger mt-3'>Usuario no encontrado.</div>";
    }
    mysqli_stmt_close($stmt);
}
// REGISTRO
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registrarse"])) {
    if (
        isset($_POST["nombre"], $_POST["apellido"], $_POST["localidad"], $_POST["email"],
              $_POST["password"], $_POST["confirmar"])
    ) {
        $Nombreregistro = trim($_POST["nombre"]);
        $Apellidoregistro = trim($_POST["apellido"]);
        $Localidadregistro = trim($_POST["localidad"]);
        $Emailregistro = trim($_POST["email"]);
        $contraregistro = trim($_POST["password"]);
        $confirmar = trim($_POST["confirmar"]);
        $telregistro = isset($_POST["telefono"]) ? trim($_POST["telefono"]) : "";
        $cod_postalregistro = isset($_POST["codigo_postal"]) ? trim($_POST["codigo_postal"]) : "";
        if (!filter_var($Emailregistro, FILTER_VALIDATE_EMAIL)) {
            $mensaje = "<div class='alert alert-danger mt-3'>Correo electrónico no válido.</div>";
        } elseif ($contraregistro !== $confirmar) {
            $mensaje = "<div class='alert alert-danger mt-3'>Las contraseñas no coinciden.</div>";
        } else {
            $sql_check_email = "SELECT 1 FROM cliente WHERE Email = ?";
            $stmt_check = mysqli_prepare($conexion, $sql_check_email);
            mysqli_stmt_bind_param($stmt_check, "s", $Emailregistro);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_store_result($stmt_check);
            if (mysqli_stmt_num_rows($stmt_check) > 0) {
                $mensaje = "<div class='alert alert-warning mt-3'>El correo ya está registrado.</div>";
                mysqli_stmt_close($stmt_check);
            } else {
                mysqli_stmt_close($stmt_check);
                $sql = "INSERT INTO cliente (Nombre, Apellido, Telefono, Codigo_postal, Localidad, Email, Contraseña)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conexion, $sql);
                mysqli_stmt_bind_param(
                    $stmt, "sssssss",
                    $Nombreregistro, $Apellidoregistro, $telregistro,
                    $cod_postalregistro, $Localidadregistro, $Emailregistro, $contraregistro
                );
                if (mysqli_stmt_execute($stmt)) {
                    $mensaje = "<div class='alert alert-success mt-3'>Registro exitoso. Ahora puedes iniciar sesión.</div>";
                } else {
                    $mensaje = "<div class='alert alert-danger mt-3'>Error al registrar: " . mysqli_error($conexion) . "</div>";
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
}
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Regístrese o Inicie Sesión</title>
    <link rel="stylesheet" href="styles/login.css" />
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1>Iniciar Sesión</h1>
        <a href="index.html" class="btn btn-outline-light mb-3">Inicio</a>

        <?php if (!empty($mensaje)) echo $mensaje; ?>

        <form method="post">
            <div class="mb-3">
                <label>Nombre de usuario o correo electrónico</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Introduzca su contraseña</label>
                <input type="password" name="contrasena" class="form-control" required>
            </div>
            <input type="submit" name="iniciar_sesion" value="Iniciar Sesión" class="btn btn-success">
        </form>

        <hr>

        <h2>Registrarse</h2>
        <p>¿No tienes una cuenta? Regístrate aquí:</p>
        <form method="post">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="localidad">Localidad</label>
                <input type="text" id="localidad" name="localidad" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="confirmar">Confirmar contraseña</label>
                <input type="password" id="confirmar" name="confirmar" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" class="form-control">
            </div>

            <div class="form-group">
                <label for="codigo_postal">Código Postal</label>
                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control">
            </div>

            <input type="submit" name="registrarse" value="Registrarse" class="btn btn-success">
        </form>
    </div>
</body>
</html>
