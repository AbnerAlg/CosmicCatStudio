<?php
include 'basedatos.php';

header('Content-Type: application/json');

// Obtener los datos enviados desde el frontend
$data = json_decode(file_get_contents("php://input"), true);
$id_comunidad = $data['id_comunidad'] ?? null;
$id_oyente = $data['id_oyente'] ?? null;

if ($id_comunidad && $id_oyente) {
    // Insertar el registro en la tabla oyente_comunidad
    $query = "INSERT INTO oyente_comunidad (id_comunidad, id_oyente) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_comunidad, $id_oyente);

    if ($stmt->execute()) {
        // Incrementar el contador de comunidades en la tabla oyente
        $updateComunidades = "UPDATE oyente SET comunidades = comunidades + 1 WHERE id_oyente = ?";
        $stmtUpdate = $conn->prepare($updateComunidades);
        $stmtUpdate->bind_param("i", $id_oyente);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        echo json_encode(["success" => true, "message" => "Ingreso exitoso a la comunidad y contador actualizado"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al unirse a la comunidad"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}

$conn->close();
?>
