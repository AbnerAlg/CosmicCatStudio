<?php
require 'basedatos.php';

// Recibir los datos JSON en lugar de POST directo
$data = json_decode(file_get_contents("php://input"), true);

$id_album = intval($data['id_album']);
$nombre_album = $data['nombre_album'];
$descripcion = $data['descripcion'];
$foto_base64 = isset($data['foto']) ? $data['foto'] : null; // Base64 de la imagen, si existe

// Preparar la consulta
if ($foto_base64) {
    // Convertir Base64 a binario
    $foto = $foto_base64;
    $tipo_foto = 'image/jpeg'; // Puedes ajustar el tipo de imagen según lo esperado o enviarlo también en el JSON

    $query = "UPDATE album SET nombre = ?, descripcion = ?, foto = ?, tipo_foto = ? WHERE id_album = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $nombre_album, $descripcion, $foto, $tipo_foto, $id_album);
} else {
    $query = "UPDATE album SET nombre = ?, descripcion = ? WHERE id_album = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $nombre_album, $descripcion, $id_album);
}

// Ejecutar y responder
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Álbum actualizado con éxito']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el álbum']);
}

$stmt->close();
$conn->close();
?>
