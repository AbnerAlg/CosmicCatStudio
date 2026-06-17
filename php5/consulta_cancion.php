<?php
require 'basedatos.php';

header('Content-Type: application/json');

$id_musica = intval($_GET['id_musica']);

$sql = "SELECT titulo, genero, colaboradores, letra, foto, tipo_foto FROM musica WHERE id_musica = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_musica);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "No se encontró la canción."]);
}

$stmt->close();
$conn->close();
?>
