<?php
    header('Content-Type: application/json');
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $conn = new mysqli("localhost", "root", "", "cosmiccatstudio");

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]);
        exit();
    }

    // Recibir el id_oyente y id_producto desde los datos JSON
    $data = json_decode(file_get_contents('php://input'), true);
    $id_oyente = $data['id_oyente'] ?? null;
    $id_producto = $data['id_producto'] ?? null;

    if (!$id_oyente || !$id_producto) {
        echo json_encode(["success" => false, "message" => "Datos incompletos"]);
        exit();
    }

    // Eliminar el producto del carrito
    $sql = "DELETE FROM carrito WHERE id_oyente = ? AND id_productos = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_oyente, $id_producto);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Producto eliminado del carrito"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar el producto del carrito: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
?>
