<?php
require 'basedatos.php';

$id_oyente = $_GET['id'];
$sql = "SELECT NombreCompleto, Direccion, Ciudad, Estado, CodigoP, Telefono FROM direcciones WHERE id_oyente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_oyente);
$stmt->execute();
$result = $stmt->get_result();

$direcciones = [];
while ($row = $result->fetch_assoc()) {
    $direcciones[] = $row;
}

echo json_encode($direcciones);
$stmt->close();
$conn->close();
?>
