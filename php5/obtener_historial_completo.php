<?php
require 'basedatos.php';

header('Content-Type: application/json');

$id_oyente = intval($_GET['id_oyente']); // Obtener el ID del oyente desde la URL

$sql = "SELECT m.id_musica, m.titulo, m.archivo, m.tipo_audio, m.foto, m.tipo_foto, a.nombre_artistico 
        FROM historial_reproducciones hr
        JOIN musica m ON hr.id_musica = m.id_musica
        JOIN artistas a ON m.id_artista = a.idartista
        WHERE hr.id_oyente = ?
        ORDER BY hr.fecha_reproduccion DESC";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_oyente);
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
