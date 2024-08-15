<?php
include '../includes/config.php';
include '../includes/check_login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];

    $conn = getDB();
    $stmt = $conn->prepare("INSERT INTO formas_pago (nombre) VALUES (?)");
    $stmt->bind_param("s", $nombre);

    if ($stmt->execute()) {
        echo "Forma de pago añadida con éxito.";
    } else {
        echo "Error al añadir forma de pago.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Forma de Pago</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="../js/scripts.js" defer></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Agregar Forma de Pago</h1>
        <form method="POST" action="formas_pago_form.php">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Forma de Pago</button>
        </form>
    </div>
</body>
</html>
