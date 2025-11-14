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
    <title>Nosotros </title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="stilos.css" rel="stylesheet">
    <!-- Custom Styles for Header -->
   
</head>


<?php include 'header.php'; ?>

<!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <div class="hero-text">
                        <h1>Bienvenidos a Fresitaslab</h1>
                        <div class="hero-btn">
                            <a href="inscripcion.php" class="btn">Haz tu cita</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 hero-image">
                    <img src="pagina/logo1.png" alt="logo" />
                </div>
            </div>
        </div>
    </section>

<!-- About Start -->
<div class="about">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 col-md-10">
                <div class="section-header text-center">
                    <h2>Sobre nosotros</h2>
                </div>
                <div class="about-text text-center">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem.
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor, auctor id gravida condimentum, viverra quis sem. Curabitur non nisl nec nisi scelerisque maximus.
                    </p>
                    <a class="btn" href="services.html">Leer Más.</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->
<!-- Team Start -->
<div class="team">
    <div class="container">
        <div class="section-header text-center">
            <h2>Galería de Belleza</h2>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="team-item">
                    <div class="team-img">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%201.jpg-dAMUMHnozBhFQwokrd1i06pb7kvhsA.jpeg" alt="Maquillaje de Efectos Especiales">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-item">
                    <div class="team-img">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%202.jpg-rsFL8z99MySJwG1qGaUBtj6TCNLlvm.jpeg" alt="Maquillaje Profesional">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-item">
                    <div class="team-img">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%203.jpg-CVbtYCFATleV50nqjRLs43r0VdhW1G.jpeg" alt="Coloración de Cabello">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-item">
                    <div class="team-img">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%204.jpg-pqmOY3D3acHmLODLISUyPfHTuQ7fO6.jpeg" alt="Tratamientos Capilares">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Team End -->

     <!-- New Footer Start -->
    <div class="new-footer">
        <div class="container">
            <div class="footer-brand">Fresitaslab</div>
            
            <div class="footer-address">
                Boulevard Las Fuentes #1110, Reynosa, Mexico
            </div>
            
            <div class="footer-contact">
                <a href="tel:+528994468404">+52-899-446-8404</a> | <a href="mailto:soporte@fresitas.com">soporte@fresitas.com</a>
            </div>
            
            <div class="footer-social">
                <a href="https://" target="_blank" rel="noopener noreferrer"><i class="fab fa-tiktok"></i></a>
                <a href="https://" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                <a href="https://" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                <a href="https://wa.me/+528994468404" target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp"></i></a>
            </div>
            
            <div class="footer-bottom">
                <div class="footer-copyright">
                    © 2025 <strong>Fresitaslab</strong>. Todos los Derechos Reservados.
                </div>
                <div class="footer-designed">
                    Diseñado con <i class="fas fa-heart"></i> para la Belleza
                </div>
            </div>
        </div>
    </div>
    <!-- New Footer End -->

<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<!-- Contact Javascript File -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

<!-- Template Javascript -->
<script src="interactivo.js"></script>
</body>
</html>
