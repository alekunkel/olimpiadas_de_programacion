<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="imagenes/Logo azul.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Pendientes</title>    
</head>

<body>
<header>
    Explora Viajes | Panel de Pedidos
</header>

<div class="container">
    <a href="homepage_admin.php" class="back">← Volver al inicio</a>
    <h1>Pedidos Pendientes</h1>

<?php
$conexion = new mysqli("localhost", "root", "", "turismo");

if ($conexion->connect_error) {
    die("<div class='alert alert-danger'>Error de conexión: " . $conexion->connect_error . "</div>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion'], $_POST['id_producto'], $_POST['id_cliente'], $_POST['fecha_pedido'])) {
    $accion = $_POST['accion'] === 'entregar' ? 'entregado' : 'cancelado';
    $id_producto = $conexion->real_escape_string($_POST['id_producto']);
    $id_cliente = $conexion->real_escape_string($_POST['id_cliente']);
    $fecha_pedido = $conexion->real_escape_string($_POST['fecha_pedido']);

    $consulta = $conexion->prepare("SELECT Cantidad FROM pedido WHERE ID_producto = ? AND ID_cliente = ? AND fecha_pedido = ?");
    $consulta->bind_param("iis", $id_producto, $id_cliente, $fecha_pedido);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $pedido = $resultado->fetch_assoc();
        $cantidad = intval($pedido['Cantidad']);

        if ($accion === 'entregado') {
            $update_stock = $conexion->prepare("UPDATE productos SET Cantidad = Cantidad - ? WHERE ID_producto = ?");
            $update_stock->bind_param("ii", $cantidad, $id_producto);
            $update_stock->execute();
            $update_stock->close();
        }

        // Actualizar estado del pedido
        $update_sql = $conexion->prepare("UPDATE pedido SET Estado = ? WHERE ID_producto = ? AND ID_cliente = ? AND fecha_pedido = ?");
        $update_sql->bind_param("siis", $accion, $id_producto, $id_cliente, $fecha_pedido);
        $update_sql->execute();
        $update_sql->close();
    }

    $consulta->close();
}
    
// Mostrar pedidos pendientes
$sql = "SELECT pe.fecha_pedido, p.ID_producto, p.Nombre AS nombre_producto, c.ID_cliente,
        CONCAT(c.Nombre, ' ', c.Apellido) AS nombre_cliente, pe.Medio_pago, pe.Cantidad, pe.Total_venta 
        FROM pedido pe
        INNER JOIN productos p ON p.ID_producto = pe.ID_producto
        INNER JOIN cliente c ON c.ID_cliente = pe.ID_cliente
        WHERE pe.Estado = 'pendiente'
        ORDER BY pe.fecha_pedido DESC";

$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    echo "<table>
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
                    <th>Acción</th>
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
                <td>\${$fila['Total_venta']}</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='id_producto' value='{$fila['ID_producto']}'>
                        <input type='hidden' name='id_cliente' value='{$fila['ID_cliente']}'>
                        <input type='hidden' name='fecha_pedido' value='{$fila['fecha_pedido']}'>
                        <button type='submit' name='accion' value='entregar'>Entregar</button>
                    </form>
                    <form method='POST'>
                        <input type='hidden' name='id_producto' value='{$fila['ID_producto']}'>
                        <input type='hidden' name='id_cliente' value='{$fila['ID_cliente']}'>
                        <input type='hidden' name='fecha_pedido' value='{$fila['fecha_pedido']}'>
                        <button type='submit' name='accion' value='cancelar'>Cancelar</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<div class='alert alert-warning'>No hay pedidos pendientes.</div>";
}

$conexion->close();
?>

</div>
</body>
</html>

<style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #0077cc;
            color: white;
            padding: 1rem 2rem;
            font-size: 1.5rem;
        }

        .container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 1rem;
        }

        h1 {
            color: #0077cc;
            text-align: center;
            margin-bottom: 2rem;
        }

        a.back {
            display: inline-block;
            background-color: #e9f1f7;
            color: #0077cc;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        thead {
            background-color: #0077cc;
            color: white;
        }

        th, td {
            padding: 0.75rem;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        form {
            display: inline;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            margin: 2px;
            transition: background-color 0.2s ease;
        }

        button[name="accion"][value="cancelar"] {
            background-color: #dc3545;
        }

        button:hover {
            opacity: 0.9;
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-top: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>