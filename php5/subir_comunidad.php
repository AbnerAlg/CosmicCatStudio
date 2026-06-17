<?php
require 'basedatos.php';

header('Content-Type: application/json');

// Obtener los datos del JSON enviado
$data = json_decode(file_get_contents('php://input'), true);

$nombre = $data['nombre'];
$descripcion = $data['descripcion'];
$foto = $data['foto'];  // La imagen en base64 (sin el tipo MIME)
$tipo_foto = $data['tipo_foto'];  // El tipo MIME de la imagen
$idArtista = $data['id_artista'];

// Verificar si ya tiene una comunidad
$queryVerificacion = "SELECT id_comunidad FROM comunidad WHERE id_artista = ?";
$stmtVerificacion = $conn->prepare($queryVerificacion);
$stmtVerificacion->bind_param("i", $idArtista);
$stmtVerificacion->execute();
$resultVerificacion = $stmtVerificacion->get_result();

if ($resultVerificacion->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El artista ya tiene una comunidad.']);
} else {
    // Insertar la nueva comunidad
    $queryInsertar = "INSERT INTO comunidad (nombre, foto, tipo_foto, descripcion, id_artista) VALUES (?, ?, ?, ?, ?)";
    $stmtInsertar = $conn->prepare($queryInsertar);
    $stmtInsertar->bind_param("ssssi", $nombre, $foto, $tipo_foto, $descripcion, $idArtista);

    if ($stmtInsertar->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al crear la comunidad.']);
    }

    $stmtInsertar->close();
}
$stmtVerificacion->close();
$conn->close();
?>