<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "turismo");

if (!isset($_SESSION['ID_cliente'])) {
    echo "Tenés que iniciar sesión.";
    exit;
}

$id_cliente = $_SESSION['ID_cliente'];

$sql = "SELECT p.Nombre AS nombre_producto, pe.Cantidad, pe.Total_venta, pe.Medio_pago, pe.fecha_pedido, pe.Estado
        FROM pedido pe
        INNER JOIN productos p ON p.ID_producto = pe.ID_producto
        WHERE pe.ID_cliente = '$id_cliente'
        ORDER BY pe.fecha_pedido DESC";

$resultado = $conexion->query($sql);

echo "<h2>Historial de compras</h2>";

if ($resultado && $resultado->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Método de Pago</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['nombre_producto']}</td>
                <td>{$fila['Cantidad']}</td>
                <td>{$fila['Total_venta']}</td>
                <td>{$fila['Medio_pago']}</td>
                <td>{$fila['fecha_pedido']}</td>
                <td><strong>{$fila['Estado']}</strong></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Todavía no tenés pedidos realizados.";
}

$conexion->close();
?>