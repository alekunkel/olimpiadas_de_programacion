<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/carrito.css">
<<<<<<< HEAD
    <title>Carrito</title>  
    <style>
        
    </style>
</head>
<body>
    <a href="index.html">Inicio</a>
    <h1>Carrito</h1>
=======
    <title>Carrito</title>
</head>
<body>
    <a href="homepage_admin.php">Inicio</a>
    <h1>Pedidos pendientes</h1>
>>>>>>> master

<?php
    $conexion = new mysqli("localhost", "root", "", "turismo");

    if ($conexion->connect_error) {
        die("<div class='alert alert-danger'>Error de conexión: " . $conexion->connect_error . "</div>");
    }

<<<<<<< HEAD
    // Manejar acciones de los botones
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && isset($_POST['id_producto']) && isset($_POST['id_cliente']) && isset($_POST['fecha_pedido'])) {
        $accion = $_POST['accion'] === 'entregar' ? 'entregado' : 'pendiente';
        $id_producto = $conexion->real_escape_string($_POST['id_producto']);
        $ID_cliente = $conexion->real_escape_string($_POST['ID_cliente']);
=======
    // Manejar acciones del admin
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && isset($_POST['id_producto']) && isset($_POST['id_cliente']) && isset($_POST['fecha_pedido'])) {
        $accion = $_POST['accion'] === 'entregar' ? 'entregado' : 'cancelado';
        $id_producto = $conexion->real_escape_string($_POST['id_producto']);
        $id_cliente = $conexion->real_escape_string($_POST['id_cliente']);
>>>>>>> master
        $fecha_pedido = $conexion->real_escape_string($_POST['fecha_pedido']);

        $update_sql = "UPDATE pedido 
                       SET Estado = '$accion' 
                       WHERE ID_producto = '$id_producto' 
<<<<<<< HEAD
                       AND ID_cliente = '$ID_cliente' 
=======
                       AND ID_cliente = '$id_cliente' 
>>>>>>> master
                       AND fecha_pedido = '$fecha_pedido'";

        $conexion->query($update_sql);
    }
<<<<<<< HEAD
    
$sql = 'SELECT pe.fecha_pedido, p.ID_producto, p.Nombre AS nombre_producto, c.ID_cliente,
        CONCAT(c.Nombre, " ", c.Apellido) AS nombre_cliente, pe.Medio_pago, pe.Cantidad, pe.Total_venta 
        FROM pedido pe
        INNER JOIN productos p ON p.ID_producto = pe.ID_producto
        INNER JOIN cliente c ON c.ID_cliente = pe.ID_cliente';
=======

    // Solo pedidos pendientes
    $sql = "SELECT pe.fecha_pedido, p.ID_producto, p.Nombre AS nombre_producto, c.ID_cliente,
            CONCAT(c.Nombre, ' ', c.Apellido) AS nombre_cliente, pe.Medio_pago, pe.Cantidad, pe.Total_venta 
            FROM pedido pe
            INNER JOIN productos p ON p.ID_producto = pe.ID_producto
            INNER JOIN cliente c ON c.ID_cliente = pe.ID_cliente
            WHERE pe.Estado = 'pendiente'
            ORDER BY pe.fecha_pedido DESC";
>>>>>>> master

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
<<<<<<< HEAD
                        <th>Accion</th>
=======
                        <th>Acción</th>
>>>>>>> master
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
<<<<<<< HEAD
                            <input type='hidden' name='ID_cliente' value='{$fila['ID_cliente']}'>
=======
                            <input type='hidden' name='id_cliente' value='{$fila['ID_cliente']}'>
>>>>>>> master
                            <input type='hidden' name='fecha_pedido' value='{$fila['fecha_pedido']}'>
                            <button type='submit' name='accion' value='entregar'>Entregar</button>
                        </form>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='id_producto' value='{$fila['ID_producto']}'>
<<<<<<< HEAD
                            <input type='hidden' name='ID_cliente' value='{$fila['ID_cliente']}'>
=======
                            <input type='hidden' name='id_cliente' value='{$fila['ID_cliente']}'>
>>>>>>> master
                            <input type='hidden' name='fecha_pedido' value='{$fila['fecha_pedido']}'>
                            <button type='submit' name='accion' value='cancelar'>Cancelar</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
<<<<<<< HEAD
        echo "<div class='alert alert-warning'>No hay registros de ventas.</div>";
=======
        echo "<div class='alert alert-warning'>No hay pedidos pendientes.</div>";
>>>>>>> master
    }

    $conexion->close();
?>
<<<<<<< HEAD
</div>
</body>
</html>
=======
</body>
</html>
>>>>>>> master
