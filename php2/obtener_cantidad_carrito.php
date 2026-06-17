<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]);
    exit();
}

// Obtener id_oyente y id_producto desde los parámetros de la URL
$idOyente = isset($_GET['id_oyente']) ? (int) $_GET['id_oyente'] : null;
$idProducto = isset($_GET['id_producto']) ? (int) $_GET['id_producto'] : null;

if (!$idOyente || !$idProducto) {
    echo json_encode(["success" => false, "message" => "ID del oyente o del producto no especificado"]);
    exit();
}

// Consulta para obtener la cantidad del producto en el carrito
$sql = "SELECT cantidad FROM carrito WHERE id_oyente = ? AND id_productos = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $idOyente, $idProducto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $carrito = $result->fetch_assoc();
    echo json_encode(["success" => true, "cantidad_en_carrito" => $carrito['cantidad']]);
} else {
    echo json_encode(["success" => true, "cantidad_en_carrito" => 0]);
}

$stmt->close();
$conn->close();
?>
