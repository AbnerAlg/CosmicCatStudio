<?php
require 'basedatos.php';

$id_album = intval($_GET['id_album']);
$id_musica = intval($_GET['id_musica']);

$query = "INSERT INTO album_cancion (id_album, id_cancion) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id_album, $id_musica);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Canción agregada al álbum']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al agregar la canción al álbum']);
}

$stmt->close();
$conn->close();
?>
