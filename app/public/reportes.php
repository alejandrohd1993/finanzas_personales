<?php
include '../includes/config.php';
include '../includes/check_login.php';

$conn = getDB();

// Reporte de Balance
$sql_balance = "SELECT SUM(valor) as total_ingresos FROM ingresos WHERE usuario_id = ?";
$stmt = $conn->prepare($sql_balance);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$total_ingresos = $result->fetch_assoc()['total_ingresos'];

$sql_balance = "SELECT SUM(valor) as total_egresos FROM egresos WHERE usuario_id = ?";
$stmt = $conn->prepare($sql_balance);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$total_egresos = $result->fetch_assoc()['total_egresos'];

$balance_total = $total_ingresos - $total_egresos;

// Reporte de Ingresos y Egresos
$sql_ingresos = "SELECT * FROM ingresos WHERE usuario_id = ?";
$sql_egresos = "SELECT * FROM egresos WHERE usuario_id = ?";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
    <<link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="../js/scripts.js" defer></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Reportes</h1>
        <h2>Balance Total: <?php echo number_format($balance_total, 2); ?></h2>

        <h3>Ingresos</h3>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Valor</th>
                    <th>Forma de Pago</th>
                    <th>Tercero</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare($sql_ingresos);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo number_format($row['valor'], 2); ?></td>
                        <td><?php echo $row['forma_pago_id']; ?></td>
                        <td><?php echo $row['tercero_id']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Egresos</h3>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Valor</th>
                    <th>Forma de Pago</th>
                    <th>Tercero</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare($sql_egresos);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo number_format($row['valor'], 2); ?></td>
                        <td><?php echo $row['forma_pago_id']; ?></td>
                        <td><?php echo $row['tercero_id']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a class="btn btn-primary" href="ingreso_form.php">Registrar Ingreso</a>
        <a class="btn btn-primary" href="egreso_form.php">Registrar Egreso</a>
    </div>
</body>
</html>
