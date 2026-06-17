<?php
require 'basedatos.php';

header('Content-Type: application/json');

$sql = "SELECT m.id_musica, m.titulo, m.archivo, m.tipo_audio, m.foto, m.tipo_foto, m.reproducciones, a.nombre_artistico 
        FROM musica m 
        JOIN artistas a ON m.id_artista = a.idartista";
$result = $conn->query($sql);

$canciones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $canciones[] = $row;
    }
}

echo json_encode($canciones);

$conn->close();
?>
