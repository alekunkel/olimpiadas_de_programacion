<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Modificar Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <a href="homepage_admin.php" class="btn btn-outline-light mb-3">Inicio</a>

        <h1>Modificar Productos</h1>

        <!-- Formulario único, con enctype para subir archivos -->
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>ID</label>
                <input type="text" name="id" class="form-control" required />
            </div>

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required />
            </div>

            <div class="mb-3">
                <label>Calificación</label>
                <select name="calificacion" class="form-select" required>
                    <option value="1">1 Estrella</option>
                    <option value="2">2 Estrellas</option>
                    <option value="3">3 Estrellas</option>
                    <option value="4">4 Estrellas</option>
                    <option value="5">5 Estrellas</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Precio</label>
                <input type="number" name="precio" class="form-control" required min="0" step="0.01" />
            </div>

            <div class="mb-3">
                <label>Cantidad</label>
                <input type="number" name="cantidad" class="form-control" required min="0" />
            </div>

            <div class="mb-3">
                <label>Imagen</label>
                <input type="file" name="imagen" class="form-control" accept="image/*" />
            </div>

            <input type="submit" name="modificar" value="Modificar" class="btn btn-warning" />
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
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
    if (!$conexion) {
        echo "<div class='alert alert-danger text-center mt-3'>Error de conexión a la base de datos.</div>";
        exit;
    }

    // Procesar imagen si fue cargada
    $imagenNombre = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $carpetaDestino = "imagenes/"; // ← corregido
        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0755, true);
        }

        $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
        $imagenNombre = uniqid() . "." . $extension;
        $rutaDestino = $carpetaDestino . $imagenNombre;

        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
            echo "<div class='alert alert-danger text-center mt-3'>Error al subir la imagen.</div>";
            exit;
        }
    }

    // Armar SQL con o sin imagen
    if ($imagenNombre) {
        $sql = "UPDATE productos SET Nombre='$Nombre', Calificacion='$Seccion', Precio='$Precio', Cantidad='$cantidad', Imagen='$imagenNombre' WHERE ID_producto = '$Codigo'";
    } else {
        $sql = "UPDATE productos SET Nombre='$Nombre', Calificacion='$Seccion', Precio='$Precio', Cantidad='$cantidad' WHERE ID_producto = '$Codigo'";
    }

    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        echo "<div class='alert alert-success text-center mt-3'>Se han modificado correctamente los datos.</div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Error al modificar los datos: " . mysqli_error($conexion) . "</div>";
    }

    mysqli_close($conexion);
}
?>
