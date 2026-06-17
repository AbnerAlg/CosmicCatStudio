<?php
require 'basedatos.php';

$id_musica = intval($_POST['id_musica']);

// Elimina primero los registros en historial_reproducciones que tengan el id_musica especificado
$sql_historial = "DELETE FROM historial_reproducciones WHERE id_musica = ?";
$stmt_historial = $conn->prepare($sql_historial);
$stmt_historial->bind_param("i", $id_musica);
$stmt_historial->execute();

// Luego, elimina el registro de la canción en la tabla musica
$sql_musica = "DELETE FROM musica WHERE id_musica = ?";
$stmt_musica = $conn->prepare($sql_musica);
$stmt_musica->bind_param("i", $id_musica);
$stmt_musica->execute();

// Verifica si la canción fue eliminada exitosamente
if ($stmt_musica->affected_rows > 0) {
    echo 'Canción y referencias eliminadas exitosamente';
} else {
    echo 'Error al eliminar la canción';
}

// Cierra las declaraciones y la conexión
$stmt_historial->close();
$stmt_musica->close();
$conn->close();
?>
