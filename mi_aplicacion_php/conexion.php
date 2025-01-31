<?php
$servername = "localhost";
$username = "root"; // Por defecto, el usuario es 'root'
$password = ""; // Por defecto, la contraseña está vacía
$dbname = "mi_base_de_datos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>