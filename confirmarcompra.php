<?php
require 'vendor/autoload.php';
require_once('fpdf/fpdf.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function obtenerNombreProducto($conexion, $id_producto) {
    $stmt = $conexion->prepare("SELECT Nombre FROM productos WHERE ID_producto = ?");
    if (!$stmt) {
        die("Error al preparar nombre del producto: " . $conexion->error);
    }
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $stmt->bind_result($nombre);
    $stmt->fetch();
    $stmt->close();
    return $nombre ?: "Producto Desconocido";
}

$conexion = new mysqli("localhost", "root", "", "turismo");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id_cliente = isset($_POST['ID_cliente']) ? intval($_POST['ID_cliente']) : 0;
$medio_pago = isset($_POST['medio_pago']) ? htmlspecialchars(trim($_POST['medio_pago'])) : '';
$fecha = date("Y-m-d H:i:s");
$total_pedido_final = 0;
$detalles_productos_email = [];

// Obtener carrito
$stmt_carrito = $conexion->prepare("SELECT ID_producto, Cantidad, Precio_total FROM carrito WHERE ID_cliente = ?");
$stmt_carrito->bind_param("i", $id_cliente);
$stmt_carrito->execute();
$resultado = $stmt_carrito->get_result();

if ($resultado->num_rows === 0) {
    echo "El carrito está vacío.";
    $conexion->close();
    exit();
}

// Obtener datos del cliente
$stmt_cliente = $conexion->prepare("SELECT Nombre, Email FROM cliente WHERE ID_cliente = ?");
$stmt_cliente->bind_param("i", $id_cliente);
$stmt_cliente->execute();
$stmt_cliente->bind_result($nombre_cliente, $email_cliente);
$stmt_cliente->fetch();
$stmt_cliente->close();

$nombre_cliente = $nombre_cliente ?: 'Cliente';
$email_cliente = filter_var($email_cliente, FILTER_VALIDATE_EMAIL) ? $email_cliente : 'cliente@ejemplo.com';

$stmt_insert = $conexion->prepare("INSERT INTO pedido (ID_producto, ID_cliente, Medio_pago, Cantidad, Total_venta, fecha_pedido, Estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
while ($item = $resultado->fetch_assoc()) {
    $id_producto = $item['ID_producto'];
    $cantidad = $item['Cantidad'];
    $total_item = $item['Precio_total'];
    $precio_unitario = $cantidad > 0 ? $total_item / $cantidad : 0;
    $estado = 'Pendiente';

    $nombre_producto = obtenerNombreProducto($conexion, $id_producto);
    $total_pedido_final += $total_item;

    $stmt_insert->bind_param("iisdsss", $id_producto, $id_cliente, $medio_pago, $cantidad, $total_item, $fecha, $estado);
    $stmt_insert->execute();

    $detalles_productos_email[] = [
        'nombre' => $nombre_producto,
        'cantidad' => $cantidad,
        'precio_unitario' => $precio_unitario,
        'total' => $total_item
    ];
}
$stmt_insert->close();
$stmt_carrito->close();

// Vaciar carrito
$stmt_delete = $conexion->prepare("DELETE FROM carrito WHERE ID_cliente = ?");
$stmt_delete->bind_param("i", $id_cliente);
$stmt_delete->execute();
$stmt_delete->close();

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode("Confirmación de Compra"), 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Ln(5);
$pdf->Cell(0, 10, utf8_decode("Cliente: $nombre_cliente"), 0, 1);
$pdf->Cell(0, 10, utf8_decode("Medio de pago: $medio_pago"), 0, 1);
$pdf->Cell(0, 10, utf8_decode("Fecha: $fecha"), 0, 1);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, utf8_decode('Producto'), 1);
$pdf->Cell(30, 10, utf8_decode('Cantidad'), 1);
$pdf->Cell(40, 10, utf8_decode('Precio Unitario'), 1);
$pdf->Cell(40, 10, utf8_decode('Subtotal'), 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
foreach ($detalles_productos_email as $detalle) {
    $pdf->Cell(60, 10, utf8_decode($detalle['nombre']), 1);
    $pdf->Cell(30, 10, $detalle['cantidad'], 1);
    $pdf->Cell(40, 10, '$' . number_format($detalle['precio_unitario'], 2, ',', '.'), 1);
    $pdf->Cell(40, 10, '$' . number_format($detalle['total'], 2, ',', '.'), 1);
    $pdf->Ln();
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(130, 10, utf8_decode('Total del Pedido'), 1);
$pdf->Cell(40, 10, '$' . number_format($total_pedido_final, 2, ',', '.'), 1);

$pdf_path = __DIR__ . "/confirmacion_pedido_$id_cliente.pdf";
$pdf->Output('F', $pdf_path);

// Enviar correo con PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'turismocity655@gmail.com';
    $mail->Password = 'wtel ctsk qjab dadb'; // Usar contraseña de aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom('atencionalclienteexploraviajes@gmail.com', 'atención al cliente de explora viajes');
    $mail->addAddress($email_cliente, $nombre_cliente);
    $mail->isHTML(true);
    $mail->Subject = 'Confirmación de tu compra';
    $mail->Body = "<p>Hola $nombre_cliente, gracias por tu compra.</p><p>Adjuntamos el comprobante en PDF.</p>";
    $mail->AltBody = "Hola $nombre_cliente, gracias por tu compra.";

    $mail->addAttachment($pdf_path, "ConfirmacionCompra.pdf");

    $mail->send();

    // Si el correo se envió correctamente, eliminamos el PDF
    unlink($pdf_path);

} catch (Exception $e) {
    error_log("Error al enviar email: " . $mail->ErrorInfo);
    // Si falla el envío, el PDF no se elimina
}

$conexion->close();
header("Location: homepage_cliente.php");
exit();
?>
