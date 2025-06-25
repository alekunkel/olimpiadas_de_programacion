<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="imagenes/Logo azul.png" type="image/png">
  <title>Agregar Producto</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      background: #f0f4f8;
      color: #333;
    }

    header {
      background-color: #0077cc;
      color: white;
      padding: 1rem 2rem;
      font-size: 1.5rem;
    }

    .container {
      max-width: 600px;
      background-color: white;
      margin: 2rem auto;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #0077cc;
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 0.3rem;
      color: #333;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    input[type="submit"] {
      background-color: #0077cc;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 1rem;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #005fa3;
    }

    .alert {
      padding: 1rem;
      border-radius: 5px;
      margin-top: 1rem;
      font-weight: bold;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
    }

    .btn-back {
      display: inline-block;
      margin-bottom: 1.5rem;
      background-color: #f0f0f0;
      color: #0077cc;
      padding: 8px 15px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: background-color 0.2s;
    }

    .btn-back:hover {
      background-color: #e0e0e0;
    }
    select[name="calificacion"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 1rem;
  background-color: white;
  appearance: none; /* Quita flechita nativa en algunos navegadores */
  background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2210%22%20height%3D%225%22%20viewBox%3D%220%200%2010%205%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cpath%20d%3D%22M0%200l5%205%205-5z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 10px center;
  background-size: 10px 5px;
}

select[name="calificacion"]:focus {
  outline: none;
  border-color: #0077cc;
  box-shadow: 0 0 3px #0077cc66;
}

  </style>
</head>
<body>

<header>
  Explora Viajes | Admin
</header>

<div class="container">
  <a href="homepage_admin.php" class="btn-back">← Volver al inicio</a>
  <h1>Agregar Productos</h1>

  <form method="post" enctype="multipart/form-data">
    <label>Nombre</label>
    <input type="text" name="nombre" required>

    <label>Precio</label>
    <input type="number" name="precio" required>

    <label>Cantidad</label>
    <input type="number" name="cantidad" required>

    <label>Calificación</label>
      <select name="calificacion" required>
      <option value="1">1 Estrella</option>
      <option value="2">2 Estrellas</option>
      <option value="3">3 Estrellas</option>
      <option value="4">4 Estrellas</option>
      <option value="5">5 Estrellas</option>
    </select>
    <label>Imagen</label>
    <input type="file" name="imagen" accept="image/*">

    <input type="submit" name="agregar" value="Guardar">
  </form>

  <?php
  if (isset($_POST["agregar"])) {
      $conexion = mysqli_connect("localhost", "root", "", "turismo");
      if (!$conexion) {
          die("<div class='alert alert-danger'>Error de conexión.</div>");
      }

      $Nombre = $_POST["nombre"];
      $Precio = $_POST["precio"];
      $Cantidad = $_POST["cantidad"];
      $Calificacion = $_POST["calificacion"];

      $imagenNombre = null;

      if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
          $carpetaDestino = "imagenes/";
          if (!is_dir($carpetaDestino)) {
              mkdir($carpetaDestino, 0755, true);
          }

          $imagenNombre = uniqid() . "-" . basename($_FILES["imagen"]["name"]);
          $rutaDestino = $carpetaDestino . $imagenNombre;

          if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
              echo "<div class='alert alert-danger'>Error al subir la imagen.</div>";
              exit;
          }
      }

      $sql = "INSERT INTO productos (Nombre, Calificacion, Cantidad, Precio, Imagen)
              VALUES ('$Nombre', '$Calificacion', '$Cantidad', '$Precio', '$imagenNombre')";

      $resultado = mysqli_query($conexion, $sql);

      if ($resultado) {
          echo "<div class='alert alert-success'>Se ha agregado correctamente el producto.</div>";
      } else {
          echo "<div class='alert alert-danger'>Error al guardar en la base de datos.</div>";
      }

      mysqli_close($conexion);
  }
  ?>
</div>

</body>
</html>
