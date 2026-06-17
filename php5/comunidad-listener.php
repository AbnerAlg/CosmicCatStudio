<?php
require 'basedatos.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener el ID del oyente desde la URL
$id_oyente = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_oyente > 0) {
    // Consultar si el oyente pertenece a alguna comunidad
    $query = "SELECT oc.id_comunidad, c.nombre, c.foto, c.tipo_foto, c.id_artista 
              FROM oyente_comunidad oc
              JOIN comunidad c ON oc.id_comunidad = c.id_comunidad
              WHERE oc.id_oyente = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_oyente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el oyente pertenece a una o más comunidades, enviar los datos
        $comunidades = [];
        while ($row = $result->fetch_assoc()) {
            $id_comunidad = $row['id_comunidad'];
            $id_artista = $row['id_artista']; // Obtener el id_artista de la comunidad

            // Obtener publicaciones de la comunidad
            $query_pub = "SELECT p.id_publicacion, p.texto 
                          FROM publicacion p 
                          WHERE p.id_comunidad = ?
                          ORDER BY p.id_publicacion DESC";
            $stmt_pub = $conn->prepare($query_pub);
            $stmt_pub->bind_param("i", $id_comunidad);
            $stmt_pub->execute();
            $result_pub = $stmt_pub->get_result();

            $publicaciones = [];
            while ($pub = $result_pub->fetch_assoc()) {
                $id_publicacion = $pub['id_publicacion'];

                // Obtener comentarios para la publicación
                $query_com = "SELECT c.texto, o.nombre, o.avatar, o.avatar_tipo 
                              FROM comentarios c 
                              JOIN oyente o ON c.id_oyente = o.id_oyente
                              WHERE c.id_publicacion = ?
                              ORDER BY c.id_comentario DESC";
                $stmt_com = $conn->prepare($query_com);
                $stmt_com->bind_param("i", $id_publicacion);
                $stmt_com->execute();
                $result_com = $stmt_com->get_result();

                $comentarios = [];
                while ($com = $result_com->fetch_assoc()) {
                    $comentarios[] = [
                        "nombre" => $com['nombre'],
                        "avatar" => $com['avatar'],
                        "avatar_tipo" => $com['avatar_tipo'],
                        "texto" => $com['texto']
                    ];
                }
                $publicaciones[] = [
                    "id_publicacion" => $pub['id_publicacion'],
                    "texto" => $pub['texto'],
                    "comentarios" => $comentarios,
                    
                ];
            }

            $comunidades[] = [
                "id_comunidad" => $row['id_comunidad'],
                "nombre" => $row['nombre'],
                "foto" => $row['foto'],
                "tipo_foto" => $row['tipo_foto'],
                 "id_artista" => $id_artista, // Incluir id_artista en la respuesta
                "publicaciones" => $publicaciones
            ];
        }

        echo json_encode(["success" => true, "comunidades" => $comunidades]);
    } else {
        // El oyente no pertenece a ninguna comunidad
        echo json_encode(["success" => false, "message" => "Parece que todavía no perteneces a una comunidad."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID de oyente inválido."]);
}

$conn->close();
?>
