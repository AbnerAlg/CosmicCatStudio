<?php

include 'basedatos.php';

function obtenerTipoMIME($base64) {
    $parts = explode(',', $base64);
    if (count($parts) > 1) {
        $data = $parts[0];
        $mimeType = preg_replace('/^data:(.*?);base64$/', '$1', $data);
        return $mimeType;
    }
    return null; // Si no se puede determinar el tipo MIME
}

try {
    // Leer el cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si los datos fueron enviados correctamente
    if ($data) {
        $correo = $data['correo'];
        $nombre = $data['nombre'];
        $edad = $data['edad'];
        $nom_art = $data['nom_art'];
        $nacionalidad = $data['nacionalidad'];
        $contrasena = $data['contrasena'];
        $confirmar_contrasena = $data['confirmar_contrasena'];

        // Verificar si las contraseñas coinciden
        if ($contrasena !== $confirmar_contrasena) {
            echo json_encode(['error' => true, 'message' => 'Las contraseñas no coinciden.']);
            exit;
        }

        // Encriptar la contraseña antes de guardarla (opcional pero recomendable)
        $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

        // Ruta de la imagen predeterminada
        $ruta_banner_default = '../img/sin-banner.jpg';
        $ruta_avatar_default = '../img/sin-foto.jpg';

        // Leer y codificar las imágenes predeterminadas
        $banner = file_get_contents($ruta_banner_default);
        $banner_base64 = base64_encode($banner);
        $avatar = file_get_contents($ruta_avatar_default);
        $avatar_base64 = base64_encode($avatar);

        // Obtener los tipos MIME según el formato de las imágenes
        //$tipo_banner = 'image/jpeg'; // Cambiar según el formato de tu imagen
        //$tipo_avatar = 'image/jpeg'; // Cambiar según el formato de tu imagen

        // O puedes usar el tipo MIME real si el archivo se conoce
         $tipo_banner = mime_content_type($ruta_banner_default);
         $tipo_avatar = mime_content_type($ruta_avatar_default);

        // Preparar la consulta SQL para insertar los datos, incluyendo el avatar y banner codificados
        $sql = "INSERT INTO artistas (correo, nombre, edad, contrasena, nombre_artistico, nacionalidad, avatar, tipo_avatar, banner, tipo_banner) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros a la consulta
        $stmt->bind_param("ssisssssss", $correo, $nombre, $edad, $contrasena_hash, $nom_art, $nacionalidad, $avatar_base64, $tipo_avatar, $banner_base64, $tipo_banner);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            // Obtener el ID del nuevo artista
            $id_artista = $stmt->insert_id;

            // Insertar el registro en la tabla 'estadisticas' con valores iniciales
            $sql_estadisticas = "INSERT INTO estadisticas (idartista, seguidores, seguidos, oyentes, lanzamientos) VALUES (?, 0, 0, 0, 0)";
            $stmt_estadisticas = $conn->prepare($sql_estadisticas);
            $stmt_estadisticas->bind_param("i", $id_artista);

            if ($stmt_estadisticas->execute()) {
                echo json_encode(['error' => false, 'message' => 'Cuenta de artista creada exitosamente con estadísticas iniciales.']);
            } else {
                echo json_encode(['error' => true, 'message' => 'Error al crear las estadísticas: ' . $stmt_estadisticas->error]);
            }

            $stmt_estadisticas->close();
        } else {
            echo json_encode(['error' => true, 'message' => 'Error: ' . $stmt->error]);
        }

        // Cerrar la conexión y la consulta preparada
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['error' => true, 'message' => 'Error: No se recibieron datos.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
    exit;
}
?>