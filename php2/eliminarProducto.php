<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]);
    exit();
}

// Obtener el id del producto desde la URL
$id_prod = isset($_GET['id_prod']) ? (int)$_GET['id_prod'] : null;
if (!$id_prod) {
    echo json_encode(["success" => false, "message" => "ID del producto no especificado."]);
    exit();
}

// Primero, elimina el producto en la tabla carrito donde id_productos coincida
$sql_carrito = "DELETE FROM carrito WHERE id_productos = ?";
$stmt_carrito = $conn->prepare($sql_carrito);
if (!$stmt_carrito) {
    echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta de carrito: " . $conn->error]);
    exit();
}
$stmt_carrito->bind_param("i", $id_prod);
$stmt_carrito->execute();
$stmt_carrito->close();

// Luego, elimina el producto de la tabla producto
$sql_producto = "DELETE FROM producto WHERE id_producto = ?";
$stmt_producto = $conn->prepare($sql_producto);
if (!$stmt_producto) {
    echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta de producto: " . $conn->error]);
    exit();
}

$stmt_producto->bind_param("i", $id_prod);

if ($stmt_producto->execute()) {
    echo json_encode(["success" => true, "message" => "Producto y referencias en carrito eliminados exitosamente."]);
} else {
    echo json_encode(["success" => false, "message" => "Error al eliminar el producto: " . $stmt_producto->error]);
}

// Cerrar la conexión
$stmt_producto->close();
$conn->close();
?>

