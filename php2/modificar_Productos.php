<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]);
    exit();
}

$id_art = isset($_GET['id_art']) ? (int)$_GET['id_art'] : null;
$id_prod = isset($_GET['id_prod']) ? (int)$_GET['id_prod'] : null;

if (!$id_art || !$id_prod) {
    echo json_encode(["success" => false, "message" => "ID del artista o producto no especificado en la URL."]);
    exit();
}

// Obtener los datos enviados
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$stock = (int)$_POST['stock'];
$precio = (float)$_POST['precio'];

// Verificar si hay una nueva imagen codificada en base64
if (!empty($_POST['imagen_producto']) && !empty($_POST['tipo_imagen'])) {
    $imagen_producto = $_POST['imagen_producto'];
    $tipo_imagen = $_POST['tipo_imagen'];

    $sql = "UPDATE producto SET nombre = ?, descripcion = ?, stock = ?, precio = ?, imagen_producto = ?, tipo_imagen = ? WHERE id_producto = ? AND id_artista = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssidssii', $nombre, $descripcion, $stock, $precio, $imagen_producto, $tipo_imagen, $id_prod, $id_art);
} else {
    $sql = "UPDATE producto SET nombre = ?, descripcion = ?, stock = ?, precio = ? WHERE id_producto = ? AND id_artista = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssidii", $nombre, $descripcion, $stock, $precio, $id_prod, $id_art);
}

// Ejecutar la consulta
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Producto modificado exitosamente."]);
} else {
    echo json_encode(["success" => false, "message" => "Error al modificar el producto: " . $stmt->error]);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
