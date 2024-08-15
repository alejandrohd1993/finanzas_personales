<?php
$servername = "localhost";
$username = "root"; // Cambia esto si usas un usuario diferente
$password = ""; // Cambia esto si usas una contraseña
$dbname = "finanzas_personales"; // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conectado exitosamente";
?>
