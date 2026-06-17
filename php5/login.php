<?php

include 'basedatos.php';

try {
    // Leer el cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si los datos fueron enviados correctamente
    if ($data) {
        $correo = $data['correo'];
        $password = $data['password'];

        // Preparar la consulta SQL para buscar en la tabla artistas
        $sql = "SELECT idartista, contrasena FROM artistas WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se encontró el correo en la tabla artistas
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['contrasena'];
            $idartista = $row['idartista'];

            // Verificar la contraseña
            if (password_verify($password, $hashedPassword)) {
                echo json_encode(['error' => false, 'message' => 'Login correcto.', 'tipo' => 'artista', 'idartista' => $idartista]);
            } else {
                echo json_encode(['error' => true, 'message' => 'Contraseña incorrecta.']);
            }
        } else {
            // Buscar en la tabla oyentes
            $sql = "SELECT id_oyente, contrasena FROM oyente WHERE correo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['contrasena'];
                $id_oyente = $row['id_oyente'];

                // Verificar la contraseña
                if (password_verify($password, $hashedPassword)) {
                    echo json_encode(['error' => false, 'message' => 'Login correcto.', 'tipo' => 'oyente', 'id_oyente' => $id_oyente]);
                } else {
                    echo json_encode(['error' => true, 'message' => 'Contraseña incorrecta.']);
                }
            } else {
                echo json_encode(['error' => true, 'message' => 'Email no registrado.']);
            }
        }

        // Cerrar la conexión y la consulta preparada
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['error' => true, 'message' => 'Error: No se recibieron datos.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
    exit;
}

?>