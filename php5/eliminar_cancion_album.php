<?php
require 'basedatos.php';

$id_album = intval($_GET['id_album']);
$id_musica = intval($_GET['id_musica']);

$query = "DELETE FROM album_cancion WHERE id_album = ? AND id_cancion = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id_album, $id_musica);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Canción eliminada del álbum']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar la canción del álbum']);
}

$stmt->close();
$conn->close();
?>
