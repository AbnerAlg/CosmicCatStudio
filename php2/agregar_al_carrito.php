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
    $conn->close();
