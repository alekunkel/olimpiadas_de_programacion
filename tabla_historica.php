<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <link rel="stylesheet" href="styles/carrito.css">
    <title>Tabla histórica</title>  
</head>
<body>
    <a href="homepage_admin.php">volver al panel de administración</a>
    <h1>Tabla histórica</h1>

<?php
    $conexion = new mysqli("localhost", "root", "", "turismo");

    if ($conexion->connect_error) {
        die("<div class='alert alert-danger'>Error de conexión: " . $conexion->connect_error . "</div>");
    }

    // Manejar acciones de los botones
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && isset($_POST['id_producto']) && isset($_POST['id_cliente']) && isset($_POST['fecha_pedido'])) {
        $accion = $_POST['accion'] === 'entregar' ? 'entregado' : 'pendiente';
        $id_producto = $conexion->real_escape_string($_POST['id_producto']);
        $id_cliente = $conexion->real_escape_string($_POST['id_cliente']);
        $fecha_pedido = $conexion->real_escape_string($_POST['fecha_pedido']);

        $update_sql = "UPDATE pedido 
                       SET Estado = '$accion' 
                       WHERE ID_producto = '$id_producto' 
                       AND ID_cliente = '$id_cliente' 
                       AND fecha_pedido = '$fecha_pedido'";

        $conexion->query($update_sql);
    }

    $sql = 'SELECT pe.fecha_pedido, p.ID_producto, p.Nombre AS nombre_producto, c.ID_cliente,
            CONCAT(c.Nombre, " ", c.Apellido) AS nombre_cliente, pe.Medio_pago, pe.Cantidad, pe.Total_venta 
            FROM pedido pe
            INNER JOIN productos p ON p.ID_producto = pe.ID_producto
            INNER JOIN cliente c ON c.ID_cliente = pe.ID_cliente';

    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        echo "<table class='table table-striped table-dark'>
                <thead> 
                    <tr>
                        <th>Fecha del Pedido</th>
                        <th>ID Producto</th>
                        <th>Producto</th>
                        <th>ID Cliente</th>
                        <th>Cliente</th>
                        <th>Medio de Pago</th>
                        <th>Cantidad</th>
                        <th>Total Venta</th>
                    </tr>
                </thead>
                <tbody>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['fecha_pedido']}</td>
                    <td>{$fila['ID_producto']}</td>
                    <td>{$fila['nombre_producto']}</td>
                    <td>{$fila['ID_cliente']}</td>
                    <td>{$fila['nombre_cliente']}</td>
                    <td>{$fila['Medio_pago']}</td>
                    <td>{$fila['Cantidad']}</td>
                    <td>{$fila['Total_venta']}</td>
                    <td>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='id_producto' value='{$fila['ID_producto']}'>
                            <input type='hidden' name='id_cliente' value='{$fila['ID_cliente']}'>
                            <input type='hidden' name='fecha_pedido' value='{$fila['fecha_pedido']}'>
                        </form>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='id_producto' value='{$fila['ID_producto']}'>
                            <input type='hidden' name='id_cliente' value='{$fila['ID_cliente']}'>
                            <input type='hidden' name='fecha_pedido' value='{$fila['fecha_pedido']}'>
                            
                        </form>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning'>No hay registros de ventas.</div>";
    }

    $conexion->close();
?>
</div>
</body>
</html>
=======
    <title>Document</title>
</head>
<body>
    <a href="homepage_cliente.php">Volver a la página principal</a>
</body>
</html>
<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "turismo");

if (!isset($_SESSION['ID_cliente'])) {
    echo "Tenés que iniciar sesión.";
    exit;
}

$id_cliente = $_SESSION['ID_cliente'];

$sql = "SELECT 
            p.Nombre AS nombre_producto, 
            SUM(pe.Cantidad) AS Cantidad, 
            SUM(pe.Total_venta) AS Total_venta, 
            pe.Medio_pago, 
            DATE(pe.fecha_pedido) AS fecha_pedido, 
            pe.Estado
        FROM pedido pe
        INNER JOIN productos p ON p.ID_producto = pe.ID_producto
        WHERE pe.ID_cliente = '$id_cliente'
        GROUP BY p.Nombre, pe.Medio_pago, DATE(pe.fecha_pedido), pe.Estado
        ORDER BY fecha_pedido DESC";


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
>>>>>>> master
