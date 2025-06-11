<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css" />
    <title>regístrese o inicie sesión</title>
</head>
<body class="bg-dark text-white">

    <div class="container mt-5">
        
        <h1>iniciar sesión</h1>
        <a href="index.html" class="btn btn-outline-light mb-3">Inicio</a>

        <form method="post">
            <div class="mb-3">
                <label>nombre de usuario o correo electrónico</label>
                <input type="text" name="usuario o correo electrónico" class="form-control"required>
            </div>
            <div class="contraseña">
                <label>introduzca su contraseña </label>
                <input type="text" name="contraseña" class="form-control"required>
                </div>
            <input type="submit" name="agregar" value="Iniciar Sesión" class="btn btn-success">
        </form><br>
<h2>registrarse </h2>
<p>No tienes una cuenta?, registrate aquí </p>
            <form action="#" method="post">
      <div class="form-group">
        <label for="nombre">Nombre completo</label>
        <input type="text" id="nombre" name="nombre" class="form-control" required>
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
      
      <input type="submit" value="Registrarse" class="btn btn-success">
    </form>
        <?php
        // Conexión a la base
        if(isset($_POST["agregar"])){
            $nombre_bd = "cine_ciudad";
            $servidor = "localhost";
            $usuario = "root";
            $contraseña = "";

            $Nombre = $_POST["nombre"];
            $Email = $_POST["email"];
            $Telefono = $_POST["telefono"];
            $Fecha_registro = $_POST["fecha"];

            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $nombre_bd);
            $sql = "INSERT INTO `clientes`(`nombre`, `email`, `telefono`, `fecha_registro`) 
                    VALUES ('$Nombre','$Email','$Telefono','$Fecha_registro')";

            $resultado = mysqli_query($conexion, $sql);

            if($resultado == "true"){
                echo "<div class='alert alert-success mt-3'>Se han agregado correctamente los clientes.</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Error de conexión.</div>";
            }
        }
        ?>
    </div>
</body>
</html>
