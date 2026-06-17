<?php
require 'basedatos.php';

header('Content-Type: application/json');

$sql = "SELECT album.id_album, album.nombre, album.foto, album.tipo_foto, album.id_artista, artistas.nombre_artistico 
        FROM album
        JOIN artistas ON album.id_artista = artistas.idartista";
        
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $albums = [];
    while ($row = $result->fetch_assoc()) {
        $albums[] = $row;
    }
    echo json_encode($albums);
} else {
    echo json_encode([]);
}

$conn->close();
?>
