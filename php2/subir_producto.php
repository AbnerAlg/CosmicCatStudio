<?php
// Configuración de la base de datos
$host = 'localhost'; 
$usuario = 'root'; 
$contraseña = ''; 
$nombre_bd = 'cosmiccatstudio'; 

$conn = new mysqli($host, $usuario, $contraseña, $nombre_bd);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtener los datos JSON del cuerpo de la solicitud
        $data = json_decode(file_get_contents("php://input"), true);

        $id_artista = $data['id_artista'];
        $nombre = $data['nombre'];
        $descripcion = $data['descripcion'];
        $stock = $data['stock'];
        $precio = $data['precio'];
        $imagenProducto = $data['imagen']; // Usar directamente la imagen en base64 sin decodificar
        $tipoImagen = $data['tipo_imagen'];

        // Validación del tipo MIME
        if (!in_array($tipoImagen, ['image/jpeg', 'image/png', 'image/webp'])) {
            throw new Exception("Tipo de imagen no permitido. Solo se permiten JPEG, PNG y WEBP.");
        }

        // Insertar en la base de datos
        $sql = "INSERT INTO producto (id_artista, nombre, descripcion, stock, precio, imagen_producto, tipo_imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issidss", $id_artista, $nombre, $descripcion, $stock, $precio, $imagenProducto, $tipoImagen);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Producto subido exitosamente."]);
        } else {
            throw new Exception("Error al subir el producto: " . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

$conn->close();
