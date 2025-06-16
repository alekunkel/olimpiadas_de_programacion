<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registrarse"])) {
    $bd_nombre = "turismo";
    $bd_host = "localhost";
    $bd_usuario = "root";
    $bd_clave = "";

    // Sanitizar entradas
    $cli_nombre = trim($_POST["nombre"]);
    $cli_apellido = trim($_POST["apellido"]);
    $cli_telefono = trim($_POST["telefono"]);
    $cli_cod_postal = trim($_POST["codigo_postal"]);
    $cli_localidad = trim($_POST["localidad"]);
    $cli_email = trim($_POST["email"]);
    $cli_contra = trim($_POST["contraseña"]);
    $cli_confirmar = trim($_POST["confirmar"]);

    // Verificar que las contraseñas coincidan
    if ($cli_contra !== $cli_confirmar) {
        echo "<div class='alert alert-danger mt-3'>Las contraseñas no coinciden.</div>";
    } else {
        // Conectar a la base de datos
        $conexion = mysqli_connect($bd_host, $bd_usuario, $bd_clave, $bd_nombre);

        if (!$conexion) {
            die("<div class='alert alert-danger mt-3'>Error al conectar con la base de datos.</div>");
        }

        // Preparar consulta para evitar SQL Injection
        $sql_insertar = "INSERT INTO cliente 
            (Nombre, Apellido, Telefono, Codigo_postal, Localidad, Email, Contraseña) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conexion, $sql_insertar);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssss", $cli_nombre, $cli_apellido, $cli_telefono, $cli_cod_postal, $cli_localidad, $cli_email, $cli_contra);
            $resultado = mysqli_stmt_execute($stmt);

            if ($resultado) {
                mysqli_stmt_close($stmt);
                mysqli_close($conexion);
                header("Location: login.php");
                exit;
            } else {
                echo "<div class='alert alert-danger mt-3'>Error al registrar el cliente.</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger mt-3'>Error al preparar la consulta.</div>";
        }

        mysqli_close($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="styles/registro.css">
</head>
<body>
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