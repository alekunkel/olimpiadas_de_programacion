<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <a href="homepage_admin.php" class="btn btn-outline-light mb-3">Inicio</a>
        <h1>Agregar productos</h1>

        <!-- enctype necesario para subir archivos -->
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Precio</label>
                <input type="number" name="precio" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Cantidad</label>
                <input type="number" name="cantidad" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Calificación</label>
                <input type="text" name="calificacion" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Imagen</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
            </div>
            <input type="submit" name="agregar" value="Guardar" class="btn btn-success">
        </form>

        <?php
        if (isset($_POST["agregar"])) {
            $nombre_bd = "turismo";
            $servidor = "localhost";
            $usuario = "root";
            $contraseña = "";

            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $nombre_bd);
            if (!$conexion) {
                die("<div class='alert alert-danger mt-3'>Error de conexión.</div>");
            }

            $Nombre = $_POST["nombre"];
            $Precio = $_POST["precio"];
            $Cantidad = $_POST["cantidad"];
            $Calificacion = $_POST["calificacion"];

            $imagenNombre = null;

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $carpetaDestino = "imagenes/";
                if (!is_dir($carpetaDestino)) {
                    mkdir($carpetaDestino, 0755, true);
                }

                $imagenNombre = uniqid() . "-" . basename($_FILES["imagen"]["name"]);
                $rutaDestino = $carpetaDestino . $imagenNombre;

                if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
                    echo "<div class='alert alert-danger mt-3'>Error al subir la imagen.</div>";
                    exit;
                }
            }

            $sql = "INSERT INTO productos (Nombre, Calificacion, Cantidad, Precio, Imagen)
                    VALUES ('$Nombre', '$Calificacion', '$Cantidad', '$Precio', '$imagenNombre')";

            $resultado = mysqli_query($conexion, $sql);

            if ($resultado) {
                echo "<div class='alert alert-success mt-3'>Se ha agregado correctamente el producto.</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Error al guardar en la base de datos.</div>";
            }

            mysqli_close($conexion);
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
