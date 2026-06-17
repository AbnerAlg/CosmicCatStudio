<?php
require 'basedatos.php';

header('Content-Type: application/json');

$id_artista = isset($_GET['idart']) ? intval($_GET['idart']) : 0;
$id_oyente = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_artista > 0 && $id_oyente > 0) {
    // Consultar los datos del artista
    $sql_artista = "SELECT nombre_artistico, avatar, banner, tipo_avatar, tipo_banner, descripcion FROM artistas WHERE idartista = ?";
    $stmt_artista = $conn->prepare($sql_artista);
    $stmt_artista->bind_param("i", $id_artista);
    $stmt_artista->execute();
    $resultado_artista = $stmt_artista->get_result();

    // Consultar las estadísticas
    $sql_estadisticas = "SELECT seguidores, seguidos, oyentes, lanzamientos FROM estadisticas WHERE idartista = ?";
    $stmt_estadisticas = $conn->prepare($sql_estadisticas);
    $stmt_estadisticas->bind_param("i", $id_artista);
    $stmt_estadisticas->execute();
    $resultado_estadisticas = $stmt_estadisticas->get_result();

    // Verificar si el oyente sigue al artista
    $sql_seguimiento = "SELECT * FROM seguidores WHERE id_oyente = ? AND id_artista = ?";
    $stmt_seguimiento = $conn->prepare($sql_seguimiento);
    $stmt_seguimiento->bind_param("ii", $id_oyente, $id_artista);
    $stmt_seguimiento->execute();
    $resultado_seguimiento = $stmt_seguimiento->get_result();
    $isFollowing = $resultado_seguimiento->num_rows > 0;

    if ($resultado_artista->num_rows > 0 && $resultado_estadisticas->num_rows > 0) {
        $artista = $resultado_artista->fetch_assoc();
        $estadisticas = $resultado_estadisticas->fetch_assoc();

        // Preparar los datos para pasar a JavaScript
        $data = [
            'nombre_artistico' => $artista['nombre_artistico'],
            'avatar' => [
                'data' => $artista['avatar'],
                'type' => $artista['tipo_avatar'],
            ],
            'banner' => [
                'data' => $artista['banner'],
                'type' => $artista['tipo_banner'],
            ],
            'descripcion' => $artista['descripcion'],
            'seguidores' => $estadisticas['seguidores'],
            'seguidos' => $estadisticas['seguidos'],
            'oyentes' => $estadisticas['oyentes'],
            'lanzamientos' => $estadisticas['lanzamientos'],
            'isFollowing' => $isFollowing  // Estado de seguimiento
        ];

        echo json_encode($data);
    } else {
        echo json_encode(["success" => false, "message" => "No se encontraron datos del artista."]);
    }

    $stmt_artista->close();
    $stmt_estadisticas->close();
    $stmt_seguimiento->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos inválidos"]);
}

$conn->close();
?>
