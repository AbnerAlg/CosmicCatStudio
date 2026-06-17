<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]);
    exit();
}

// Recibir los datos JSON
$data = json_decode(file_get_contents('php://input'), true);
$id_oyente = $data['id_oyente'] ?? null;
$id_producto = $data['id_producto'] ?? null;
$cantidad = $data['cantidad'] ?? 1;  // Cantidad predeterminada en 1 si no se especifica

// Validar los datos
if (!$id_oyente || !$id_producto) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit();
}

// Obtener el stock actual del producto
$sqlStock = "SELECT stock FROM producto WHERE id_producto = ?";
$stmtStock = $conn->prepare($sqlStock);
$stmtStock->bind_param("i", $id_producto);
$stmtStock->execute();
$resultStock = $stmtStock->get_result();

if ($resultStock->num_rows > 0) {
    $producto = $resultStock->fetch_assoc();
    $stockDisponible = $producto['stock'];

    // Obtener la cantidad actual en el carrito (si existe)
    $sqlCarrito = "SELECT cantidad FROM carrito WHERE id_oyente = ? AND id_productos = ?";
    $stmtCarrito = $conn->prepare($sqlCarrito);
    $stmtCarrito->bind_param("ii", $id_oyente, $id_producto);
    $stmtCarrito->execute();
    $resultCarrito = $stmtCarrito->get_result();
    $cantidadEnCarrito = $resultCarrito->num_rows > 0 ? $resultCarrito->fetch_assoc()['cantidad'] : 0;

    // Verificar si la cantidad total excede el stock
    if ($cantidadEnCarrito + $cantidad > $stockDisponible) {
        echo json_encode(["success" => false, "message" => "Stock insuficiente. Stock actual: $stockDisponible. Ya tienes $cantidadEnCarrito en el carrito."]);
        exit();
    }

    // Insertar o actualizar en el carrito
    $sql = "INSERT INTO carrito (id_oyente, id_productos, cantidad) VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("iii", $id_oyente, $id_producto, $cantidad);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Producto agregado al carrito"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al agregar al carrito: " . $stmt->error]);
    }

    $stmt->close();
    $stmtCarrito->close();
} else {
    echo json_encode(["success" => false, "message" => "Producto no encontrado o sin stock disponible"]);
}

$stmtStock->close();
$conn->close();
