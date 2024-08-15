<?php
include './includes/config.php';
include './includes/check_login.php';

// Verificar si el usuario está autenticado
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido a la Aplicación de Finanzas Personales</h1>
        <p>Por favor, inicie sesión para acceder a su cuenta.</p>
        <a class="btn btn-primary" href="login.php">Iniciar Sesión</a>
    </div>
</body>
</html>
