<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <a href="homepage_admin.php" class="btn btn-outline-light mb-3">Inicio</a>

        <h1>Listado de Clientes</h1>

        <div class="table-responsive">
            <table class="table table-dark table-bordered table-hover">
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Conexión a la base
                    $nombre_bd = "turismo";
                    $servidor = "localhost";
                    $usuario = "root";
                    $contraseña = "";

                    $conexion = mysqli_connect($servidor, $usuario, $contraseña, $nombre_bd);
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

                    $resultado = mysqli_query($conexion, $sql);

                    while ($datos = mysqli_fetch_row($resultado)) {
                        echo "<tr>";
                        foreach ($datos as $dato) {
                            echo "<td>" . htmlspecialchars($dato) . "</td>";
                        }
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
