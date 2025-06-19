<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos - Productos</title>
    <link rel="stylesheet" href="styles\Paquete.css">
</head>


<?php
$nombre_bd = "turismo";
$servidor = "localhost";
$usuario = "root";
$contraseña = "";

$conexion = mysqli_connect($servidor, $usuario, $contraseña, $nombre_bd);
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

$sql = "SELECT * FROM `productos`";

$resultado = mysqli_query($conexion, $sql);

function obtenerImagen($nombre) {
    $nombre = strtolower($nombre);
    if (str_contains($nombre, 'brasil')) return 'imagenes\brasil.jpg';
    if (str_contains($nombre, 'cancun')) return 'imagenes\Cancun.jpg';
    if (str_contains($nombre, 'paris')) return 'imagenes\Paris.jpg';
    if (str_contains($nombre, 'automovil')) return 'imagenes\Auto.jpg';
    if (str_contains($nombre, 'madrid')) return 'imagenes\Madrid.jpg';
    return 'img/default.jpg';
}

?>

<body>
<div class="contenedor-tabla">
    <h1 class="titulo-formulario">Lista de Paquetes</h1>
        <?php
        if (mysqli_num_rows($resultado) > 0) {
            echo '<table>';
            echo    '<tr>';
            echo        '<th>ID</th>';
            echo        '<th>Nombre</th>';
            echo        '<th>Calificación</th>';
            echo        '<th>Cantidad</th>';
            echo        '<th>Precio</th>';
            echo        '<th>Imagen</th>';    
            echo        '<th>Acción</th>';   
            echo    '</tr>';

            while ($datos = mysqli_fetch_row($resultado)) {
            echo '<tr>';
            echo    '<td>' . $datos[0] . '</td>';
            echo    '<td>' . $datos[1] . '</td>';
            echo    '<td>' . $datos[2] . '</td>';
            echo    '<td>' . $datos[3] . '</td>';
            echo    '<td>' . $datos[4] . '</td>';
            echo    '<td><img src="' . obtenerImagen($datos[1]) . '" alt="' . $datos[1] . '" class="imagen-paquete"></td>';
            echo    '<td>
                        <form method="POST">
                            <input type="hidden" name="paquete_id" value="' . $datos[0] . '">
                            <input type="submit" name="agregar_carrito" value="Agregar al carrito" class="btn-carrito">
                        </form>
                    </td>';
            echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "<div class='mensaje'>";
            echo '<p>No hay datos disponibles en la base de datos.</p>';
            echo "</div>";
        }
       
     if (isset($_POST['agregar_carrito'])) {
    $ID_producto = $_POST['paquete_id'];
    $ID_cliente = $_SESSION['ID_cliente'];

    // Consultar el precio del producto
    $consulta_precio = "SELECT Precio FROM productos WHERE ID_producto = $ID_producto";
    $resultado_precio = mysqli_query($conexion, $consulta_precio);
    $precio = 0;

    if ($resultado_precio && mysqli_num_rows($resultado_precio) > 0) {
        $fila_precio = mysqli_fetch_assoc($resultado_precio);
        $precio = $fila_precio['Precio'];
    }

    // Insertar en la tabla carrito
    $insertar = "INSERT INTO carrito (ID_cliente, ID_producto, Cantidad, Precio_total, Estado, fecha_cargado)
                 VALUES ($ID_cliente, $ID_producto, 1, $precio, 'Pendiente', NOW())";

    if (mysqli_query($conexion, $insertar)) {
        echo "<script>alert('¡Paquete agregado al carrito correctamente!');</script>";
    } else {
        echo "<script>alert('Error al agregar al carrito.');</script>";
    }
}


        ?>
<a href="carritocliente.php">Ver Carrito</a>
</div>
</body>
</html>