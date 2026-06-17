<?php
require 'basedatos.php';

$query = "SELECT idartista, nombre_artistico, avatar, tipo_avatar FROM artistas";
$result = $conn->query($query);

$artistas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $artistas[] = [
            'idartista' => $row['idartista'],
            'nombre_artistico' => $row['nombre_artistico'],
            'avatar' => $row['avatar'],
            'tipo_avatar' => $row['tipo_avatar']
        ];
    }
}

echo json_encode($artistas);
$conn->close();
?>
