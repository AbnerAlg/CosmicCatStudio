<?php
require 'basedatos.php';

header('Content-Type: application/json');

$id_oyente = $_GET['id_oyente'] ?? null;

if ($id_oyente) {
    // Obtener los IDs de los artistas que sigue el oyente
    $query = "SELECT id_artista FROM seguidores WHERE id_oyente = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_oyente);
    $stmt->execute();
    $result = $stmt->get_result();

    $artistas = [];
    
    while ($row = $result->fetch_assoc()) {
        $id_artista = $row['id_artista'];

        // Obtener los datos del artista desde la tabla artistas
        $queryArtista = "SELECT idartista, avatar, tipo_avatar FROM artistas WHERE idartista = ?";
        $stmtArtista = $conn->prepare($queryArtista);
        $stmtArtista->bind_param("i", $id_artista);
        $stmtArtista->execute();
        $resultArtista = $stmtArtista->get_result();
        
        if ($artista = $resultArtista->fetch_assoc()) {
            $artista['avatar'] = $artista['avatar']; // Convertir la imagen a base64
            $artistas[] = $artista; // Agregar a la lista de artistas
        }
        $stmtArtista->close();
    }

    echo json_encode(["success" => true, "artistas" => $artistas]);
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID de oyente no proporcionado"]);
}

$conn->close();
?>
