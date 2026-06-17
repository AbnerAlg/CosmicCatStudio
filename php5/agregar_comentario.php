<?php
require 'basedatos.php';

header('Content-Type: application/json');

// Decodificar el JSON recibido
$data = json_decode(file_get_contents("php://input"), true);

// Asegurar que no hay espacios en blanco
ob_clean();

$id_oyente = $data['id_oyente'] ?? 0;
$id_publicacion = $data['id_publicacion'] ?? 0;
$texto = trim($data['texto'] ?? '');

if ($id_oyente && $id_publicacion && $texto) {
    // Insertar el comentario en la base de datos
    $query = "INSERT INTO comentarios (id_oyente, id_publicacion, texto) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $id_oyente, $id_publicacion, $texto);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Comentario agregado exitosamente."]);
    } else {
        
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos para agregar el comentario."]);
}

// Cerrar conexión y evitar mensajes adicionales
$conn->close();
ob_end_flush();