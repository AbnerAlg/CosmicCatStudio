<?php
require 'basedatos.php';

header('Content-Type: application/json');

$idArtista = $_GET['id'];

$query = "SELECT id_comunidad FROM comunidad WHERE id_artista = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idArtista);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['existe' => true]);
} else {
    echo json_encode(['existe' => false]);
}
$stmt->close();
$conn->close();
?>