<?php
require 'basedatos.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$id_oyente = $data['id_oyente'];
$id_artista = $data['id_artista'];

// Insertar en la tabla seguidores
$query = "INSERT INTO seguidores (id_oyente, id_artista) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id_oyente, $id_artista);
$success = $stmt->execute();

// Si la inserción fue exitosa, incrementar los contadores de seguidores y siguiendo
if ($success) {
    // Incrementar el contador de seguidores del artista en la tabla estadisticas
    $updateSeguidores = "UPDATE estadisticas SET seguidores = seguidores + 1 WHERE idartista = ?";
    $stmtUpdate = $conn->prepare($updateSeguidores);
    $stmtUpdate->bind_param("i", $id_artista);
    $stmtUpdate->execute();
    $stmtUpdate->close();

    // Incrementar el contador de siguiendo en la tabla oyente
    $updateSiguiendo = "UPDATE oyente SET siguiendo = siguiendo + 1 WHERE id_oyente = ?";
    $stmtUpdateOyente = $conn->prepare($updateSiguiendo);
    $stmtUpdateOyente->bind_param("i", $id_oyente);
    $stmtUpdateOyente->execute();
    $stmtUpdateOyente->close();
}

echo json_encode(['success' => $success]);
$stmt->close();
$conn->close();
?>
