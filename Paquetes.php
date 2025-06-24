<?php
session_start();
$nombre_bd = "turismo";
$servidor = "localhost";
$usuario = "root";
$contraseña = "";

$conexion = mysqli_connect($servidor, $usuario, $contraseña, $nombre_bd);
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

function obtenerImagen($nombre) {
    $nombre = strtolower($nombre);
    if (str_contains($nombre, 'brasil')) return 'imagenes/brasil.jpg';
    if (str_contains($nombre, 'cancun')) return 'imagenes/Cancun.jpg';
    if (str_contains($nombre, 'paris')) return 'imagenes/Paris.jpg';
    if (str_contains($nombre, 'automovil')) return 'imagenes/Auto.jpg';
    if (str_contains($nombre, 'madrid')) return 'imagenes/Madrid.jpg';
    return 'img/default.jpg';
}

// Procesar envío del formulario (Agregar al carrito)
if (isset($_POST['agregar_carrito'])) {
    $ID_producto = intval($_POST['paquete_id']);
    $ID_cliente = $_SESSION['ID_cliente'];

    $consulta = "SELECT Cantidad, Precio FROM productos WHERE ID_producto = $ID_producto";
    $resultado = mysqli_query($conexion, $consulta);
    $producto = mysqli_fetch_assoc($resultado);

    if ($producto && $producto['Cantidad'] > 0) {
        $precio = $producto['Precio'];

        $insertar = "INSERT INTO carrito (ID_cliente, ID_producto, Cantidad, Precio_total, Estado, fecha_cargado)
                     VALUES ($ID_cliente, $ID_producto, 1, $precio, 'Pendiente', NOW())";
        $actualizar_stock = "UPDATE productos SET Cantidad = Cantidad - 1 WHERE ID_producto = $ID_producto";

        if (mysqli_query($conexion, $insertar) && mysqli_query($conexion, $actualizar_stock)) {
            echo "<script>alert('¡Paquete agregado al carrito correctamente!');</script>";
        } else {
            echo "<script>alert('Error al agregar al carrito.');</script>";
        }
    } else {
        echo "<script>alert('No hay stock disponible para este producto.');</script>";
    }
}

// Obtener productos
$sql = "SELECT ID_producto, Nombre, Calificacion, Cantidad, Precio FROM productos";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos - Productos</title>
    <link rel="stylesheet" href="styles/Paquete.css">
</head>
<body>
<div class="contenedor-tabla">
    <h1 class="titulo-formulario">Lista de Paquetes</h1>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Calificación</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acción</th>
            </tr>
            <?php while ($datos = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?= htmlspecialchars($datos['Nombre']) ?></td>
                    <td><?= $datos['Calificacion'] ?></td>
                    <td><?= $datos['Cantidad'] ?></td>
                    <td><?= $datos['Precio'] ?></td>
                    <td><img src="<?= obtenerImagen($datos['Nombre']) ?>" alt="<?= $datos['Nombre'] ?>" class="imagen-paquete"></td>
                    <td>
                        <?php if ($datos['Cantidad'] == 0): ?>
                            <span style="color: red; font-weight: bold;">Producto sin stock</span>
                        <?php else: ?>
        <form method="POST">
            <input type="hidden" name="paquete_id" value="<?= $datos['ID_producto'] ?>">
            <input type="submit" name="agregar_carrito" value="Agregar al carrito" class="btn-carrito">
        </form>
    <?php endif; ?>
</td>

                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class='mensaje'>
            <p>No hay datos disponibles.</p>
        </div>
    <?php endif; ?>

    <a href="carritocliente.php">Ver Carrito</a>
</div>
</body>
</html>