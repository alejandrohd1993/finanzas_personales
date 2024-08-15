<?php
include '../config/config.php';

$alertType = ''; // Variable para determinar el tipo de alerta
$alertMessage = ''; // Variable para el mensaje de alerta
$redirect = ''; // URL a la que redirigir después del registro

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn = getDB();

    // Verificar si el usuario ya existe
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->bind_result($userCount);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($userCount > 0) {
        // El usuario ya existe
        $alertType = 'warning';
        $alertMessage = 'El usuario ya está registrado. Por favor, use otro correo electrónico.';
    } else {
        // Insertar nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (username, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            $alertType = 'success';
            $alertMessage = '¡Usuario registrado con éxito! Redirigiendo a la página de inicio de sesión.';
            $redirect = 'login.php'; // Página a la que redirigir
        } else {
            $alertType = 'error';
            $alertMessage = 'Error al registrar el usuario.';
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container mt-5">
            <h1 class="text-center mb-4">Registro de Usuario</h1>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <form method="POST" action="register.php">
                        <div class="form-group">
                            <label for="username">Correo Electrónico</label>
                            <input type="email" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                        <p class="mt-2 text-center">¿Ya tienes cuenta? <a href="login.php">Inicia Sesión</a></p>
                    </form>
                </div>
            </div>
        </div>

    <?php if ($alertType && $alertMessage): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '<?php echo $alertType === 'success' ? '¡Éxito!' : ($alertType === 'warning' ? 'Advertencia' : 'Error'); ?>',
                    text: '<?php echo $alertMessage; ?>',
                    icon: '<?php echo $alertType; ?>',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed && '<?php echo $redirect; ?>') {
                        window.location.href = '<?php echo $redirect; ?>';
                    }
                });
            });
        </script>
    <?php endif; ?>
    <script src="../js/scripts.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</body>
</html>
