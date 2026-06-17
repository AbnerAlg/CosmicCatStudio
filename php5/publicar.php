<?php
require 'basedatos.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$idComunidad = $data['id_comunidad'];
$texto = $data['texto'];

$query = "INSERT INTO publicacion (texto, id_comunidad) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $texto, $idComunidad);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al publicar']);
}
?>