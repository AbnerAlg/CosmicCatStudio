<?php
require 'basedatos.php';

header('Content-Type: application/json');

// Consulta para obtener 6 canciones aleatorias
$sql = "SELECT m.id_musica, m.titulo, m.archivo, m.tipo_audio, m.foto, m.tipo_foto, m.reproducciones, a.nombre_artistico 
        FROM musica m 
        JOIN artistas a ON m.id_artista = a.idartista 
        ORDER BY RAND() 
        LIMIT 6";
$result = $conn->query($sql);

$recomendaciones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recomendaciones[] = $row;
    }
}

echo json_encode($recomendaciones);

$conn->close();
?>
