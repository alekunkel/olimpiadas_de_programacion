<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="imagenes/Logo azul.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            color: #333;
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

        h1 {
            color: #0077cc;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 0.75rem;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        thead {
            background-color: #0077cc;
            color: white;
        }

        tr:hover {
            background-color: #f2f8ff;
        }

        .table-container {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <header>
        Explora Viajes | Listado de Clientes
    </header>

    <div class="container">
        <a href="homepage_admin.php" class="back">← Volver al inicio</a>
        <h1>Listado de Clientes</h1>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Localidad</th>
                        <th>Total Ventas</th>
                        <th>Total Gastado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conexion = new mysqli("localhost", "root", "", "turismo");

                    if ($conexion->connect_error) {
                        echo "<tr><td colspan='8'>Error de conexión</td></tr>";
                        exit;
                    }

                    $sql = "SELECT 
                                c.ID_cliente, 
                                c.Nombre, 
                                c.Apellido, 
                                c.Email, 
                                c.Telefono, 
                                c.Localidad, 
                                COUNT(p.ID_pedido) AS total_ventas,
                                SUM(p.Total_venta) AS total_gastado
                            FROM cliente c
                            LEFT JOIN pedido p ON c.ID_cliente = p.ID_cliente AND p.Estado = 'entregado'
                            GROUP BY c.ID_cliente, c.Nombre, c.Apellido, c.Email, c.Telefono, c.Localidad";

                    $resultado = $conexion->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($datos = $resultado->fetch_row()) {
                            echo "<tr>";
                            foreach ($datos as $dato) {
                                echo "<td>" . htmlspecialchars($dato ?? '-') . "</td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No hay clientes registrados.</td></tr>";
                    }

                    $conexion->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
