<?php
require_once 'basedatos.php'; // Incluye tu archivo de conexión a la base de datos

$id_artista = isset($_GET['id_artista']) ? intval($_GET['id_artista']) : 0;

if ($id_artista > 0) {
    $query = "SELECT id_album, nombre, tipo_foto, foto FROM album WHERE id_artista = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_artista);
    $stmt->execute();
    $result = $stmt->get_result();

    $albums = [];
    while ($fila = $result->fetch_assoc()) {
        $albums[] = $fila;
    }

    echo json_encode($albums);
} else {
    echo json_encode(["error" => "ID de artista inválido."]);
}

$stmt->close();
$conn->close();
?>
