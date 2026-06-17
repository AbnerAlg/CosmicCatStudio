<?php
require 'basedatos.php';

$nombre_album = $_POST['nombre_album'];
$descripcion = $_POST['descripcion'];
$id_artista = intval($_POST['id_artista']);
$canciones = json_decode($_POST['canciones'], true);
$foto_base64 = $_POST['foto_base64']; // Imagen en base64
$tipo_foto = 'image/jpeg'; // Suponiendo que es JPEG, puedes ajustarlo según el tipo que esperes

// Decodificar base64 a binario
$foto = $foto_base64;

$query_album = "INSERT INTO album (nombre, descripcion, foto, tipo_foto, id_artista) VALUES (?, ?, ?, ?, ?)";
$stmt_album = $conn->prepare($query_album);
$stmt_album->bind_param("ssssi", $nombre_album, $descripcion, $foto, $tipo_foto, $id_artista);

if ($stmt_album->execute()) {
    $id_album = $stmt_album->insert_id;

    $query_cancion = "INSERT INTO album_cancion (id_cancion, id_album) VALUES (?, ?)";
    $stmt_cancion = $conn->prepare($query_cancion);

    foreach ($canciones as $id_cancion) {
        $stmt_cancion->bind_param("ii", $id_cancion, $id_album);
        $stmt_cancion->execute();
    }

    echo json_encode(['success' => true, 'message' => 'Álbum creado con éxito']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al crear el álbum']);
}

$stmt_album->close();
$stmt_cancion->close();
$conn->close();
?>
