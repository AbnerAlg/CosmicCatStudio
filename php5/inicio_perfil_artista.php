<?php
include 'basedatos.php'; // Conexión a la base de datos

// Obtener el ID del artista desde la URL
$id_artista = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_artista > 0) {
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
            'seguidores' => $estadisticas['seguidores'],
            'oyentes' => $estadisticas['oyentes'],
            'lanzamientos' => $estadisticas['lanzamientos'],
            'id_artista' => $id_artista,
            'descripcion' => $artista['descripcion']
        ];

        // Convertir a JSON
        $json_data = json_encode($data);
    } else {
        echo "No se encontraron datos.";
        
    }

    $stmt_artista->close();
    $stmt_estadisticas->close();
} else {
    echo "ID de artista inválido.";
    
}

$conn->close(); // Cerrar la conexión a la base de datos
?>