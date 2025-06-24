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
    <link rel="icon" href="imagenes/Logo azul.png" type="image/png">
  <title>Bienvenido Cliente</title>
  <link rel="stylesheet" href="styles/homepage_cliente.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
</head>
<body>

  <!-- Encabezado -->
  <header class="encabezado">
    <div class="contenedor">
        <a class="logo">
          <img src="imagenes/Logo blanco.png" alt="Logo de Explora Viajes" />
          <span>Explora Viajes</span>
        </a>
      <nav class="navegacion">
  <a href="paquetes.php">
    <i class="fas fa-plane"></i>
    <span>Paquetes</span>
  </a>
  <a href="carritocliente.php" class="carrito-icon">
    <i class="fas fa-shopping-cart"></i>    
    <span>Carrito de compras</span>
  </a>
  <div class="dropdown">
    <div class="user-trigger" onclick="toggleDropdown()">
      <i class="fas fa-user user-icon"></i>
    </div>
    <div class="dropdown-content" id="dropdownMenu">
      <span class="nombre-usuario"><?php echo $_SESSION['usuario_nombre']; ?></span>
      <a href="tabla_historica.php">Historial de Compras</a>
      <a href="index.html">Cerrar sesión</a>
    </div>
</div>

  </div>
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
      <br>
      <br>
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
 <script>
    const imagenes = [
      "imagenes/kalen-emsley-Bkci_8qcdvQ-unsplash.jpg",
      "imagenes/luca-bravo-zAjdgNXsMeg-unsplash.jpg",
      "imagenes/pietro-de-grandi-T7K4aEPoGGk-unsplash.jpg"
    ];
    let indice = 0;
    const slider = document.getElementById("slider-bg");

    function cambiarFondo() {
      slider.style.backgroundImage = `url('${imagenes[indice]}')`;
      indice = (indice + 1) % imagenes.length;
    }

    cambiarFondo();
    setInterval(cambiarFondo, 5000);
  function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
  }

  // Cerrar si se hace clic afuera
  window.addEventListener('click', function(e) {
    const icon = document.querySelector('.user-icon');
    const menu = document.getElementById("dropdownMenu");
    if (!icon.contains(e.target)) {
      menu.style.display = "none";
    }
  });

  </script>

</body>
</html>
<style>
  * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  line-height: 1.6;
  color: #333;
  background-color: #fff;
}

/* Encabezado */
.encabezado {
  background-color: #0077cc;
  color: #fff;
  padding: 1rem 0;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.contenedor {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;  
}

.logo {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: white;
  margin-left: -60px; /* 🔧 Ajustá este valor a tu gusto */
}



.logo img {
  height: 40px;   
  width: auto;
  margin-right: 10px;
}

.logo span {
  font-size: 1.8rem;
  font-weight: bold;
}
.navegacion a {
  color: #fff;
  text-decoration: none;
  margin-left: 1rem;
}

.navegacion a:hover {
  text-decoration: underline;
}

html, body {
  width: 100%;
  height: 100%;
}

/* HERO corregido y a pantalla completa */
.hero {
  position: relative;
  width: 100vw;
  height: 100vh;
  overflow: hidden;
}

.slider-bg {
  position: absolute;
  top: 0; left: 0; width: 100%; height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  z-index: 0;
  transition: background-image 1s ease-in-out;
}

.hero-overlay {
  position: absolute;
  top: 0; left: 0; width: 100%; height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1;
}

.hero-contenido {
  position: relative;
  z-index: 2;
  color: white;
  text-align: center;
  top: 50%;
  transform: translateY(-50%);
  width: 100%;
  padding: 0 1rem;
}

.hero h2 {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.hero p {
  font-size: 1.5rem;
}


.boton {
  background-color: #ffc107;
  color: #000;
  padding: 0.75rem 1.5rem;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: background-color 0.3s;
}

.boton:hover {
  background-color: #e0a800;
}

/* Destinos */
.destinos {
  max-width: 1200px;
  margin: 3rem auto;
  padding: 0 1rem;
  text-align: center;
}

.destinos h3 {
  font-size: 2rem;
  margin-bottom: 2rem;
}

.grid-destinos {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
}

.destino {
  
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  transition: box-shadow 0.3s;
}

.destino:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.destino img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.destino .info {
  padding: 1rem;
}

.destino h4 {
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
}

/* Llamado a la acción */
.cta {
  background-color: #e3f2fd;
  text-align: center;
  padding: 3rem 1rem;
}

.cta h3 {
  font-size: 1.8rem;
  margin-bottom: 1rem;
}

.cta p {
  font-size: 1.1rem;
  margin-bottom: 1.5rem;
}

/* Pie de página */
.pie {
  background-color: #333;
  color: #fff;
  padding: 1.5rem 1rem;
}

.contenedor-footer {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.enlaces-footer {
  margin-top: 0.5rem;
}

.enlaces-footer a {
  color: #ccc;
  text-decoration: none;
  margin: 0 0.5rem;
}

.enlaces-footer a:hover {
  text-decoration: underline;
}
.dropdown {
  position: relative;
  display: inline-block;
  margin-left: 1rem;
}

.user-trigger {
  cursor: pointer;
  color: white;
  font-size: 1.2rem;
  display: flex;
  align-items: center;
}

.dropdown-content {
  display: none;
  position: absolute;
  top: 2.2rem;
  right: 0;
  background-color: #fff;
  min-width: 180px;
  box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
  z-index: 10;
  border-radius: 5px;
  text-align: left;
}

.dropdown-content a,
.dropdown-content span {
  color: #333;
  padding: 0.75rem 1rem;
  text-decoration: none;
  display: block;
}


.dropdown-content a:hover {
  background-color: #f1f1f1;
}

.nombre-usuario {
  font-weight: bold;
  color: #0077cc;
  border-bottom: 1px solid #ddd;
  margin-bottom: 0.5rem;
}


</style>
