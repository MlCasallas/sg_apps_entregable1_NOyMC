<?php
// Mostrar errores para depurar
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Función para limpiar y sanitizar entradas
    function limpiarEntrada($data) {
        $data = trim($data);  // Eliminar espacios en blanco
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');  // Escapar caracteres especiales
        return $data;
    }

    // Obtener los valores del formulario
    $emailIngresado = limpiarEntrada($_POST['email']);
    $passwordIngresada = limpiarEntrada($_POST['password']);
    
    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'registro_usuarios');
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Preparar la consulta SQL para evitar SQL Injection
    $sql = "SELECT nombre, email, contraseña, salt FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Enlazar el parámetro (email)
    $stmt->bind_param("s", $emailIngresado);
    $stmt->execute();
    $stmt->bind_result($nombreBd, $emailBd, $contraseñaCifrada, $salt);

    // Verificar si se encuentra el usuario
    if ($stmt->fetch()) {
        // Concatenar la contraseña ingresada con el salt y cifrarla
        $contraseñaConSalt = hash('sha256', $passwordIngresada . $salt);

        // Comparar la contraseña cifrada del formulario con la almacenada en la base de datos
        if ($contraseñaConSalt === $contraseñaCifrada) {
            // Iniciar sesión
            $_SESSION["usuario"] = $nombreBd;
            // Redirigir a la página de bienvenida
            header("Location: bienvenido.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    // Si se accede al archivo sin usar el método POST, redirigir al formulario de login
    header("Location: login.html");
    exit();
}
?>
