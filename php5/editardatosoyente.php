<?php
require 'basedatos.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$nombre = $edad = $nacionalidad = $avatar = $avatar_tipo = $banner = $banner_tipo = "";

// Si es una solicitud GET, cargar los datos del oyente
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_oyente = $_GET['id'];

    $query = "SELECT nombre, edad, nacionalidad, avatar, avatar_tipo, banner, banner_tipo FROM oyente WHERE id_oyente = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id_oyente);
        $stmt->execute();
        $stmt->bind_result($nombre, $edad, $nacionalidad, $avatar, $avatar_tipo, $banner, $banner_tipo);

        if ($stmt->fetch()) {
            ob_clean();
            echo json_encode([
                "success" => true,
                "data" => [
                    "nombre" => $nombre,
                    "edad" => $edad,
                    "nacionalidad" => $nacionalidad,
                    "avatar" => $avatar,
                    "avatar_tipo" => $avatar_tipo,
                    "banner" => $banner,
                    "banner_tipo" => $banner_tipo
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "No se encontró ningún oyente con ese ID."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error en la consulta a la base de datos."]);
    }
    exit;
}

// Si es una solicitud POST, actualizar los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["success" => false, "message" => "Error al decodificar JSON"]);
            return;
        }

        if ($data) {
            $nombre = $data['nombre'];
            $edad = $data['edad'];
            $nacionalidad = $data['nacionalidad'];
            $avatar = $data['avatar'] ?? null;
            $avatar_tipo = $data['avatar_tipo'] ?? null;
            $banner = $data['banner'] ?? null;
            $banner_tipo = $data['banner_tipo'] ?? null;
            $id_oyente = $_GET['id'];

            if (empty($nombre)) {
                echo json_encode(["success" => false, "message" => "Los campos Nombre son obligatorios."]);
                return;
            }

            $query = "UPDATE oyente SET nombre = ?, edad = ?, nacionalidad = ?, 
                      avatar = IFNULL(?, avatar), avatar_tipo = IFNULL(?, avatar_tipo), 
                      banner = IFNULL(?, banner), banner_tipo = IFNULL(?, banner_tipo) 
                      WHERE id_oyente = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sisssssi", $nombre, $edad, $nacionalidad, $avatar, $avatar_tipo, $banner, $banner_tipo, $id_oyente);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Datos actualizados correctamente."]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al actualizar los datos."]);
            }
            $stmt->close();
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

$conn->close();
?>
