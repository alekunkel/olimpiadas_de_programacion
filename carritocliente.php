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

if (isset($_GET['eliminar'])) {
    $id_carrito = intval($_GET['eliminar']);
    $conexion->query("DELETE FROM carrito WHERE ID_carrito = $id_carrito AND ID_cliente = $ID_cliente");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
    <link rel="icon" href="imagenes/Logo azul.png" type="image/png">
  <title>Mi Carrito</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('imagenes/Paisaje1.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .container {
      background: rgba(255, 255, 255, 0.95);
      max-width: 1000px;
      margin: 40px auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }

    h1, h2 {
      text-align: center;
      color: #0077cc;
    }

    a.volver {
      display: inline-block;
      margin-bottom: 20px;
      padding: 10px 15px;
      background: #0077cc;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      transition: 0.3s;
    }

    a.volver:hover {
      background: #005fa3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ccc;
    }

    th {
      background-color: #0077cc;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .btn-eliminar {
      background-color: #e74c3c;
      color: white;
      padding: 6px 12px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 14px;
      transition: background 0.3s;
    }

    .btn-eliminar:hover {
      background-color: #c0392b;
    }

    form {
      margin-top: 30px;
      text-align: center;
    }

    label {
      font-weight: bold;
    }

    select {
      padding: 10px;
      width: 200px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      margin-top: 15px;
      padding: 10px 20px;
      background-color: #28a745;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #218838;
    }

    .alert {
      text-align: center;
      padding: 15px;
      margin: 20px 0;
      border-radius: 6px;
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
</head>
<body>

<div class="container">
  <a href="homepage_cliente.php" class="volver">← Inicio</a>
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
    echo "<table>
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
                <td>\${$fila['Precio_total']}</td>
                <td>{$fila['Estado']}</td>
                <td><a class='btn-eliminar' href='carritocliente.php?eliminar={$fila['ID_carrito']}' onclick='return confirm(\"¿Seguro que deseas eliminar este producto del carrito?\")'>Eliminar</a></td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<div class='alert alert-warning'>No hay productos en tu carrito.</div>";
}

$conexion->close();
?>

  <h2>Finalizar compra</h2>
  <form method="POST" action="confirmarcompra.php">
    <input type="hidden" name="ID_cliente" value="<?php echo $_SESSION['ID_cliente']; ?>">

    <label for="medio_pago">Seleccioná el medio de pago:</label><br><br>
    <select name="medio_pago" id="medio_pago" required>
        <option value="" disabled selected>Elegí una opción</option>
        <option value="tarjeta">Tarjeta de débito o crédito</option>
        <option value="MP">Mercado Pago</option>
        <option value="uala">Ualá</option>
        <option value="naranja">Naranja X</option>
    </select>
    <br><br>
    <button type="submit">Confirmar compra</button>
  </form>
</div>

</body>
</html>
