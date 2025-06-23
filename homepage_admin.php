<<<<<<< HEAD
<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida Administrador</title>
</head>
<body>
    <h1>Bienvenido Administrador</h1>
<a href="index.html">cerrar sesión</a>
    <br> 
<a href="tabla_historica.php">ver tabla histórica de ventas</a>
<br>
    <a href="carrito.php">Ver carrito de clientes</a>
</body>
</html>
=======
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Panel de Control</title>
  <link rel="stylesheet" href="styles/homepage_admin.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

        if ($conexion->connect_error) {
            echo "<p style='color:red;'>Error de conexión: " . $conexion->connect_error . "</p>";
        } else {
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

        if ($conexion->connect_error) {
            echo "<p style='color:red;'>Error de conexión: " . $conexion->connect_error . "</p>";
        } else {
            $sql = "SELECT COUNT(*) as total FROM productos";
            $resultado = $conexion->query($sql);
            $fila = $resultado->fetch_assoc();
            echo "<p>" . $fila['total'] . "</p>";
        }
        ?>
        <p><a href="insertarproducto.php" class="btn btn-sm btn-success">Agregar</a></p>
        <p><a href="modificarproducto.php" class="btn btn-sm btn-info">Modificar</a></p>

        </div>

      <div class="card"> <a href="carrito.php">
        <i class="fas fa-file-invoice-dollar"></i>
        <h4>Ventas</h4>
        <?php
        $conexion = new mysqli("localhost", "root", "", "turismo");

        if ($conexion->connect_error) {
            echo "<p style='color:red;'>Error de conexión: " . $conexion->connect_error . "</p>";
        } else {
            $sql = "SELECT COUNT(*) as total FROM pedido WHERE Estado = 'pendiente'";
            $resultado = $conexion->query($sql);
            $fila = $resultado->fetch_assoc();
            echo "<p>" . $fila['total'] . "</p>";
        }
        ?>
      </a></div>

    </div>
  </main>

</body>
</html>
>>>>>>> master
