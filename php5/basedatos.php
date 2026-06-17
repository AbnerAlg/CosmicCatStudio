<?php

$servername = "localhost";  // Servidor (en este caso es localhost)
$username = "root";         // Nombre de usuario (por defecto en XAMPP/MAMP es "root")
$password = "";             // Contraseña (por defecto en XAMPP/MAMP suele estar vacía)
$database = "cosmiccatstudio";  // Nombre de la base de datos a la que quieres conectarte

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


?>