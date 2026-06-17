<?php
require 'basedatos.php';

$id_artista = isset($_GET['id_artista']) ? intval($_GET['id_artista']) : 0;

if ($id_artista > 0) {
    $query = "
        SELECT m.id_musica, m.foto, m.tipo_foto, m.titulo AS nombre
        FROM musica m
        LEFT JOIN album_cancion ac ON m.id_musica = ac.id_cancion
        WHERE m.id_artista = ? AND ac.id_album IS NULL";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_artista);
    $stmt->execute();
    $result = $stmt->get_result();

    $canciones = [];
    while ($row = $result->fetch_assoc()) {
        $canciones[] = [
            'id_musica' => $row['id_musica'],
            'foto' => $row['foto'],
            'tipo_foto' => $row['tipo_foto'],
            'nombre' => $row['nombre']
        ];
    }

    echo json_encode($canciones);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
