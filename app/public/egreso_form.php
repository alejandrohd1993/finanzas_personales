<?php
include '../includes/config.php';
include '../includes/check_login.php';

$conn = getDB();
$formas_pago = $conn->query("SELECT id, nombre FROM formas_pago");
$terceros = $conn->query("SELECT id, nombre FROM terceros");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Egreso</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="../js/scripts.js" defer></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Registrar Egreso</h1>
        <form method="POST" action="guardar_egreso.php">
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
            </div>
            <div class="form-group">
                <label for="valor">Valor</label>
                <input type="number" class="form-control" id="valor" name="valor" step="0.01" min="0.01" required>
            </div>
            <div class="form-group">
                <label for="forma_pago_id">Forma de Pago</label>
                <select class="form-control" id="forma_pago_id" name="forma_pago_id" required>
                    <option value="">Seleccionar</option>
                    <?php while ($row = $formas_pago->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tercero_id">Tercero</label>
                <select class="form-control" id="tercero_id" name="tercero_id" required>
                    <option value="">Seleccionar</option>
                    <?php while ($row = $terceros->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Egreso</button>
        </form>
    </div>
</body>
</html>
