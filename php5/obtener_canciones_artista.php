<?php
require 'basedatos.php';

header('Content-Type: application/json');

$id_artista = intval($_GET['id_artista']);

$sql = "SELECT id_musica, titulo, foto, tipo_foto FROM musica WHERE id_artista = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_artista);
$stmt->execute();
$result = $stmt->get_result();

$canciones = [];
while ($row = $result->fetch_assoc()) {
    $canciones[] = $row;
}

echo json_encode($canciones);

$stmt->close();
$conn->close();
?>
