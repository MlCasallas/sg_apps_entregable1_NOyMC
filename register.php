<?php
function limpiarEntrada($data) {
    $data = trim($data);  // Eliminar espacios en blanco
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');  // Escapar caracteres especiales
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = limpiarEntrada($_POST['nombre']);
    $email = limpiarEntrada($_POST['email']);
    $password = limpiarEntrada($_POST['password']);
    
    // Generar un salt único y cifrar la contraseña con SHA256
    $salt = bin2hex(random_bytes(16));
    $passwordHashed = hash('sha256', $password . $salt);
    
    // Conexión a la base de datos
    try {
        $conn = new mysqli('localhost', 'root', '', 'registro_usuarios');
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        
        $sql = "INSERT INTO usuarios (nombre, email, contraseña, salt) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $email, $passwordHashed, $salt);

        if ($stmt->execute()) {
            echo "Registro exitoso.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>