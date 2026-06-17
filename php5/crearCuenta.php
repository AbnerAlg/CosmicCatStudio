<?php

include 'basedatos.php';

try {

    // Leer el cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si los datos fueron enviados correctamente
    if ($data) {
        $correo = $data['correo'];
        $nombre = $data['nombre'];
        $edad = $data['edad'];
        $contrasena = $data['contrasena'];
        $confirmar_contrasena = $data['confirmar_contrasena'];

        // Verificar si las contraseñas coinciden
        if ($contrasena !== $confirmar_contrasena) {
            echo json_encode(['error' => true, 'message' => 'Las contraseñas no coinciden.']);
            exit;
        }

        // Encriptar la contraseña antes de guardarla (opcional pero recomendable)
        $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

        // Rutas de las imágenes predeterminadas
        $ruta_avatar_default = '../img/sin-foto.jpg';
        $ruta_banner_default = '../img/sin-banner.jpg';

        // Leer y codificar las imágenes predeterminadas en Base64
        $avatar = file_get_contents($ruta_avatar_default);
        $avatar_base64 = base64_encode($avatar);
        $banner = file_get_contents($ruta_banner_default);
        $banner_base64 = base64_encode($banner);

        // Obtener los tipos MIME de las imágenes predeterminadas
        $tipo_avatar = mime_content_type($ruta_avatar_default);
        $tipo_banner = mime_content_type($ruta_banner_default);

        // Preparar la consulta SQL para insertar los datos, incluyendo el avatar y el banner codificados
        $sql = "INSERT INTO oyente (correo, nombre, edad, contrasena, avatar, avatar_tipo, banner, banner_tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros a la consulta
        $stmt->bind_param("ssisssss", $correo, $nombre, $edad, $contrasena_hash, $avatar_base64, $tipo_avatar, $banner_base64, $tipo_banner);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            echo json_encode(['error' => false, 'message' => 'Cuenta de oyente creada exitosamente.']);
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