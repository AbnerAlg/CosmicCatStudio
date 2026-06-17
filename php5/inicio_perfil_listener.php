<?php
require 'basedatos.php'; // Conexión a la base de datos

// Obtener el ID del oyente desde la URL
$id_oyente = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_oyente > 0) {
    // Consultar los datos del oyente
    $sql_oyente = "SELECT nombre, avatar, avatar_tipo, banner, banner_tipo, siguiendo, comunidades FROM oyente WHERE id_oyente = ?";
    $stmt_oyente = $conn->prepare($sql_oyente);
    $stmt_oyente->bind_param("i", $id_oyente);
    $stmt_oyente->execute();
    $resultado_oyente = $stmt_oyente->get_result();

    if ($resultado_oyente->num_rows > 0) {
        $oyente = $resultado_oyente->fetch_assoc();

        // Preparar los datos para pasar a JavaScript
        $data = [
            'nombre' => $oyente['nombre'],
            'avatar' => [
                'data' => $oyente['avatar'],
                'type' => $oyente['avatar_tipo'],
            ],
            'banner' => [
                'data' => $oyente['banner'],
                'type' => $oyente['banner_tipo'],
            ],
            'siguiendo' => $oyente['siguiendo'],
            'comunidades' => $oyente['comunidades']
        ];

        // Convertir a JSON
        $json_data = json_encode($data);
    } else {
        echo "No se encontraron datos del oyente.";
    }

    $stmt_oyente->close();
} else {
    echo "ID de oyente inválido.";
}

$conn->close(); // Cerrar la conexión a la base de datos
?>