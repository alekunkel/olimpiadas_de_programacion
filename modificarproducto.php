<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Productos</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

    <div class="container mt-5">
        <a href="homepage_admin.php" class="btn btn-outline-light mb-3">Inicio</a>

        <h1>Modificar Productos</h1>

        <form method="post">
            <div class="mb-3">
                <label>ID</label>
                <input type="text" name="id" class="form-control">
            </div>

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control">
            </div>
            <div class="mb-3">
                <label>Calificación</label>
                <select name="calificacion" class="form-select">
                    <option value="1">1 Estrella</option>
                    <option value="2">2 Estrellas</option>
                    <option value="3">3 Estrellas</option>
                    <option value="4">4 Estrellas</option>
                    <option value="5">5 Estrellas</option>
                </select>

            <div class="mb-3">
                <label>Precio</label>
                <input type="number" name="precio" class="form-control">
            </div>

            <div class="mb-3">
                <label>Cantidad</label>
                <input type="number" name="cantidad" class="form-control">
            </div>

            <input type="submit" name="modificar" value="Modificar" class="btn btn-warning">
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Conexión a la base 
if (isset($_POST["modificar"])) {

    $nombre_bd = "turismo";
    $servidor = "localhost";
    $usuario = "root";
    $contraseña = "";

    $Nombre = $_POST["nombre"];
    $Seccion = $_POST["calificacion"];
    $Precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    $Codigo = $_POST["id"];

    $conexion = mysqli_connect($servidor, $usuario, $contraseña, $nombre_bd);

    $sql = "UPDATE `productos` SET `Nombre`='$Nombre', `Calificacion`='$Seccion', `Precio`='$Precio', `Cantidad`='$cantidad' WHERE ID_producto = '$Codigo'";

    $resultado = mysqli_query($conexion, $sql);

    if ($resultado == "true") {
        echo "<div class='alert alert-success text-center mt-3'>Se han modificado correctamente los datos.</div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Error de conexión.</div>";
    }
}
?>
