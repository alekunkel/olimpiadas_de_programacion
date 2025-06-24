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
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Historial de Compras</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 8px;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    a {
      display: inline-block;
      margin-bottom: 20px;
      text-decoration: none;
      color: white;
      background: #0077cc;
      padding: 10px 20px;
      border-radius: 5px;
      transition: background 0.3s;
    }

    a:hover {
      background: #005fa3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #0077cc;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .estado {
      font-weight: bold;
      color: #0077cc;
    }
  </style>
</head>
<body>

<div class="container">
  <a href="homepage_cliente.php">← Volver a la página principal</a>
  <h2>Historial de compras</h2>

  <?php
  if ($resultado && $resultado->num_rows > 0) {
      echo "<table>
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
                  <td>\${$fila['Total_venta']}</td>
                  <td>{$fila['Medio_pago']}</td>
                  <td>{$fila['fecha_pedido']}</td>
                  <td class='estado'>{$fila['Estado']}</td>
                </tr>";
      }
      echo "</table>";
  } else {
      echo "<p style='text-align:center; color: #555;'>Todavía no tenés pedidos realizados.</p>";
  }

  $conexion->close();
  ?>
</div>

</body>
</html>
