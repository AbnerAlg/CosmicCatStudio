<?php
require 'basedatos.php';

header('Content-Type: application/json');

$idArtista = $_GET['id'];

$query = "SELECT id_comunidad, nombre, foto, tipo_foto, descripcion FROM comunidad WHERE id_artista = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idArtista);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'comunidad' => $row
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se encontró una comunidad para este artista.'
    ]);
}
?>