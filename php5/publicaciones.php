<?php
require 'basedatos.php';

header('Content-Type: application/json');

$idComunidad = $_GET['id_comunidad'];

// Consulta para obtener las publicaciones y el nombre del artista asociado
$query = "
    SELECT p.id_publicacion, p.texto, a.nombre AS autor
    FROM publicacion p
    JOIN comunidad c ON p.id_comunidad = c.id_comunidad
    JOIN artistas a ON c.id_artista = a.idartista
    WHERE p.id_comunidad = ?
    ORDER BY p.id_publicacion DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idComunidad);
$stmt->execute();
$result = $stmt->get_result();

$publicaciones = [];
while ($row = $result->fetch_assoc()) {
    // Buscar comentarios de cada publicación
    $queryComentarios = "SELECT texto FROM comentarios WHERE id_publicacion = ?";
    $stmtComentarios = $conn->prepare($queryComentarios);
    $stmtComentarios->bind_param("i", $row['id_publicacion']);
    $stmtComentarios->execute();
    $resultComentarios = $stmtComentarios->get_result();
    $comentarios = $resultComentarios->fetch_all(MYSQLI_ASSOC);

    $row['comentarios'] = $comentarios;
    $publicaciones[] = $row;
}

echo json_encode(['publicaciones' => $publicaciones]);
?>