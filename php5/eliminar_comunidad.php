<?php
require 'basedatos.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$id_comunidad = $data['id_comunidad'];

// 1. Eliminar registros en `oyente_comunidad` con el `id_comunidad`
$queryOyenteComunidad = "DELETE FROM oyente_comunidad WHERE id_comunidad = ?";
$stmtOyenteComunidad = $conn->prepare($queryOyenteComunidad);
$stmtOyenteComunidad->bind_param("i", $id_comunidad);
$successOyenteComunidad = $stmtOyenteComunidad->execute();

// 2. Eliminar comentarios de publicaciones en la comunidad
$queryComentarios = "DELETE c FROM comentarios c JOIN publicacion p ON c.id_publicacion = p.id_publicacion WHERE p.id_comunidad = ?";
$stmtComentarios = $conn->prepare($queryComentarios);
$stmtComentarios->bind_param("i", $id_comunidad);
$successComentarios = $stmtComentarios->execute();

// 3. Eliminar publicaciones en la comunidad
$queryPublicaciones = "DELETE FROM publicacion WHERE id_comunidad = ?";
$stmtPublicaciones = $conn->prepare($queryPublicaciones);
$stmtPublicaciones->bind_param("i", $id_comunidad);
$successPublicaciones = $stmtPublicaciones->execute();

// 4. Eliminar la comunidad
$queryComunidad = "DELETE FROM comunidad WHERE id_comunidad = ?";
$stmtComunidad = $conn->prepare($queryComunidad);
$stmtComunidad->bind_param("i", $id_comunidad);
$successComunidad = $stmtComunidad->execute();

$success = $successOyenteComunidad && $successComentarios && $successPublicaciones && $successComunidad;

echo json_encode(['success' => $success]);

// Cerrar todas las conexiones
$stmtOyenteComunidad->close();
$stmtComentarios->close();
$stmtPublicaciones->close();
$stmtComunidad->close();
$conn->close();
?>
