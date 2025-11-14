<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'NO SET';

include 'header.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Fresitaslab</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet"> 
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="stilos.css">
    <link rel="stylesheet" href="interactivo.js">

<style>
    /* Top Bar with gradient */
.top-bar {
    background: linear-gradient(135deg, #8B1538 0%, #C2185B 100%);
    padding: 8px 0;
}

.top-bar .social a {
    color: white;
    margin: 0 8px;
    font-size: 16px;
    transition: opacity 0.3s;
}

.top-bar .social a:hover {
    opacity: 0.8;
}

/* Navigation Bar */
.navbar {
    background: linear-gradient(135deg, #C2185B 0%, #E91E63 100%) !important;
    padding: 15px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.navbar-brand {
    font-size: 28px;
    font-weight: 700;
    color: white !important;
    letter-spacing: 1px;
}

.navbar-nav .nav-link {
    color: white !important;
    font-weight: 500;
    margin: 0 15px;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 0.5px;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
    color: #FFE0E6 !important;
}

/* Hero Section */
.hero {
    background: linear-gradient(135deg, #E91E63 0%, #EC407A 50%, #F06292 100%);
    min-height: 500px;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.05);
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-text h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2C3E50;
    margin-bottom: 30px;
    line-height: 1.2;
}

/* Simple buttons exactly like the screenshot */
.hero-btn {
    margin-top: 20px;
}

.hero-btn .btn {
    background: white !important;
    color: #E91E63 !important;
    border: none;
    padding: 12px 25px;
    margin-right: 15px;
    border-radius: 5px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    transition: all 0.3s;
}

.hero-btn .btn:hover {
    background: #f8f9fa !important;
    color: #C2185B !important;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.hero-btn .btn:focus,
.hero-btn .btn:active {
    box-shadow: none !important;
    outline: none !important;
}

.hero-image {
    text-align: center;
}

.hero-image img {
    max-width: 100%;
    height: auto;
    filter: drop-shadow(0 10px 30px rgba(0,0,0,0.2));
}

/* About section image styling */
.about-img img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    border: 3px solid #E91E63;
}

/* Cards Section Styles */
.cards-section {
    background: #f8f9fa;
    padding: 60px 0;
}

.cards-section .section-header {
    margin-bottom: 50px;
}

.cards-section .section-header p {
    color: #E91E63;
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

.cards-section .section-header h2 {
    color: #666;
    font-size: 2.5rem;
    font-weight: 300;
    margin-bottom: 0;
}

.blog-card {
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 30px;
    height: 300px;
    position: relative;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    cursor: pointer;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 25px rgba(0,0,0,0.25);
}

.blog-card-1 {
    background-image: url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%20%405.jpg-RmrKme5P0a0yJjnTwOHnCCllT9wqJv.jpeg');
}

.blog-card-2 {
    background-image: url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%20%406.jpg-tShJUA8eHg5tCti0uVNdL6N6recgFk.jpeg');
}

.blog-card-3 {
    background-image: url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%20%404.jpg-nB4xt6T4Q9genYLRtRZll8QLO3i7kO.jpeg');
}

/* Inscribete Section Styles - FIXED HEIGHT ISSUE */
.inscribete-section {
    background: linear-gradient(135deg, #F06292 0%, #EC407A 100%);
    padding: 80px 0;
}

.inscribete-section .section-title {
    text-align: center;
    font-size: 3rem;
    font-weight: 800;
    color: white;
    margin-bottom: 60px;
    letter-spacing: 2px;
    text-transform: uppercase;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.inscribete-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    overflow: hidden;
    margin-bottom: 30px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    min-height: 450px;
    display: flex;
    flex-direction: column;
}

.inscribete-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.inscribete-card-header {
    padding: 25px;
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    color: #2C3E50;
    text-transform: uppercase;
    letter-spacing: 1px;
    flex-shrink: 0;
}

.inscribete-card-header.costo {
    background: #F8BBD9;
}

.inscribete-card-header.carrera {
    background: #8B1538;
    color: white;
}

.inscribete-card-header.horarios {
    background: #F8BBD9;
}

.inscribete-card-body {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

.inscribete-card-body.costo {
    text-align: center;
    justify-content: center;
}

.inscribete-card-body.costo p {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2C3E50;
    margin-bottom: 15px;
}

.inscribete-card-body.carrera {
    text-align: center;
    justify-content: center;
}

.inscribete-card-body.carrera h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2C3E50;
    line-height: 1.4;
}

.inscribete-card-body.horarios ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.inscribete-card-body.horarios li {
    font-size: 0.95rem;
    color: #2C3E50;
    margin-bottom: 10px;
    padding-left: 15px;
    position: relative;
    font-weight: 500;
    line-height: 1.3;
}

.inscribete-card-body.horarios li:before {
    content: "•";
    color: #E91E63;
    font-weight: bold;
    position: absolute;
    left: 0;
}

.inscribete-card-footer {
    padding: 0;
    flex-shrink: 0;
    margin-top: auto;
}

.inscribete-btn {
    background: #8B1538 !important;
    color: white !important;
    border: none;
    padding: 15px;
    width: 100%;
    font-size: 1.2rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s;
    text-decoration: none;
    display: block;
    text-align: center;
}

.inscribete-btn:hover {
    background: #A91E63 !important;
    color: white !important;
    text-decoration: none;
    transform: translateY(-2px);
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* New Footer Styles */
.new-footer {
    background: linear-gradient(135deg, #8B1538 0%, #C2185B 50%, #E91E63 100%);
    color: white;
    padding: 60px 0 30px 0;
    text-align: center;
}

.new-footer .footer-brand {
    font-size: 3rem;
    font-weight: 700;
    color: white;
    margin-bottom: 30px;
    letter-spacing: 2px;
}

.new-footer .footer-address {
    font-size: 1.1rem;
    margin-bottom: 15px;
    color: rgba(255,255,255,0.9);
}

.new-footer .footer-contact {
    font-size: 1.1rem;
    margin-bottom: 30px;
    color: rgba(255,255,255,0.9);
}

.new-footer .footer-contact a {
    color: white;
    text-decoration: none;
}

.new-footer .footer-contact a:hover {
    color: #FFE0E6;
    text-decoration: none;
}

.new-footer .footer-social {
    margin-bottom: 40px;
}

.new-footer .footer-social a {
    color: white;
    font-size: 1.5rem;
    margin: 0 15px;
    transition: all 0.3s;
}

.new-footer .footer-social a:hover {
    color: #FFE0E6;
    transform: translateY(-2px);
}

.new-footer .footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.2);
    padding-top: 30px;
    margin-top: 30px;
}

.new-footer .footer-copyright {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.8);
    margin-bottom: 10px;
}

.new-footer .footer-designed {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.8);
}

.new-footer .footer-designed i {
    color: #FFE0E6;
    margin: 0 5px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 2rem;
    }
    
    .hero {
        min-height: 400px;
        text-align: center;
    }
    
    .hero-btn {
        margin-top: 20px;
    }
    
    .hero-btn .btn {
        display: block;
        margin: 10px 0;
        width: 100%;
    }
    
    .cards-section .section-header h2 {
        font-size: 2rem;
    }
    
    .blog-card {
        height: 250px;
    }
    
    .inscribete-section .section-title {
        font-size: 2.5rem;
    }
    
    .inscribete-card {
        min-height: auto;
        margin-bottom: 20px;
    }
    
    .inscribete-card-body.horarios li {
        font-size: 0.9rem;
        margin-bottom: 8px;
    }
    
    .new-footer .footer-brand {
        font-size: 2.5rem;
    }
    
    .new-footer .footer-social a {
        margin: 0 10px;
        font-size: 1.3rem;
    }
}

@media (max-width: 576px) {
    .hero-text h1 {
        font-size: 1.75rem;
    }
    
    .inscribete-section .section-title {
        font-size: 2rem;
        margin-bottom: 40px;
    }
    
    .inscribete-card-header {
        font-size: 1.5rem;
        padding: 20px;
    }
    
    .new-footer .footer-brand {
        font-size: 2rem;
    }
}
</style>

</head>
<body>


    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <div class="hero-text">
                        <h1>Bienvenidos a Fresitaslab</h1>
                        <div class="hero-btn">
                            <a href="inscripcion.php" class="btn">Haz tu cita</a>
                            <a href="aboutus.php" class="btn">Saber más</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 hero-image">
                    <img src="pagina/logo1.png" alt="logo" />
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 about-img">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%20%406.jpg-tShJUA8eHg5tCti0uVNdL6N6recgFk.jpeg" alt="Modeline Instituto de Belleza" />
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-center">
                    <h2>Acerca de Fresitaslab</h2>
                    <p>Somos una estetica que busca potenciar tu belleza, ayudandote a consentirte y dejar de lado la rutina .</p>
                    <p>Nuestros clientes son testimonio de la profesionalidad que ofrecemos. Con técnicas innovadoras, instructores certificados y un ambiente seguro, te preparamos para destacar tu belleza con la confianza que necesitas para brillar..</p>
                    <a href="aboutus.php" class="btn btn-primary mt-3 align-self-start">Conoce más</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Cards Section -->
    <section class="cards-section">
        <div class="container">
            <div class="section-header text-center mb-5">
                <p>¿Por qué elegirnos?</p>
                <h2>Fresitaslab te ofrece:</h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="blog-card blog-card-1"></div>
                </div>
                <div class="col-md-4">
                    <div class="blog-card blog-card-2"></div>
                </div>
                <div class="col-md-4">
                    <div class="blog-card blog-card-3"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Inscribete Section -->
    <section class="inscribete-section" id="inscribete">
        <div class="container">
            <h2 class="section-title">CITAS</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="inscribete-card costo">
                        <div class="inscribete-card-header costo">Costo</div>
                        <div class="inscribete-card-body costo">
                            <p>Inscripción<br><strong>$700</strong></p>
                            <p>Semana en<br><strong>$300</strong></p>
                        </div>
                        <div class="inscribete-card-footer">
                            <a href="inscribete.html" class="inscribete-btn">Haz tu cita</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="inscribete-card carrera">
                        <div class="inscribete-card-header carrera">Especialidades</div>
                        <div class="inscribete-card-body carrera">
                            <h3>Carrera de Estilismo y bienestar personal</h3>
                        </div>
                        <div class="inscribete-card-footer">
                            <a href="inscribete.html" class="inscribete-btn">Haz tu cita</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="inscribete-card">
                        <div class="inscribete-card-header horarios">Horarios</div>
                        <div class="inscribete-card-body horarios">
                            <ul>
                                <li>Turno matutino, Lunes a miércoles de 9 a 12 hrs</li>
                                <li>Vespertino Lunes y martes de 16 a 19 hrs.</li>
                                <li>Viernes de 10 a 15 hrs.</li>
                                <li>Sábado de 9 a 14 hrs.</li>
                                <li>Domingo de 9 a 14 hrs.</li>
                            </ul>
                        </div>
                        <div class="inscribete-card-footer">
                            <a href="inscribete.html" class="inscribete-btn">Haz tu cita</a>
                        </div>
                    </div>
                </div>

    </section>

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

