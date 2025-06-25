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
            $_SESSION["usuario"] = $datos["Usuario"];
            $_SESSION["rol"] = "cliente";
            $_SESSION["ID_cliente"] = $datos["ID_cliente"];
            header("Location: homepage_cliente.php");
            exit;
        }
    }

    $mensaje = "<div class='alert'>Usuario o contraseña incorrectos.</div>";

    $stmt->close();
}

$conexion->close();
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="imagenes/Logo azul.png" type="image/png">
    <title>Iniciar Sesión</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f4f8;
            color: #1e1e1e;
        }

        .container {
            max-width: 400px;
            margin: 80px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #0066cc;
            margin-bottom: 30px;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        button {
            background-color: transparent;
            border: none;
            color: #0066cc;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #0066cc;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #004f99;
        }

        .alert {
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        .back-home {
            display: inline-block;
            margin-bottom: 20px;
            color: #0066cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <a href="index.html" class="back-home">← Volver al inicio</a>

        <?php if (!empty($mensaje)) echo $mensaje; ?>

        <form method="post">
            <label for="usuario">Usuario o correo electrónico</label>
            <input type="text" name="usuario" id="usuario" required>

            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" required>
            <br>
            <button type="button" onclick="togglePassword('contrasena', this)">Mostrar</button>
<br>
            <input type="submit" name="iniciar_sesion" value="Iniciar Sesión">
        </form>

        <p>¿No tenés cuenta? <a href="registro.php">Registrate aquí</a></p>
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
