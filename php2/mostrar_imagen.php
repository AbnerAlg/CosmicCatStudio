<?php
// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del producto desde la URL
$id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Preparar la consulta SQL para obtener la imagen y su tipo
$sql = "SELECT imagen_producto, tipo_imagen FROM producto WHERE id_producto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$stmt->bind_result($imagen_base64, $tipo_imagen);
$stmt->fetch();
$stmt->close();

// Comprobar si se obtuvo una imagen
if ($imagen_base64) {
    // Decodificar la imagen
    $imagen = base64_decode($imagen_base64);
    
    // Enviar el encabezado de tipo de contenido adecuado
    header("Content-Type: " . $tipo_imagen); // Esto será image/png o image/jpeg
    echo $imagen; // Salida de los datos binarios
} else {
    echo "Imagen no encontrada.";
}

// Cerrar la conexión
$conn->close();
?>
