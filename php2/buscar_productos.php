<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "cosmiccatstudio");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]);
    exit();
}

// Obtener el término de búsqueda desde la URL
$terminoBusqueda = isset($_GET['busqueda']) ? $conn->real_escape_string($_GET['busqueda']) : '';

if (!$terminoBusqueda) {
    echo json_encode(["success" => false, "message" => "Término de búsqueda no especificado"]);
    exit();
}

// Consulta para obtener el id del artista que coincide con el nombre_artistico
$sqlArtistas = "SELECT idartista, nombre_artistico FROM artistas WHERE nombre_artistico LIKE '%$terminoBusqueda%'";
$resultArtistas = $conn->query($sqlArtistas);

$artistas = [];
$idArtistaEncontrado = null;

// Procesar resultados de artistas
if ($resultArtistas && $resultArtistas->num_rows > 0) {
    while ($row = $resultArtistas->fetch_assoc()) {
        $idArtistaEncontrado = $row['idartista']; // Guardar el ID del artista encontrado
        $artistas[] = $row; // Agregar los datos del artista encontrado a la respuesta
    }
}

// Consulta para buscar productos por nombre o por id_artista si se encontró un artista
$sqlProductos = "SELECT DISTINCT p.id_producto, p.nombre AS nombre_producto, p.precio, p.stock, 
                        p.imagen_producto, p.tipo_imagen, a.nombre_artistico 
                 FROM producto p
                 JOIN artistas a ON p.id_artista = a.idartista
                 WHERE p.nombre LIKE '%$terminoBusqueda%'";

// Añadir condición para id_artista si se encontró uno
if ($idArtistaEncontrado) {
    $sqlProductos .= " OR p.id_artista = '$idArtistaEncontrado'";
}

$resultProductos = $conn->query($sqlProductos);
$productos = [];

// Procesar resultados de productos
if ($resultProductos && $resultProductos->num_rows > 0) {
    while ($row = $resultProductos->fetch_assoc()) {
        if (!empty($row['imagen_producto'])) {
            $row['imagen_producto'] = "data:" . $row['tipo_imagen'] . ";base64," . $row['imagen_producto'];
        } else {
            $row['imagen_producto'] = ""; // Si no hay imagen de producto, poner cadena vacía
        }
        $productos[] = $row;
    }
}

// Asegurarse de no enviar ningún otro contenido después del JSON
echo json_encode(["success" => true, "artistas" => $artistas, "productos" => $productos]);
$conn->close();
?>
