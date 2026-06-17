<?php
require 'basedatos.php'; // Asegúrate de conectar correctamente con tu base de datos

// Obtener los datos JSON desde php://input
$data = json_decode(file_get_contents("php://input"), true);

// Verificar que los datos hayan sido enviados y que contengan productos
if (isset($data['productos']) && is_array($data['productos'])) {
    $productos = $data['productos'];

    foreach ($productos as $producto) {
        $idProducto = $producto['id'];
        $cantidad = $producto['cantidad'];

        // Actualizar el stock en la base de datos
        $query = "UPDATE producto SET stock = stock - ? WHERE id_producto = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $cantidad, $idProducto);
        $stmt->execute();
    }

    echo json_encode(["success" => true, "message" => "Stock actualizado correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}
?>

