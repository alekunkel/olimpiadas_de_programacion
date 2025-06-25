<?php
ob_start();
session_start();

$form_data = $_SESSION['formulario'] ?? [];
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registrarse"])) {
    $bd_nombre = "turismo";
    $bd_host = "localhost";
    $bd_usuario = "root";
    $bd_clave = "";

    $conexion = new mysqli($bd_host, $bd_usuario, $bd_clave, $bd_nombre);

    if ($conexion->connect_error) {
        die("Error al conectar con la base de datos: " . $conexion->connect_error);
    }

    // Datos recibidos
    $cli_nombre = trim($_POST["nombre"]);
    $cli_apellido = trim($_POST["apellido"]);
    $cli_usuario = trim($_POST["usuario"]);
    $cli_telefono = trim($_POST["telefono"]);
    $cli_cod_postal = trim($_POST["codigo_postal"]);
    $cli_localidad = trim($_POST["localidad"]);
    $cli_email = trim($_POST["email"]);
    $cli_contra = $_POST["contraseña"];
    $cli_confirmar = $_POST["confirmar"];

    $_SESSION['formulario'] = [
        'nombre' => $cli_nombre,
        'apellido' => $cli_apellido,
        'usuario' => $cli_usuario,
        'telefono' => $cli_telefono,
        'codigo_postal' => $cli_cod_postal,
        'localidad' => $cli_localidad,
        'email' => $cli_email
    ];

    if ($cli_contra !== $cli_confirmar) {
        $error = "Las contraseñas no coinciden.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $cli_contra)) {
        $error = "La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número.";
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
                unset($_SESSION['formulario']);
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
    <link rel="icon" href="imagenes/Logo azul.png" type="image/png">
    <title>Registrarse</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f4f8;
            color: #1e1e1e;
        }

        form {
            max-width: 500px;
            margin: 60px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #0066cc;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #004f99;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .mensaje-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .boton-inicio {
            display: block;
            margin: 20px auto;
            text-align: center;
            color: #0066cc;
            text-decoration: none;
        }

        .boton-inicio:hover {
            text-decoration: underline;
        }

        button {
            background-color: transparent;
            border: none;
            color: #0066cc;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
        }

        p {
            font-size: 13px;
            margin: 0 0 10px;
        }
    </style>
</head>
<body>

<a href="login.php" class="boton-inicio">← Volver al inicio</a>

<form method="post">
    <h1>Registro</h1>

    <?php if (!empty($error)): ?>
        <div class="mensaje-error"><?= $error ?></div>
    <?php endif; ?>

    <p>La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número.</p>

    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($form_data['nombre'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" required value="<?= htmlspecialchars($form_data['apellido'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="usuario">Nombre de usuario</label>
        <input type="text" id="usuario" name="usuario" required value="<?= htmlspecialchars($form_data['usuario'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="localidad">Localidad</label>
        <input type="text" id="localidad" name="localidad" required value="<?= htmlspecialchars($form_data['localidad'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($form_data['email'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="password">Contraseña</label>
        <div style="display: flex; align-items: center;">
            <input type="password" id="password" name="contraseña" required>
            <button type="button" onclick="togglePassword('password', this)">Mostrar</button>
        </div>
    </div>

    <div class="form-group">
        <label for="confirmar">Confirmar contraseña</label>
        <div style="display: flex; align-items: center;">
            <input type="password" id="confirmar" name="confirmar" required>
            <button type="button" onclick="togglePassword('confirmar', this)">Mostrar</button>
        </div>
    </div>

    <div class="form-group">
        <label for="telefono">Teléfono</label>
        <input type="tel" id="telefono" name="telefono" value="<?= htmlspecialchars($form_data['telefono'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="codigo_postal">Código Postal</label>
        <input type="text" id="codigo_postal" name="codigo_postal" value="<?= htmlspecialchars($form_data['codigo_postal'] ?? '') ?>">
    </div>

    <input type="submit" name="registrarse" value="Registrarse">
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
