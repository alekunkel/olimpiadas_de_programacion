<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="imagenes/Logo azul.png" type="image/png">
  <title>Modificar Productos</title>
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
    select,
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    input[type="submit"] {
      background-color: #ffc107;
      color: #333;
      border: none;
      padding: 12px 20px;
      font-size: 1rem;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #e0a800;
    }

    .alert {
      padding: 1rem;
      border-radius: 5px;
      margin-top: 1rem;
      font-weight: bold;
      text-align: center;
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
  </style>
</head>
<body>

<header>
  Explora Viajes | Admin
</header>

<div class="container">
  <a href="homepage_admin.php" class="btn-back">← Volver al inicio</a>

  <h1>Modificar Productos</h1>

  <form method="post" enctype="multipart/form-data">
    <label>ID</label>
    <input type="text" name="id" required />

    <label>Nombre</label>
    <input type="text" name="nombre" required />

    <label>Calificación</label>
    <select name="calificacion" required>
      <option value="1">1 Estrella</option>
      <option value="2">2 Estrellas</option>
      <option value="3">3 Estrellas</option>
      <option value="4">4 Estrellas</option>
      <option value="5">5 Estrellas</option>
    </select>

    <label>Precio</label>
    <input type="number" name="precio" required min="0" step="0.01" />

    <label>Cantidad</label>
    <input type="number" name="cantidad" required min="0" />

    <label>Imagen</label>
    <input type="file" name="imagen" accept="image/*" />

    <input type="submit" name="modificar" value="Modificar" />
  </form>

  <?php
  if (isset($_POST["modificar"])) {
      $conexion = mysqli_connect("localhost", "root", "", "turismo");

      if (!$conexion) {
          echo "<div class='alert alert-danger'>Error de conexión a la base de datos.</div>";
          exit;
      }

      $Nombre = $_POST["nombre"];
      $Calificacion = $_POST["calificacion"];
      $Precio = $_POST["precio"];
      $Cantidad = $_POST["cantidad"];
      $ID = $_POST["id"];
      $imagenNombre = null;

      if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
          $carpetaDestino = "imagenes/";
          if (!is_dir($carpetaDestino)) {
              mkdir($carpetaDestino, 0755, true);
          }

          $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
          $imagenNombre = uniqid() . "." . $extension;
          $rutaDestino = $carpetaDestino . $imagenNombre;

          if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
              echo "<div class='alert alert-danger'>Error al subir la imagen.</div>";
              exit;
          }
      }

      if ($imagenNombre) {
          $sql = "UPDATE productos SET Nombre='$Nombre', Calificacion='$Calificacion', Precio='$Precio', Cantidad='$Cantidad', Imagen='$imagenNombre' WHERE ID_producto = '$ID'";
      } else {
          $sql = "UPDATE productos SET Nombre='$Nombre', Calificacion='$Calificacion', Precio='$Precio', Cantidad='$Cantidad' WHERE ID_producto = '$ID'";
      }

      $resultado = mysqli_query($conexion, $sql);

      if ($resultado) {
          echo "<div class='alert alert-success'>Se han modificado correctamente los datos.</div>";
      } else {
          echo "<div class='alert alert-danger'>Error al modificar los datos: " . mysqli_error($conexion) . "</div>";
      }

      mysqli_close($conexion);
  }
  ?>
</div>

</body>
</html>
