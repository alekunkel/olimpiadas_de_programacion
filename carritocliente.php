<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "turismo");

if ($conexion->connect_error) {
    die("<div class='alert alert-danger'>Error de conexión: " . $conexion->connect_error . "</div>");
}

// ⚠️ Asegura que el cliente esté logueado
$id_cliente = $_SESSION['id_cliente'] ?? 1; // Reemplaza esto por una lógica real de login

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito</title>
    <link rel="stylesheet" href="styles/carrito.css">
</head>
<body>
    <a href="index.html">Inicio</a>
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
        INNER JOIN productos ON carrito.ID_producto = productos.ID_producto";

$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    echo "<table class='table table-striped table-dark'>
            <thead> 
                <tr>
                    <th>Fecha</th>
                    <th>ID Producto</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['fecha_cargado']}</td>
                <td>{$fila['ID_producto']}</td>
                <td>{$fila['nombre_producto']}</td>
                <td>{$fila['Cantidad']}</td>
                <td>{$fila['Precio_total']}</td>
                <td>{$fila['Estado']}</td>
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
