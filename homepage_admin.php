<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenido, admin</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-dark text-white">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Cine San Francisco</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="clientesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Clientes
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="clientesDropdown">
              <li><a class="dropdown-item" href="insert.php">Agregar</a></li>
              <li><a class="dropdown-item" href="update.php">Modificar</a></li>
              <li><a class="dropdown-item" href="delete.php">Eliminar</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="select.php">Listado de Clientes</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Productos
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="productosDropdown">
              <li><a class="dropdown-item" href="insertp.php">Agregar</a></li>
              <li><a class="dropdown-item" href="updatep.php">Modificar</a></li>
              <li><a class="dropdown-item" href="deletep.php">Eliminar</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="selectp.php">Listado de Productos</a></li>
            </ul>
          </li>


          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="ventasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Ventas
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="ventasDropdown">
              <li><a class="dropdown-item" href="ventas.php">Ventas</a></li>
              <li><a class="dropdown-item" href="ventadetalle.php">Detalle de Ventas</a></li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <h2 class="text-center">Bienvenido a Cine San Francisco</h2>
    <p class="text-center">Selecciona una opción del menú para comenzar.</p>
  </div>
    <div class="imagenlogo">
    <img src="imagenes/images__1_-removebg-preview.png" alt="">
    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>