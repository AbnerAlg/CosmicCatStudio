<?php
require 'basedatos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $colaboradores = $_POST['colaboradores'];
    $letra = $_POST['letra'];
    $fotoBase64 = $_POST['foto'];
    $tipoFoto = $_POST['tipo_foto'];
    $id_artista = intval($_POST['id_artista']);
    
    // Decodificar archivo de música base64
    $archivoMusicaBase64 = $_POST['archivo-musica'];
    $archivoMusica = $archivoMusicaBase64;
    $tipoMusica = $_POST['tipo_musica'];

    $sql = "INSERT INTO musica (archivo, titulo, genero, colaboradores, letra, foto, tipo_foto, id_artista, tipo_audio) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssis", $archivoMusica, $titulo, $genero, $colaboradores, $letra, $fotoBase64, $tipoFoto, $id_artista, $tipoMusica);

    if ($stmt->execute()) {
        echo 'Música subida exitosamente.';
    } else {
        echo 'Error al subir la música: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Método de solicitud no permitido.';
}
?>
