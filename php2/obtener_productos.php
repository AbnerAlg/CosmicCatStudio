<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]);
    exit();
}

// Verificar si se proporciona un id_producto o un id_oyente en la URL
$id_producto = isset($_GET['id_producto']) ? $conn->real_escape_string($_GET['id_producto']) : null;
$id_oyente = isset($_GET['id_oyente']) ? $conn->real_escape_string($_GET['id_oyente']) : null;

// Modificar la consulta según si se solicita un producto específico, todos los productos o los productos del carrito de un oyente
if ($id_oyente) {
    // Consulta para obtener los productos en el carrito del oyente
    $sql = "SELECT p.id_producto, p.nombre AS nombre_producto, p.precio, p.descripcion, p.stock, 
    p.imagen_producto AS imagen_producto, p.tipo_imagen, a.nombre_artistico 
    FROM producto p
    JOIN artistas a ON p.id_artista = a.idartista";
} elseif ($id_producto) {
    // Consulta para obtener un producto específico
    $sql = "SELECT p.id_producto, p.nombre AS nombre_producto, p.precio, p.descripcion, p.stock, 
                   p.imagen_producto AS imagen_producto, p.tipo_imagen, a.nombre_artistico AS nombre_artista 
            FROM producto p
            JOIN artistas a ON p.id_artista = a.idartista
            WHERE p.id_producto = '$id_producto'";
} else {
    // Consulta para obtener todos los productos
    $sql = "SELECT p.id_producto, p.nombre AS nombre_producto, p.precio, p.descripcion, p.stock, 
                   p.imagen_producto AS imagen_producto, p.tipo_imagen, a.nombre_artistico AS nombre_artista 
            FROM producto p
            JOIN artistas a ON p.id_artista = a.idartista";
}

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Preparar el resultado dependiendo de la consulta realizada
    if ($id_oyente) {
        // Productos en el carrito del oyente
        $carrito = [];
        while ($row = $result->fetch_assoc()) {
            $row['imagen_producto'] = "data:" . $row['tipo_imagen'] . ";base64," . $row['imagen_producto'];
            $carrito[] = $row;
        }
        echo json_encode(["success" => true, "carrito" => $carrito]);
    } elseif ($id_producto) {
        // Producto específico
        $producto = $result->fetch_assoc();
        $producto['imagen_producto'] = "data:" . $producto['tipo_imagen'] . ";base64," . $producto['imagen_producto'];
        echo json_encode(["success" => true, "producto" => $producto]);
    } else {
        // Todos los productos
        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $row['imagen_producto'] = "data:" . $row['tipo_imagen'] . ";base64," . $row['imagen_producto'];
            $productos[] = $row;
        }
        echo json_encode(["success" => true, "productos" => $productos]);
    }
} else {
    $mensaje = $id_oyente ? "No se encontraron productos en el carrito." : ($id_producto ? "Producto no encontrado" : "No se encontraron productos.");
    echo json_encode(["success" => false, "message" => $mensaje]);
}

$conn->close();
?>
