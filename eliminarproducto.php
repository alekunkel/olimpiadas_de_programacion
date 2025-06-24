<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <a href="homepage_admin.php" class="btn btn-outline-light mb-3">Inicio</a>

        <h1>Eliminar Productos</h1>

        <form method="post">
            <div class="mb-3">
                <label for="codigo">ID del producto</label>
                <input type="number" name="codigo" class="form-control" required>
            </div>
            <input type="submit" name="eliminar" value="Eliminar" class="btn btn-danger">
        </form>

        <?php
        if (isset($_POST["eliminar"])) {
            $nombre_bd = "turismo";
            $servidor = "localhost";
            $usuario = "root";
            $contraseña = "";

            $Codigo = intval($_POST["codigo"]);

            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $nombre_bd);

            if (!$conexion) {
                echo "<div class='alert alert-danger mt-3'>Error de conexión a la base de datos.</div>";
                exit;
            }

            // Verificar si el producto tiene pedidos relacionados
            $check = mysqli_query($conexion, "SELECT * FROM pedido WHERE ID_producto = $Codigo");

            if (mysqli_num_rows($check) > 0) {
                echo "<div class='alert alert-warning mt-3'>No se puede eliminar el paquete porque tiene pedidos asociados.</div>";
            } else {
                // Eliminar de la tabla 'paquetes'
                $sql = "DELETE FROM paquetes WHERE ID_paquete = $Codigo";
                $resultado = mysqli_query($conexion, $sql);

                if ($resultado) {
                    echo "<div class='alert alert-success mt-3'>Paquete eliminado correctamente.</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error al eliminar el paquete.</div>";
                }
            }

            mysqli_close($conexion);
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
