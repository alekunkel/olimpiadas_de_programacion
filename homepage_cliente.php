<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit;
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bienvenido Cliente</title>
  <link rel="stylesheet" href="styles/homepage_cliente.css">
</head>
<body>

  <!-- Encabezado -->
  <header class="encabezado">
    <div class="contenedor">
      <div class="logo">Explora Viajes</div>
      <nav class="navegacion">
        <a href="index.html">Cerrar sesión</a>
        <a href="#">Destinos</a>
        <a href="#">Contacto</a>
        <a href="carritocliente.php">
          <img src="imagenes/carrito-removebg-preview.png" alt="Carrito" style="width: 30px; height: 30px;">
        </a>    
      </nav>
    </div>
  </header>

  <!-- Hero -->
  <section class="hero">
    <div class="hero-contenido">
      <h1>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?></h1>
      <h2>Descubrí el mundo con nosotros</h2>
      <p>Viajes personalizados, experiencias inolvidables</p>
      <a href="Paquetes.php" class="boton">Ver destinos</a>
    </div>
  </section>

  <!-- Destinos -->
  <section class="destinos">
    <h3>Destinos Populares</h3>
    <div class="grid-destinos">
      <div class="destino">
        <img src="https://source.unsplash.com/400x250/?paris" alt="París">
        <div class="info">
          <h4>París</h4>
          <p>Desde $1500 USD. Incluye vuelo y hotel por 5 noches.</p>
        </div>
      </div>
      <div class="destino">
        <img src="https://source.unsplash.com/400x250/?tokyo" alt="Tokio">
        <div class="info">
          <h4>Tokio</h4>
          <p>Desde $2200 USD. Cultura y modernidad en 7 días.</p>
        </div>
      </div>
      <div class="destino">
        <img src="https://source.unsplash.com/400x250/?patagonia" alt="Patagonia">
        <div class="info">
          <h4>Patagonia Argentina</h4>
          <p>Desde $800 USD. Naturaleza pura y paisajes únicos.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Llamado a la acción -->
  <section class="cta">
    <h3>¿Listo para tu próxima aventura?</h3>
    <p>Contactanos y diseñamos juntos el viaje de tus sueños.</p>
    
  </section>

  <!-- Pie de página -->
  <footer class="pie">
    <div class="contenedor-footer">
      <p>&copy; 2025 Explora Viajes. Todos los derechos reservados.</p>
      <div class="enlaces-footer">
        <a href="#">Instagram</a>
        <a href="#">Facebook</a>
        <a href="index.html">Cerrar sesión</a>
      </div>
    </div>
  </footer>

</body>
</html>
