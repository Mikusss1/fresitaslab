<?php
session_start();
include 'header.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="Salón de Belleza, Uñas, Cabello, Barbería, Maquillaje, Modeline" />
    <meta name="description" content="Modeline - Instituto de Belleza Profesional" />
    <title>SERVICIOS</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />

  
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

    <!-- Services Section Start -->
    <section id="servicios" class="services-section container py-5">
        <div class="section-title">
            <p>Nuestros Servicios</p>
            <h2>Belleza y Estilo Profesional</h2>
        </div>

        <!-- Video Showcase -->
        <div class="video-showcase mb-5" style="position: relative; max-width: 100%; overflow: hidden; border-radius: 12px;">
            <video autoplay muted loop playsinline style="width: 100%; height: auto; display: block;">
                <source src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/FDownloader.Net_AQOEtMRVpkZ3XHqRVk9GgGYMx6RzoanmELPTXyc6AxJgpU7j7rwG1LkpPuf6jPKKvOUcn30De_UGnqnKj0A4w68Z_720p_%28HD%29-svz7Eg0i7uoCpT5FnAAFgPkwz3tQBC.mp4"
                    type="video/mp4" />
            </video>
            <div class="video-overlay"
                style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.35); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.4rem; font-weight: 600; text-align: center; padding: 15px;">
                Tu pasión por la belleza,<br />
                nuestra inspiración<br />
                para enseñarte.
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%20PRACTICANTES%205.jpg-F6EGrPaFoB8qjmeGvhydk0at97pRda.jpeg"
                        alt="Diseño de Uñas Profesional" />
                    <div class="card-body">
                        <h4>Diseño de Uñas Profesional</h4>
                        <p>Nuestras estudiantes aprenden técnicas avanzadas de nail art con equipos profesionales y acabados de alta calidad.</p>
                        <a href="Modules.php" class="btn-custom">Ver Más</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%20PRACTICANTES%206.jpg-lAp1BOBbavr3Bu72BoDYis8N44m2Zf.jpeg"
                        alt="Tratamientos Faciales y Cejas" />
                    <div class="card-body">
                        <h4>Tratamientos Faciales y Cejas</h4>
                        <p>Formación especializada en diseño de cejas, tratamientos faciales y técnicas de embellecimiento profesional.</p>
                        <a href="Modules.php" class="btn-custom">Ver Más</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%20PRACTICANTES%203.jpg-o4SEbMMIeumxMYKShKgIyxNneIB53Q.jpeg"
                        alt="Colorimetría Capilar" />
                    <div class="card-body">
                        <h4>Colorimetría Capilar</h4>
                        <p>Técnicas avanzadas de coloración y tratamientos capilares con productos profesionales de última generación.</p>
                        <a href="Modules.php" class="btn-custom">Ver Más</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%20PRACTICANTES.jpg-FAn1AaumZBKaIf1iQ7Wz8fVovQmiLq.jpeg"
                        alt="Cortes y Estilismo" />
                    <div class="card-body">
                        <h4>Cortes y Estilismo</h4>
                        <p>Formación completa en técnicas de corte, peinado y estilismo con las tendencias más actuales del mercado.</p>
                        <a href="Modules.php" class="btn-custom">Ver Más</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%20GRADUADOS.jpg-CcnPJOkmRLXCuGaZVbUOJLc0paxE64.jpeg"
                        alt="Graduación Profesional" />
                    <div class="card-body">
                        <h4>Certificación Profesional</h4>
                        <p>Nuestros egresados reciben certificación oficial avalada por la SEP, preparándolos para el éxito profesional.</p>
                        <a href="aboutus.php" class="btn-custom">Ver Más</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MODELINE%20RECONOCIMIENTO.jpg-cxbjJLdO7HDg2Sf7BsBlEis9RmtuAt.jpeg"
                        alt="Reconocimientos y Logros" />
                    <div class="card-body">
                        <h4>Reconocimientos y Logros</h4>
                        <p>Celebramos los logros de nuestros estudiantes con reconocimientos que validan su dedicación y excelencia.</p>
                        <a href="aboutus.php" class="btn-custom">Ver Más</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

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
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    
    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Smooth scrolling for navigation links
        $(document).ready(function () {
            $('a[href^="#"]').on("click", function (e) {
                e.preventDefault();
                var target = this.hash;
                var $target = $(target);
                $("html, body").stop().animate(
                    {
                        scrollTop: $target.offset().top - 70,
                    },
                    900,
                    "swing"
                );
            });
        });

        // Back to top button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $(".back-to-top").fadeIn();
            } else {
                $(".back-to-top").fadeOut();
            }
        });

        $(".back-to-top").click(function () {
            $("html, body").animate({ scrollTop: 0 }, 800);
            return false;
        });
    </script>
</body>
</html>
