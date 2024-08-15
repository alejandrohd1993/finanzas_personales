<?php
include '../includes/config.php';
include '../includes/check_login.php';

$fecha = $_POST['fecha'];
$descripcion = $_POST['descripcion'];
$valor = $_POST['valor'];
$forma_pago_id = $_POST['forma_pago_id'];
$tercero_id = $_POST['tercero_id'];

$conn = getDB();
$stmt = $conn->prepare("INSERT INTO ingresos (fecha, descripcion, valor, forma_pago_id, tercero_id, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiiii", $fecha, $descripcion, $valor, $forma_pago_id, $tercero_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo "Ingreso registrado con éxito.";
} else {
    echo "Error al registrar el ingreso.";
}

$stmt->close();
$conn->close();
?>
