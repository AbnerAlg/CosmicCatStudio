<?php
require 'basedatos.php';

// Deshabilitar salida de errores visibles
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log');

// Inicializamos las variables
$nombre = $nombre_artistico = $edad = $nacionalidad = $genero = $avatar = $descripcion = $tipo_avatar=$banner=$tipo_banner = "";

// Si es una solicitud GET, cargamos los datos para el formulario
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para obtener los datos del artista
    $query = "SELECT nombre, nombre_artistico, edad, nacionalidad, genero, avatar, descripcion, tipo_avatar, banner, tipo_banner FROM artistas WHERE idartista = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($nombre, $nombre_artistico, $edad, $nacionalidad, $genero, $avatar, $descripcion, $tipo_avatar, $banner, $tipo_banner);

        if ($stmt->fetch()) {
            // Devolvemos los datos como un JSON para cargarlos en el formulario
            echo json_encode([
                "success" => true,
                "data" => [
                    "nombre" => $nombre,
                    "nombre_artistico" => $nombre_artistico,
                    "edad" => $edad,
                    "nacionalidad" => $nacionalidad,
                    "genero" => $genero,
                    "avatar" => $avatar,
                    "descripcion" => $descripcion,
                    "banner" => $banner,
                    "tipo_banner" => $tipo_banner
                ]
            ]);
        } else {
            // Si no encuentra el artista, devuelve un error
            echo json_encode(["success" => false, "message" => "No se encontró ningún artista con ese ID."]);
        }

        $stmt->close();
    } else {
        // Error en la consulta
        echo json_encode(["success" => false, "message" => "Error en la consulta a la base de datos."]);
    }
     // Aseguramos que el script no continúe más allá
}

// Verificamos si es una solicitud POST para actualizar datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Leer los datos JSON enviados
        $data = json_decode(file_get_contents("php://input"), true);

        // Validamos que se haya recibido el JSON correctamente
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["success" => false, "message" => "Error al decodificar JSON"]);
            return;
        }

        if ($data) {
            // Asignar los valores de los datos JSON
            $nombre = $data['nombre'];
            $nombre_artistico = $data['nombre_artistico'];
            $edad = $data['edad'];
            $nacionalidad = $data['nacionalidad'];
            $genero = $data['genero'];
            $descripcion = $data['descripcion'];
            $avatar = $data['avatar']; // La imagen base64 sin el tipo MIME
            $tipo_avatar = $data['tipo_avatar']; // El tipo MIME (ej: image/jpeg)
            $banner = $data['banner'];
            $tipo_banner = $data['tipo_banner'];
            $id = $_GET['id']; // Obtener el ID de la URL

            // Validar que los campos obligatorios no estén vacíos
            if (empty($nombre) || empty($nombre_artistico)) {
                echo json_encode(["success" => false, "message" => "Los campos Nombre y Nombre Artístico son obligatorios."]);
                return;
            }

            // Preparar la consulta para actualizar los datos
            
            $query = "UPDATE artistas SET nombre = ?, nombre_artistico = ?, edad = ?, nacionalidad = ?, genero = ?, descripcion = ?, 
            avatar = IFNULL(?, avatar), tipo_avatar = IFNULL(?, tipo_avatar), 
            banner = IFNULL(?, banner), tipo_banner = IFNULL(?, tipo_banner) 
            WHERE idartista = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssisssssssi", $nombre, $nombre_artistico, $edad, $nacionalidad, $genero, $descripcion, 
            $avatar, $tipo_avatar, $banner, $tipo_banner, $id);
            

            // Ejecutar la consulta
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


   // Terminamos la ejecución aquí si es POST
}

// Cerramos la conexión a la base de datos
$conn->close();
?>