<?php
include '../includes/config.php';
include '../includes/check_login.php';

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Dashboard</h1>
        <p>Bienvenido al panel de administración.</p>
        <a class="btn btn-primary" href="../public/reportes.php">Ver Reportes</a>
        <a class="btn btn-secondary" href="../public/ingreso_form.php">Registrar Ingreso</a>
        <a class="btn btn-secondary" href="../public/egreso_form.php">Registrar Egreso</a>
        <a class="btn btn-danger" href="../public/logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>
