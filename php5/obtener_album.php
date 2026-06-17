<?php
require 'basedatos.php';

$id_album = isset($_GET['id_album']) ? intval($_GET['id_album']) : 0;

if ($id_album > 0) {
    $query = "SELECT nombre, tipo_foto, foto FROM album WHERE id_album = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_album);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    echo json_encode($result);
} else {
    echo json_encode(["error" => "ID de álbum inválido."]);
}
$stmt->close();
$conn->close();
?>
