<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Personalización del fondo de la página con el color #203142 */
        body {
            background-color: #203142;  /* Fondo verde oscuro */
        }

        /* Bordes de los campos de texto con el color success (verde) */
        .form-control {
            border-color: #0e1c11; /* Color success de Bootstrap */
        }

        /* Color de fondo para el botón con la clase btn-dark */
        .btn-dark {
            background-color: #203142;  /* Color dark */
            border-color: #375675;      /* Borde oscuro */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Bienvenido, <?php echo $_SESSION["usuario"]; ?>!</h3>
                    </div>
                    <div class="card-body text-center">
                        <p class="card-text">Has iniciado sesión correctamente. Disfruta de tu estancia en nuestro sitio web.</p>
                        <a href="logout.php" class="btn btn-dark">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.amazonaws.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
