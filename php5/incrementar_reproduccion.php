<?php
require 'basedatos.php';

$id_musica = intval($_GET['id_musica']);
$id_oyente = intval($_GET['id_oyente']); // El ID del oyente se debe pasar en la URL

// Incrementar el contador de reproducciones
$sql_update = "UPDATE musica SET reproducciones = reproducciones + 1 WHERE id_musica = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("i", $id_musica);
$stmt_update->execute();
$stmt_update->close();

// Verificar si la canción ya está en el historial del oyente
$sql_check = "SELECT id_historial FROM historial_reproducciones WHERE id_oyente = ? AND id_musica = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id_oyente, $id_musica);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

$fecha_actual = date('Y-m-d H:i:s');

if ($result_check->num_rows > 0) {
    // Si ya existe, actualizamos la fecha de reproducción
    $sql_update_historial = "UPDATE historial_reproducciones SET fecha_reproduccion = ? WHERE id_oyente = ? AND id_musica = ?";
    $stmt_update_historial = $conn->prepare($sql_update_historial);
    $stmt_update_historial->bind_param("sii", $fecha_actual, $id_oyente, $id_musica);
    $stmt_update_historial->execute();
    $stmt_update_historial->close();
} else {
    // Si no existe, agregamos un nuevo registro al historial
    $sql_insert = "INSERT INTO historial_reproducciones (id_oyente, id_musica, fecha_reproduccion) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iis", $id_oyente, $id_musica, $fecha_actual);
    $stmt_insert->execute();
    $stmt_insert->close();
}

// Verificar si el historial tiene más de 50 registros
$sql_count = "SELECT COUNT(*) as total FROM historial_reproducciones WHERE id_oyente = ?";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $id_oyente);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$total = $result_count->fetch_assoc()['total'];
$stmt_count->close();

// Si hay más de 50 registros, eliminar el más antiguo
if ($total > 50) {
    $sql_delete = "DELETE FROM historial_reproducciones WHERE id_oyente = ? ORDER BY fecha_reproduccion ASC LIMIT 1";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_oyente);
    $stmt_delete->execute();
    $stmt_delete->close();
}

$conn->close();
?>
