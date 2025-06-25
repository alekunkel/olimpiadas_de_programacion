<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="imagenes/Logo azul.png" type="image/png">
  <title>Panel de Control</title>
  <link rel="stylesheet" href="styles/homepage_admin.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Barra superior -->
  <header class="topbar">
    <div class="titulo">Sistema Facturación</div>
    <div class="usuario-info">
      <?php
        date_default_timezone_set('America/Argentina/Cordoba');
        setlocale(LC_TIME, 'es_ES.UTF-8', 'spanish');
        echo strftime('%d de %B de %Y - %H:%M');
      ?> | ADMIN
    </div>
  </header>

  <!-- Navegación -->
  <nav class="navbar">
    <a href="index.html">Salir</a>
  </nav>

  <!-- Panel de control -->
  <main class="dashboard">
    <h2>Panel de control</h2>

    <div class="cards">

      <div class="card"><a href="listaclientes.php">
        <i class="fas fa-user-friends"></i>
        <h4>Clientes</h4>
        <?php
        $conexion = new mysqli("localhost", "root", "", "turismo");
        if (!$conexion->connect_error) {
            $sql = "SELECT COUNT(*) as total FROM cliente";
            $resultado = $conexion->query($sql);
            $fila = $resultado->fetch_assoc();
            echo "<p>" . $fila['total'] . "</p>";
        }
        ?>
      </a></div>

      <div class="card">
        <i class="fas fa-box"></i>
        <h4>Productos</h4>
        <?php
        $conexion = new mysqli("localhost", "root", "", "turismo");
        if (!$conexion->connect_error) {
            $sql = "SELECT COUNT(*) as total FROM productos WHERE Activo = 1";
            $resultado = $conexion->query($sql);
            $fila = $resultado->fetch_assoc();
            echo "<p>" . $fila['total'] . "</p>";
        }
        ?>
        <p><a href="insertarproducto.php" class="btn btn-sm btn-success">Agregar</a></p>
        <p><a href="modificarproducto.php" class="btn btn-sm btn-info">Modificar</a></p>
      </div>

      <div class="card"><a href="carrito.php">
        <i class="fas fa-file-invoice-dollar"></i>
        <h4>Ventas</h4>
        <?php
        $conexion = new mysqli("localhost", "root", "", "turismo");
        if (!$conexion->connect_error) {
            $sql = "SELECT COUNT(*) as total FROM pedido WHERE Estado = 'pendiente'";
            $resultado = $conexion->query($sql);
            $fila = $resultado->fetch_assoc();
            echo "<p>" . $fila['total'] . "</p>";
        }
        ?>
      </a></div>

    </div>
  </main>

  <!-- Listado de productos -->
  <hr class="mt-5 mb-4">
  <div class="container">
    <h3 class="text-success">Listado de Productos Disponibles</h3>

    <?php
    $conexion = new mysqli("localhost", "root", "", "turismo");
    if ($conexion->connect_error) {
        echo "<div class='alert alert-danger'>Error al conectar con la base de datos: " . $conexion->connect_error . "</div>";
    } else {
        // Si se envió el formulario de eliminación (borrado lógico)
        if (isset($_POST['eliminar'])) {
            $idEliminar = intval($_POST['id_producto']);
            $conexion->query("UPDATE productos SET Activo = 0 WHERE ID_producto = $idEliminar");
        }

        $sql = "SELECT ID_producto, Nombre, Calificacion, Precio, Cantidad, Imagen FROM productos WHERE Activo = 1 ORDER BY ID_producto DESC";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-hover table-striped text-center align-middle'>";
            echo "<thead class='table-dark'>";
            echo "<tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Calificación</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                  </tr>";
            echo "</thead><tbody>";

            while ($producto = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$producto['ID_producto']}</td>";
                echo "<td>" . htmlspecialchars($producto['Nombre']) . "</td>";
                echo "<td>{$producto['Calificacion']} ⭐</td>";
                echo "<td>$" . number_format($producto['Precio'], 2) . "</td>";
                echo "<td>{$producto['Cantidad']}</td>";

                if (!empty($producto['Imagen'])) {
                    echo "<td><img src='imagenes/{$producto['Imagen']}' alt='Imagen' width='80' height='60' style='object-fit:cover; border-radius:6px;'></td>";
                } else {
                    echo "<td><img src='img/default.jpg' alt='Sin imagen' width='80' height='60'></td>";
                }

                echo "<td>
                        <form method='POST' onsubmit=\"return confirm('¿Seguro que deseas eliminar este producto?');\">
                          <input type='hidden' name='id_producto' value='{$producto['ID_producto']}'>
                          <button type='submit' name='eliminar' class='btn btn-sm btn-danger'>
                            <i class='fas fa-trash'></i> Eliminar
                          </button>
                        </form>
                      </td>";
                echo "</tr>";
            }

            echo "</tbody></table></div>";
        } else {
            echo "<p class='text-warning'>No hay productos cargados aún.</p>";
        }

        $conexion->close();
    }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
