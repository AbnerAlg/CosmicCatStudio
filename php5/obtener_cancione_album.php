<?php
require 'basedatos.php';

$id_album = isset($_GET['id_album']) ? intval($_GET['id_album']) : 0;

if ($id_album > 0) {
    // Obtener los id_cancion asociados al álbum
    $query = "SELECT id_cancion FROM album_cancion WHERE id_album = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_album);
    $stmt->execute();
    $result = $stmt->get_result();

    $canciones = [];
    while ($fila = $result->fetch_assoc()) {
        $id_cancion = $fila['id_cancion'];

        // Para cada id_cancion, obtener detalles de la canción
        $query_cancion = "SELECT id_musica, titulo, tipo_audio, archivo, tipo_foto, foto FROM musica WHERE id_musica = ?";
        $stmt_cancion = $conn->prepare($query_cancion);
        $stmt_cancion->bind_param("i", $id_cancion);
        $stmt_cancion->execute();
        $result_cancion = $stmt_cancion->get_result()->fetch_assoc();

        if ($result_cancion) {
            $canciones[] = $result_cancion;
        }
    }

    echo json_encode($canciones);
} else {
    echo json_encode(["error" => "ID de álbum inválido."]);
}
$stmt->close();
$conn->close();
?>
