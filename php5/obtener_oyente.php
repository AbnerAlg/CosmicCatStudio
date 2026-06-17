<?php
require 'basedatos.php';

header('Content-Type: application/json');
$id_oyente = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_oyente > 0) {
    $query = "SELECT avatar, avatar_tipo FROM oyente WHERE id_oyente = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_oyente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $oyente = $result->fetch_assoc();
        echo json_encode([
            "success" => true,
            "avatar" => $oyente['avatar'],
            "avatar_tipo" => $oyente['avatar_tipo']
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Oyente no encontrado"]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID de oyente inválido"]);
}

$conn->close();
?>