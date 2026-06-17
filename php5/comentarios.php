<?php
require 'basedatos.php';

header('Content-Type: application/json');
$id_publicacion = isset($_GET['id_publicacion']) ? intval($_GET['id_publicacion']) : 0;

if ($id_publicacion > 0) {
    $query = "SELECT c.texto, o.nombre, o.avatar, o.avatar_tipo 
              FROM comentarios c
              JOIN oyente o ON c.id_oyente = o.id_oyente
              WHERE c.id_publicacion = ?
              ORDER BY c.id_comentario DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_publicacion);
    $stmt->execute();
    $result = $stmt->get_result();

    $comentarios = [];
    while ($row = $result->fetch_assoc()) {
        $comentarios[] = [
            "nombre" => $row['nombre'],
            "avatar" => $row['avatar'],
            "avatar_tipo" => $row['avatar_tipo'],
            "texto" => $row['texto']
        ];
    }

    echo json_encode(["success" => true, "comentarios" => $comentarios]);
} else {
    echo json_encode(["success" => false, "message" => "ID de publicación no válido."]);
}

$conn->close();
?>