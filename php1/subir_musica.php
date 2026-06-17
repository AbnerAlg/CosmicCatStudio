<?php
// Habilitar el reporte de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$host = 'localhost'; 
$usuario = 'root'; 
$contraseña = ''; 
$nombre_bd = 'cosmiccatstudio'; 

// Crear conexión
$conn = new mysqli($host, $usuario, $contraseña, $nombre_bd);
$conn->set_charset("utf8");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar que se haya enviado el formulario para guardar música
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los archivos del formulario
    if (isset($_FILES['archivo-musica']) && $_FILES['archivo-musica']['error'] === UPLOAD_ERR_OK) {
        $archivoMusica = file_get_contents($_FILES['archivo-musica']['tmp_name']);
    // echo $archivoMusica;
    } else {
        die("Error al subir el archivo de música: " . $_FILES['archivo-musica']['error']);
    }

    if (isset($_FILES['foto-representativa']) && $_FILES['foto-representativa']['error'] === UPLOAD_ERR_OK) {
        $fotoRepresentativa = file_get_contents($_FILES['foto-representativa']['tmp_name']);
    } else {
        die("Error al subir la foto representativa: " . $_FILES['foto-representativa']['error']);
    }

    // Recoger otros datos del formulario
    $tituloCancion = $_POST['titulo-cancion'];
    $genero = $_POST['genero'];
    $colaboradores = $_POST['colaboradores'];
    $letra = $_POST['letra'];
    $fechaActual = date('Y-m-d');

    // Preparar y ejecutar la consulta SQL para guardar en la base de datos
    $sql = "INSERT INTO musica (titulo, genero, colaboradores, letra, foto, fecha, archivo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Comprobar si la preparación de la consulta fue exitosa
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Cambiar bind_param para ajustarse a los tipos de datos
    // Vinculamos todos los campos necesarios incluyendo la fecha
    $stmt->bind_param("sssssbs", $tituloCancion, $genero, $colaboradores, $letra, $fotoRepresentativa, $fechaActual, $archivoMusica);
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Nueva canción añadida exitosamente.";
    } else {
        echo "Error al añadir la canción: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>


