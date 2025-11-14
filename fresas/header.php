<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fresitaslab</title>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="stilos.css" rel="stylesheet" />
</head>
<body>
    <div class="top-bar d-none d-md-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="top-bar-right">
                        <div class="social">
                            <a href="https://www.tiktok.com/@instituto.modeline" target="_blank" rel="noopener noreferrer"><i class="fab fa-tiktok"></i></a>
                            <a href="https://www.facebook.com/ModelineInstitutodeBelleza"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/modeline.instituto?igsh=cWdiMjY4cTByaWUz"><i class="fab fa-instagram"></i></a>
                            <a href="https://wa.me/+528999227812" target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Nav Bar Start -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a href="interfaz.php" class="navbar-brand">Fresitaslab</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav ml-auto">
                <a href="interfaz.php" class="nav-item nav-link">Inicio</a>
                <a href="aboutus.php" class="nav-item nav-link">Nosotros</a>
                <a href="servicios.php" class="nav-item nav-link">Servicios</a>
                <a href="citas.php" class="nav-item nav-link">Citas</a>
                <?php if (isset($_SESSION['email'])): ?>
                <a href="subir_documentos.php" class="nav-item nav-link">Panel de Usuario</a>
                <a href="logout.php" class="nav-item nav-link">Cerrar sesión</a>
                <?php else: ?>
                <a href="login.php" class="nav-item nav-link">Iniciar sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<!-- Nav Bar End -->