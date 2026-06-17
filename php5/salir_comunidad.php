<?php
require 'basedatos.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$id_oyente = $data['id_oyente'];
$id_comunidad = $data['id_comunidad'];

// Eliminar el registro de la comunidad en la tabla oyente_comunidad
$query = "DELETE FROM oyente_comunidad WHERE id_oyente = ? AND id_comunidad = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id_oyente, $id_comunidad);
$success = $stmt->execute();

// Si la eliminación fue exitosa, decrementar la columna comunidades en la tabla oyente
if ($success) {
    $updateComunidades = "UPDATE oyente SET comunidades = comunidades - 1 WHERE id_oyente = ?";
    $stmtUpdate = $conn->prepare($updateComunidades);
    $stmtUpdate->bind_param("i", $id_oyente);
    $stmtUpdate->execute();
    $stmtUpdate->close();
}

echo json_encode(['success' => $success]);
$stmt->close();
$conn->close();
?>
