<?php
// Configuración de la base de datos
$host = "localhost"; // Dirección del servidor
$dbname = "muescaeventos"; // Nombre de la base de datos (muescaeventos)
$username = "root"; // Usuario de MySQL
$password = ""; // Contraseña de MySQL

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar el manejo de errores de PDO
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>