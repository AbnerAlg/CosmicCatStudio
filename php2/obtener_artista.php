<?php
header('Content-Type: application/json');

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");

// Verificar la conexión
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]);
    exit();
}

// Verificar si se ha proporcionado el id a través del método GET
if (isset($_GET['id'])) {
    $id_artista = $_GET['id'];

    // Consulta para obtener los datos del artista por su id
    $sql = "SELECT nombre, descripcion, stock, precio FROM artistas WHERE idartista = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_artista);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(["success" => true, "data" => $data]);
    } else {
        echo json_encode(["success" => false, "message" => "No se encontró un artista con ese ID."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "No se proporcionó un ID válido."]);
}

// Cerrar la conexión
$conn->close();
?>
