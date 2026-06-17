<?php
require 'basedatos.php'; // Asegúrate de tener una conexión con la base de datos

$id_oyente = isset($_GET['id_oyente']) ? intval($_GET['id_oyente']) : null;
$id_artista = isset($_GET['id_artista']) ? intval($_GET['id_artista']) : null;

if (!$id_oyente || !$id_artista) {
    echo json_encode(['error' => 'Datos incompletos']);
    exit;
}

// Verificar si el oyente ya sigue al artista
$query = "SELECT * FROM seguidores WHERE id_oyente = ? AND id_artista = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id_oyente, $id_artista);
$stmt->execute();
$result = $stmt->get_result();
$isFollowing = $result->num_rows > 0;

if ($isFollowing) {
    // Si ya lo sigue, eliminar la relación
    $deleteQuery = "DELETE FROM seguidores WHERE id_oyente = ? AND id_artista = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ii", $id_oyente, $id_artista);
    $stmt->execute();

    // Restar 1 al conteo de seguidores en la tabla de estadísticas del artista
    $updateQuery = "UPDATE estadisticas SET seguidores = seguidores - 1 WHERE idartista = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $id_artista);
    $stmt->execute();

    $isFollowing = false;
} else {
    // Si no lo sigue, insertar la relación
    $insertQuery = "INSERT INTO seguidores (id_oyente, id_artista) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ii", $id_oyente, $id_artista);
    $stmt->execute();

    // Sumar 1 al conteo de seguidores en la tabla de estadísticas del artista
    $updateQuery = "UPDATE estadisticas SET seguidores = seguidores + 1 WHERE idartista = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $id_artista);
    $stmt->execute();

    $isFollowing = true;
}

// Obtener el nuevo número de seguidores
$countQuery = "SELECT seguidores FROM estadisticas WHERE idartista = ?";
$stmt = $conn->prepare($countQuery);
$stmt->bind_param("i", $id_artista);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$nuevos_seguidores = $row ? $row['seguidores'] : 0;

// Devolver respuesta en formato JSON
echo json_encode([
    'isFollowing' => $isFollowing,
    'nuevos_seguidores' => $nuevos_seguidores
]);

$conn->close();
?>
