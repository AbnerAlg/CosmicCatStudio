<?php
require 'basedatos.php';

$id_album = intval($_GET['id_album']);

$query = "SELECT m.id_musica, m.titulo, m.foto, m.tipo_foto 
          FROM musica AS m
          JOIN album_cancion AS ac ON m.id_musica = ac.id_cancion
          WHERE ac.id_album = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_album);
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
