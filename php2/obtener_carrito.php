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

// Obtener el id del oyente desde la URL
$idOyente = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : null;

if (!$idOyente) {
    echo json_encode(["success" => false, "message" => "ID del oyente no especificado"]);
    exit();
}

// Consulta para obtener los productos del carrito del oyente
$sql = "SELECT p.id_producto, p.nombre AS nombre_producto, p.precio, c.cantidad, p.stock, 
               p.imagen_producto, p.tipo_imagen, a.nombre_artistico 
        FROM carrito c
        JOIN producto p ON c.id_productos = p.id_producto
        JOIN artistas a ON p.id_artista = a.idartista
        WHERE c.id_oyente = '$idOyente'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $carrito = [];
    while ($row = $result->fetch_assoc()) {
        $carrito[] = [
            "id_producto" => $row['id_producto'],
            "nombre_producto" => $row['nombre_producto'],
            "precio" => $row['precio'],
            "cantidad" => $row['cantidad'],
            "stock" => $row['stock'],
            "imagen_producto" => "data:" . $row['tipo_imagen'] . ";base64," . $row['imagen_producto'],
            "nombre_artistico" => $row['nombre_artistico']
        ];
    }
    echo json_encode(["success" => true, "carrito" => $carrito]);
} else {
    echo json_encode(["success" => false, "message" => "No se encontraron productos en el carrito."]);
}

$conn->close();
?>
