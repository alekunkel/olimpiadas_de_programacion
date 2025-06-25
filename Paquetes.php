<?php
session_start();
$nombre_bd = "turismo";
$servidor = "localhost";
$usuario = "root";
$contraseña = "";

$conexion = mysqli_connect($servidor, $usuario, $contraseña, $nombre_bd);
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

if (isset($_POST['agregar_carrito'])) {
    if (!isset($_SESSION['ID_cliente'])) {
        echo "<script>alert('Debes iniciar sesión para agregar al carrito.');</script>";
        exit;
    }

    $ID_producto = intval($_POST['paquete_id']);
    $ID_cliente = $_SESSION['ID_cliente'];

    // Obtener stock y precio del producto
    $consulta_producto = "SELECT Cantidad AS stock_disponible, Precio FROM productos WHERE ID_producto = $ID_producto";
    $resultado_producto = mysqli_query($conexion, $consulta_producto);
    $producto = mysqli_fetch_assoc($resultado_producto);

    if ($producto && $producto['stock_disponible'] > 0) {
        $precio_unitario = $producto['Precio'];
        $stock_disponible = intval($producto['stock_disponible']);

        // Verificar si ya está en el carrito
        $consulta_carrito = "SELECT Cantidad FROM carrito WHERE ID_cliente = $ID_cliente AND ID_producto = $ID_producto AND Estado = 'Pendiente'";
        $resultado_carrito = mysqli_query($conexion, $consulta_carrito);
        $carrito_existente = mysqli_fetch_assoc($resultado_carrito);

        if ($carrito_existente) {
            $cantidad_actual = intval($carrito_existente['Cantidad']);

            if ($cantidad_actual + 1 > $stock_disponible) {
                echo "<script>alert('No puedes agregar más de la cantidad disponible en stock.');</script>";
            } else {
                // Sumar 1 al carrito
                $nueva_cantidad = $cantidad_actual + 1;
                $nuevo_total = $nueva_cantidad * $precio_unitario;

                $update = "UPDATE carrito 
                           SET Cantidad = $nueva_cantidad, Precio_total = $nuevo_total 
                           WHERE ID_cliente = $ID_cliente AND ID_producto = $ID_producto AND Estado = 'Pendiente'";
                if (mysqli_query($conexion, $update)) {
                    echo "<script>alert('Producto agregado al carrito.');</script>";
                } else {
                    echo "<script>alert('Error al actualizar el carrito.');</script>";
                }
            }
        } else {
            // Primera vez que lo agrega
            $insertar = "INSERT INTO carrito (ID_cliente, ID_producto, Cantidad, Precio_total, Estado, fecha_cargado)
                         VALUES ($ID_cliente, $ID_producto, 1, $precio_unitario, 'Pendiente', NOW())";

            if (mysqli_query($conexion, $insertar)) {
                echo "<script>alert('Producto agregado al carrito.');</script>";
            } else {
                echo "<script>alert('Error al agregar al carrito.');</script>";
            }
        }
    } else {
        echo "<script>alert('Este producto no tiene stock disponible.');</script>";
    }
}

// Obtener productos incluyendo el campo Imagen
$sql = "SELECT ID_producto, Nombre, Calificacion, Cantidad, Precio, Imagen FROM productos";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
      <link rel="icon" href="imagenes/Logo azul.png" type="image/png">
    <title>Datos - Productos</title>
    <link rel="stylesheet" href="styles/Paquete.css">
</head>
<body>
<div class="contenedor-tabla">
    <h1 class="titulo-formulario">Lista de Paquetes</h1>
    <div class="botones-acciones">
        <a href="homepage_cliente.php" class="boton boton-inicio">
            <i class="fas fa-home"></i> Volver al inicio
        </a>
    </div>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Calificación</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acción</th>
            </tr>
            <?php while ($datos = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?= htmlspecialchars($datos['Nombre']) ?></td>
                    <td><?= $datos['Calificacion'] ?></td>
                    <td><?= $datos['Cantidad'] ?></td>
                    <td><?= $datos['Precio'] ?></td>
                    <td>
                        <?php if (!empty($datos['Imagen'])): ?>
                            <img src="imagenes/<?= htmlspecialchars($datos['Imagen']) ?>" alt="<?= htmlspecialchars($datos['Nombre']) ?>" class="imagen-paquete">
                        <?php else: ?>
                            <img src="img/default.jpg" alt="Imagen por defecto" class="imagen-paquete">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($datos['Cantidad'] == 0): ?>
                            <span style="color: red; font-weight: bold;">Producto sin stock</span>
                        <?php else: ?>
                            <form method="POST">
                                <input type="hidden" name="paquete_id" value="<?= $datos['ID_producto'] ?>">
                                <input type="submit" name="agregar_carrito" value="Agregar al carrito" class="btn-carrito">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class='mensaje'>
            <p>No hay datos disponibles.</p>
        </div>
    <?php endif; ?>

    <div class="botones-acciones">
        <a href="carritocliente.php" class="boton boton-carrito">
            <i class="fas fa-shopping-cart"></i> Ver carrito
        </a>
    </div>
</div>
</body>
</html>
<style>
    /* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #e0f7fa, #fff);
    min-height: 100vh;
    padding: 30px;
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

.contenedor-tabla {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 900px;
}

.titulo-formulario {
    text-align: center;
    font-size: 28px;
    color: #00796b;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
}

th, td {
    padding: 12px 15px;
    border-bottom: 1px solid #ccc;
}

th {
    background-color: #004d40;
    color: white;
    text-transform: uppercase;
    font-size: 14px;
}

tr:nth-child(even) {
    background-color: #f1f1f1;
}

tr:hover {
    background-color: #e0f2f1;
    cursor: pointer;
}

.mensaje {
    text-align: center;
    font-size: 18px;
    color: #d32f2f;
    padding: 15px;
    border: 1px solid #f44336;
    background-color: #ffebee;
    border-radius: 8px;
}

.imagen-paquete {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
}

.imagen-paquete:hover {
    transform: scale(1.05);
}

.botones-acciones {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin: 2rem 0;
}

.boton {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background-color: #0077cc;
  color: white;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  text-decoration: none;
  transition: background-color 0.3s ease, transform 0.2s ease;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.boton:hover {
  background-color: #005fa3;
  transform: scale(1.03);
}

.boton i {
  font-size: 1.1rem;
}

/* ... tu CSS actual ... */
.imagen-paquete {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
}
.imagen-paquete:hover {
    transform: scale(1.05);
}
/* resto de tu CSS ... */

</style>