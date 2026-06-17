<?php
require 'basedatos.php';

$id_artista = isset($_GET['id']) ? intval($_GET['id']) : 0;
$response = [
    'visitas' => [0, 0, 0, 0, 0, 0, 0],
    'canciones' => [
        'titulos' => ['Sin datos'],
        'reproducciones' => [0]
    ]
];

// Obtener visitas semanales (últimos 7 días)
$consultaVisitas = "
    SELECT dia_semana, SUM(visitas) as total_visitas
    FROM visitas_perfil
    WHERE id_artista = ?
      AND fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY dia_semana
";
$stmt = $conn->prepare($consultaVisitas);
$stmt->bind_param("i", $id_artista);
$stmt->execute();
$resultadoVisitas = $stmt->get_result();

$diasSemana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
while ($fila = $resultadoVisitas->fetch_assoc()) {
    $diaIndex = array_search($fila['dia_semana'], $diasSemana);
    if ($diaIndex !== false) {
        $response['visitas'][$diaIndex] = intval($fila['total_visitas']);
    }
}

// Obtener las 4 canciones más reproducidas
$consultaCanciones = "
    SELECT titulo, reproducciones
    FROM musica
    WHERE id_artista = ?
    ORDER BY reproducciones DESC
    LIMIT 4
";
$stmt = $conn->prepare($consultaCanciones);
$stmt->bind_param("i", $id_artista);
$stmt->execute();
$resultadoCanciones = $stmt->get_result();

$titulos = [];
$reproducciones = [];
while ($fila = $resultadoCanciones->fetch_assoc()) {
    $titulos[] = $fila['titulo'];
    $reproducciones[] = intval($fila['reproducciones']);
}

if (count($titulos) > 0) {
    $response['canciones'] = [
        'titulos' => $titulos,
        'reproducciones' => $reproducciones
    ];
}

echo json_encode($response);
?>
