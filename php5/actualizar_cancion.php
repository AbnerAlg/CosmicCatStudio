<?php
require 'basedatos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_musica = intval($_POST['id_musica']);
    $titulo = $_POST['titulo-cancion'];
    $genero = $_POST['genero'];
    $colaboradores = $_POST['colaboradores'];
    $letra = $_POST['letra'];

    // Procesar la foto si se seleccionó una nueva
    if (!empty($_POST['foto'])) { // Verificar si 'foto' base64 está presente
        $foto = $_POST['foto']; // Base64 directamente de formData
        $tipo_foto = $_POST['tipo_foto'];

        $sql = "UPDATE musica SET titulo = ?, genero = ?, colaboradores = ?, letra = ?, foto = ?, tipo_foto = ? WHERE id_musica = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $titulo, $genero, $colaboradores, $letra, $foto, $tipo_foto, $id_musica);
    } else {
        $sql = "UPDATE musica SET titulo = ?, genero = ?, colaboradores = ?, letra = ? WHERE id_musica = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $titulo, $genero, $colaboradores, $letra, $id_musica);
    }

    if ($stmt->execute()) {
        echo 'Datos de la canción actualizados exitosamente.';
    } else {
        echo 'Error al actualizar la canción: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Método de solicitud no permitido.';
}
?>
