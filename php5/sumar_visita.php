<?php
require 'basedatos.php';

$data = json_decode(file_get_contents('php://input'), true);
$id_oyente = $data['id_oyente'];
$id_artista = $data['id_artista'];
$diaSemana = date('D'); // Obtiene el día de la semana actual
$diasSemana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb','Dom'];
$diaSemana = $diasSemana[date('w')]; // 'w' devuelve el índice numérico del día (0=Domingo, 6=Sábado)

// Verificar si ya existe un registro de visita para el día de hoy
$consulta = "SELECT id_visita FROM visitas_perfil WHERE id_artista = ? AND fecha = CURDATE()";
$stmt = $conn->prepare($consulta);
$stmt->bind_param("i", $id_artista);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    // Si existe, incrementar el conteo de visitas
    $consultaUpdate = "UPDATE visitas_perfil SET visitas = visitas + 1 WHERE id_artista = ? AND fecha = CURDATE()";
    $stmtUpdate = $conn->prepare($consultaUpdate);
    $stmtUpdate->bind_param("i", $id_artista);
    $success = $stmtUpdate->execute();
} else {
    // Si no existe, crear un nuevo registro con visitas = 1
    $consultaInsert = "INSERT INTO visitas_perfil (id_artista, fecha, dia_semana, visitas) VALUES (?, CURDATE(), ?, 1)";
    $stmtInsert = $conn->prepare($consultaInsert);
    $stmtInsert->bind_param("is", $id_artista, $diaSemana);
    $success = $stmtInsert->execute();
}

echo json_encode(['success' => $success]);

?>
