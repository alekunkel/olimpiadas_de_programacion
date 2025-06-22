<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <label for="medio_pago"></label>
        <input type="text" name="medio_pago" id="medio_pago" class="form-control" required>
    </form>

<?php
$conexion = new mysqli("localhost", "root", "", "turismo");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


$id_cliente = $_POST['ID_cliente'];
$medio_pago = $_POST['medio_pago'];
$fecha = date("Y-m-d H:i:s");

// 1. Traer productos del carrito
$carrito = $conexion->query("SELECT * FROM carrito WHERE ID_cliente = $id_cliente");

while ($item = $carrito->fetch_assoc()) {
    $id_producto = $item['ID_producto'];
    $cantidad = $item['Cantidad'];
    $total = $item['Precio_total'];

    // 2. Insertar en pedido
    $conexion->query("INSERT INTO pedido (ID_producto, ID_cliente, Medio_pago, Cantidad, Total_venta, fecha_pedido, Estado)
                      VALUES ('$id_producto', '$id_cliente', '$medio_pago', '$cantidad', '$total', '$fecha', 'Pendiente')");
}

// 3. Vaciar carrito
$conexion->query("DELETE FROM carrito WHERE ID_cliente = $id_cliente");

echo "✅ Compra confirmada. ¡Gracias por tu pedido!";
?>
</body>
</html>