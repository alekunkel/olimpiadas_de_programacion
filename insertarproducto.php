<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine Ciudad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <a href="homepage_admin.php" class="btn btn-outline-light mb-3">Inicio</a>
    <h1>Agregar productos</h1>
    <form method="post">
        <div class="mb-3">
        <label for="">Nombre</label>
        <input type="text" name="nombre" class="form-control"><br>
        </div>
        <div class="mb-3">
        <label for="">Precio</label>
        <input type="number" name="precio" class="form-control"><br>
        </div>
        <div class="mb-3">
        <label for="">Cantidad</label>
        <input type="number" name="cantidad" class="form-control"><br>
        </div>
        <div class="mb-3">
        <label for="">Calificacion</label>
        <input type="text" name="calificacion" class="form-control"><br>
        </div>
        <input type="submit" name="agregar" value="Guardar" class="btn btn-success">
    </form>

<?php

//conexion a la base 
if(isset($_POST["agregar"])){

    $nombre_bd = "turismo";
    $servidor = "localhost";
    $usuario = "root";
    $contraseña = "";

$Nombre = $_POST["nombre"];
$Precio = $_POST["precio"];
$Cantidad = $_POST["cantidad"];
$Calificacion = $_POST["calificacion"];

$conexion = mysqli_connect($servidor,$usuario,$contraseña,$nombre_bd);
$sql = "INSERT INTO `productos`(`Nombre`, `Calificacion`, `Cantidad`, `Precio`)
VALUES ('$Nombre','$Calificacion','$Cantidad','$Precio')";

$resultado = mysqli_query($conexion,$sql);

if($resultado == "true"){
                echo "<div class='alert alert-success mt-3'>Se han agregado correctamente los clientes.</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Error de conexión.</div>";
            }
        }

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>