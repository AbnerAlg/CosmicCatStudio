<?php
require 'basedatos.php';

header('Content-Type: application/json');

$id_artista = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_artista > 0) {
    // Obtener los seguidores del artista
    $sql = "SELECT o.nombre, o.avatar, o.avatar_tipo 
            FROM seguidores s
            JOIN oyente o ON s.id_oyente = o.id_oyente
            WHERE s.id_artista = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_artista);
    $stmt->execute();
    $result = $stmt->get_result();

    $seguidores = [];
    while ($row = $result->fetch_assoc()) {
        $seguidores[] = [
            'nombre' => $row['nombre'],
            'avatar' => $row['avatar'],
            'avatar_tipo' => $row['avatar_tipo']
        ];
    }

    echo json_encode(['seguidores' => $seguidores]);
    $stmt->close();
} else {
    echo json_encode(['seguidores' => []]);
}

$conn->close();
?>
