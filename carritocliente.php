<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "turismo");

if ($conexion->connect_error) {
    die("<div class='alert alert-danger'>Error de conexión: " . $conexion->connect_error . "</div>");
}

if (!isset($_SESSION['ID_cliente'])) {
    echo "<div class='alert alert-danger'>Error: no se encontró el ID del cliente en la sesión.</div>";
    exit;
}
$ID_cliente = $_SESSION['ID_cliente'];

// Eliminar producto si viene por GET
if (isset($_GET['eliminar'])) {
    $id_carrito = intval($_GET['eliminar']);
    $conexion->query("DELETE FROM carrito WHERE ID_carrito = $id_carrito AND ID_cliente = $ID_cliente");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito</title>
    <link rel="stylesheet" href="styles\carrito.css">
    <style>
        body {
            background-image: url('imagenes/Paisaje1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            position: relative;
            overflow: auto;
        }
    </style>
</head>
<body>
    <a href="homepage_cliente.php">Inicio</a>
    <h1>Mi Carrito</h1>

<?php  
$sql = "SELECT 
            carrito.ID_carrito,
            carrito.fecha_cargado,
            carrito.Cantidad,
            carrito.Precio_total,
            carrito.Estado,
            productos.ID_producto,
            productos.Nombre AS nombre_producto
        FROM carrito
        INNER JOIN productos ON carrito.ID_producto = productos.ID_producto
        WHERE carrito.ID_cliente = $ID_cliente";
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    echo "<table class='table table-striped table-dark'>
            <thead> 
                <tr>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['fecha_cargado']}</td>
                <td>{$fila['nombre_producto']}</td>
                <td>{$fila['Cantidad']}</td>
                <td>{$fila['Precio_total']}</td>
                <td>{$fila['Estado']}</td>
                <td><a href='carritocliente.php?eliminar={$fila['ID_carrito']}' onclick='return confirm(\"¿Seguro que deseas eliminar este producto del carrito?\")'>Eliminar</a></td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<div class='alert alert-warning'>No hay productos en tu carrito.</div>";
}

$conexion->close();
?>

</body>
</html>
