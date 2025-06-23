<?php
ob_start();
session_start();
<<<<<<< HEAD
=======

$error = "";

>>>>>>> master
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registrarse"])) {
    $bd_nombre = "turismo";
    $bd_host = "localhost";
    $bd_usuario = "root";
    $bd_clave = "";

    $conexion = new mysqli($bd_host, $bd_usuario, $bd_clave, $bd_nombre);

    if ($conexion->connect_error) {
        die("Error al conectar con la base de datos: " . $conexion->connect_error);
    }

    $cli_nombre = trim($_POST["nombre"]);
    $cli_apellido = trim($_POST["apellido"]);
    $cli_usuario = trim($_POST["usuario"]);
    $cli_telefono = trim($_POST["telefono"]);
    $cli_cod_postal = trim($_POST["codigo_postal"]);
    $cli_localidad = trim($_POST["localidad"]);
    $cli_email = trim($_POST["email"]);
    $cli_contra = $_POST["contraseña"];
    $cli_confirmar = $_POST["confirmar"];

    if ($cli_contra !== $cli_confirmar) {
<<<<<<< HEAD
        echo "<div class='alert alert-warning mt-3'>Las contraseñas no coinciden.</div>";
        exit;
    }

    $cli_contra_hash = password_hash($cli_contra, PASSWORD_DEFAULT);

    // Preparar consulta
    $stmt = $conexion->prepare("INSERT INTO cliente (Nombre, Apellido, Telefono, Codigo_postal, Localidad, Email, Contraseña, Usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    // Bind de parámetros: "ssssssss" indica que todos son strings
    $stmt->bind_param("ssssssss", $cli_nombre, $cli_apellido, $cli_telefono, $cli_cod_postal, $cli_localidad, $cli_email, $cli_contra_hash, $cli_usuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        echo "<div class='alert alert-danger mt-3'>Error al registrar usuario: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conexion->close();
}
ob_end_flush();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
=======
        $error = "Las contraseñas no coinciden.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $cli_contra)) {
        $error =  "La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número.";
    } else {
        $consulta_usuario = $conexion->prepare("SELECT ID_cliente FROM cliente WHERE Usuario = ?");
        $consulta_usuario->bind_param("s", $cli_usuario);
        $consulta_usuario->execute();
        $consulta_usuario->store_result();
    
        if ($consulta_usuario->num_rows > 0) {
            $error = "El nombre de usuario ya está registrado. Por favor, elija otro.";
        } else {
            $cli_contra_hash = password_hash($cli_contra, PASSWORD_DEFAULT);

            $stmt = $conexion->prepare("INSERT INTO cliente (Nombre, Apellido, Telefono, Codigo_postal, Localidad, Email, Contraseña, Usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            if (!$stmt) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("ssssssss", $cli_nombre, $cli_apellido, $cli_telefono, $cli_cod_postal, $cli_localidad, $cli_email, $cli_contra_hash, $cli_usuario);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Error al registrar usuario: " . $stmt->error;
            }

            $stmt->close();
        }

        $consulta_usuario->close();
    }

    $conexion->close();
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
>>>>>>> master
    <title>Registrarse</title>
    <link rel="stylesheet" href="styles/registro.css">
</head>
<body>
<<<<<<< HEAD
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
                <label for="usuario">Nombre de usuario</label>
                <input type="text" id="usuario" name="usuario" class="form-control">
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
                <input type="password" id="password" name="contraseña" class="form-control" required>
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
=======

<a href="login.php" class="boton-inicio">Volver al inicio</a>

<form method="post">
    <?php if (!empty($error)): ?>
        <div class="mensaje-error"><?= $error ?></div>
    <?php endif; ?>

    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="usuario">Nombre de usuario</label>
        <input type="text" id="usuario" name="usuario" class="form-control" required>
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
        <div style="display: flex; align-items: center;">
            <input type="password" id="password" name="contraseña" class="form-control" required>
            <button type="button" onclick="togglePassword('password', this)" style="margin-left: 10px;">Mostrar</button>
        </div>
        <p style="font-size: 12px;">Debe tener al menos 8 caracteres, una letra mayúscula y un número.</p>
    </div>

    <div class="form-group">
        <label for="confirmar">Confirmar contraseña</label>
        <div style="display: flex; align-items: center;">
            <input type="password" id="confirmar" name="confirmar" class="form-control" required>
            <button type="button" onclick="togglePassword('confirmar', this)" style="margin-left: 10px;">Mostrar</button>
        </div>
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
>>>>>>> master
