<?php
// Conectar a la base de datos
require 'basedatos.php';

// Obtener el id del artista desde la URL
$id_artista = isset($_GET['id_artista']) ? intval($_GET['id_artista']) : 0;

// Verificar que el ID del artista es válido
if ($id_artista > 0) {
    // Preparar y ejecutar la consulta para obtener los álbums del artista
    $query = "SELECT id_album, foto, tipo_foto FROM album WHERE id_artista = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_artista);
    $stmt->execute();
    $result = $stmt->get_result();

    // Crear un arreglo para almacenar los álbums
    $albums = [];

    while ($row = $result->fetch_assoc()) {
        $albums[] = [
            'id_album' => $row['id_album'],
            'foto' => $row['foto'],
            'tipo_foto' => $row['tipo_foto']
        ];
    }

    // Enviar la respuesta en formato JSON
    echo json_encode($albums);
} else {
    // Responder con un arreglo vacío si el id_artista no es válido
    echo json_encode([]);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
