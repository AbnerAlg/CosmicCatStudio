<?php
require 'basedatos.php'; // Asegúrate de incluir la conexión a la base de datos

header('Content-Type: application/json');

$sql = "SELECT idartista, nombre_artistico, avatar, tipo_avatar FROM artistas";
$result = $conn->query($sql);

$artistas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
