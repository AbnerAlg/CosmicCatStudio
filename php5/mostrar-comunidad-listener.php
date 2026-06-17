<?php
include 'basedatos.php';

header('Content-Type: application/json');

$id_oyente = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_oyente > 0) {
    // Obtener comunidades a las que el oyente no pertenece
    $query = "SELECT c.id_comunidad, c.nombre, c.foto, c.tipo_foto, a.nombre AS artista_nombre 
              FROM comunidad c
              JOIN artistas a ON c.id_artista = a.idartista
              WHERE c.id_comunidad NOT IN (
                  SELECT oc.id_comunidad 
                  FROM oyente_comunidad oc 
                  WHERE oc.id_oyente = ?
              )";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_oyente);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $comunidades = [];
    while ($row = $result->fetch_assoc()) {
        $comunidades[] = [
            "id_comunidad" => $row['id_comunidad'],
            "nombre" => $row['nombre'],
            "foto" => $row['foto'],
            "tipo_foto" => $row['tipo_foto'],
            "artista_nombre" => $row['artista_nombre']
        ];
    }
    
    echo json_encode(["success" => true, "comunidades" => $comunidades]);
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID de oyente inválido"]);
}

$conn->close();
?>
