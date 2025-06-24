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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
</head>
<body>

  <!-- Encabezado -->
  <header class="encabezado">
    <div class="contenedor">
      <div class="logo">Explora Viajes</div>
      <nav class="navegacion">
        <a href="index.html">Cerrar sesión</a>
        <a href="tabla_historica.php">Historial de Compras</a>
        <a href="carritocliente.php" class="carrito-icon">
          <i class="fas fa-shopping-cart"></i>
        </a>
      </nav>
    </div>
  </header>

  <!-- Hero con fondo dinámico -->
  <section class="hero">
    <div class="slider-bg" id="slider-bg"></div>
    <div class="hero-overlay"></div>
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
        <img src="imagenes/Paris.jpg" alt="París">
        <div class="info">
          <h4>París</h4>
          <p>Desde $1500 USD. Incluye vuelo y hotel por 5 noches.</p>
        </div>
      </div>
      <div class="destino">
        <img src="imagenes/tokyo.jpg" alt="Tokio">
        <div class="info">
          <h4>Tokio</h4>
          <p>Desde $2200 USD. Cultura y modernidad en 7 días.</p>
        </div>
      </div>
      <div class="destino">
        <img src="imagenes/descarga.jpg" alt="Patagonia">
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

  <!-- JavaScript para cambiar fondo -->
  <script>
    const imagenes = [
      "imagenes\kalen-emsley-Bkci_8qcdvQ-unsplash.jpg",
      "imagenes\luca-bravo-zAjdgNXsMeg-unsplash.jpg",
      "imagenes\matthew-henry-2nY4j8d9b6c-unsplash.jpg",
      "imagenes\mike-von-woelk-3j6b1a8"
    ];
    let indice = 0;
    const slider = document.getElementById("slider-bg");

    function cambiarFondo() {
      if (slider) {
        slider.style.backgroundImage = `url('${imagenes[indice]}')`;
        indice = (indice + 1) % imagenes.length;
      }
    }

    cambiarFondo(); // mostrar el primero
    setInterval(cambiarFondo, 5000); // cambiar cada 5 segundos
  </script>

</body>
</html>
