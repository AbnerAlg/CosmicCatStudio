<?php
require 'basedatos.php';

$id_oyente = $_POST['idOyente'];
$nombreCompleto = $_POST['nombre'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$estado = $_POST['estado'];
$codigoP = $_POST['codigo_postal'];
$telefono = $_POST['telefono'];

$sql = "INSERT INTO direcciones (id_oyente, NombreCompleto, Direccion, Ciudad, Estado, CodigoP, Telefono) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssss", $id_oyente, $nombreCompleto, $direccion, $ciudad, $estado, $codigoP, $telefono);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
?>
