<?php
require 'basedatos.php';

$id_album = intval($_GET['id_album']);

$query = "SELECT nombre AS nombre, descripcion, foto, tipo_foto FROM album WHERE id_album = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_album);
$stmt->execute();
$result = $stmt->get_result();

if ($album = $result->fetch_assoc()) {
    echo json_encode($album);
} else {
    echo json_encode(['error' => 'Álbum no encontrado']);
}

$stmt->close();
$conn->close();
?>
