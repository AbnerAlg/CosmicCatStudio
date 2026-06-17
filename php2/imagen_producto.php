<?php
// Mostrar errores de PHP para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_producto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Depuración: Log del ID del producto que se está intentando obtener
error_log("ID del producto solicitado: " . $id_producto);

if ($id_producto <= 0) {
    die("ID de producto no válido.");
}

// Consulta para obtener la imagen y el tipo MIME
$sql = "SELECT imagen_producto, tipo_imagen FROM producto WHERE id_producto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // Depuración: Log si no se encuentra el producto
    error_log("Producto con ID " . $id_producto . " no encontrado.");
    die("Producto no encontrado.");
}

$stmt->bind_result($imagen_producto, $tipo_imagen);
$stmt->fetch();

// Verificar si se ha obtenido una imagen y su tipo MIME
if (!empty($imagen_producto) && !empty($tipo_imagen)) {
    header("Content-Type: $tipo_imagen");
    echo $imagen_producto;
} else {
    // Si no hay imagen, muestra una imagen predeterminada
    $rutaImagenPredeterminada = "../img/default.jpg";
    if (file_exists($rutaImagenPredeterminada)) {
        header("Content-Type: image/jpeg");
        readfile($rutaImagenPredeterminada);
    } else {
        // Si no existe la imagen predeterminada, muestra un error
        header("Content-Type: text/plain");
        echo "Imagen no disponible.";
    }
}

$stmt->close();
$conn->close();
?>
