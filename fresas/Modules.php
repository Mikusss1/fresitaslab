<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fresitaslab</title>

  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
  <link href="stilos.css" rel="stylesheet" />

  <?php include 'header.php'; ?>
      <!-- Custom Styles for Header -->
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
            background-image: url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/fresitaslab%20%405.jpg-RmrKme5P0a0yJjnTwOHnCCllT9wqJv.jpeg');
        }
        
        .blog-card-2 {
            background-image: url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/fresitaslab%20%406.jpg-tShJUA8eHg5tCti0uVNdL6N6recgFk.jpeg');
        }
        
        .blog-card-3 {
            background-image: url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/fresitaslab%20%404.jpg-nB4xt6T4Q9genYLRtRZll8QLO3i7kO.jpeg');
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
            color: rgba(255,255,255,0.85);
        }
        
        .new-footer .footer-contact {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: rgba(255,255,255,0.85);
        }
        
        .new-footer .social-links a {
            font-size: 20px;
            margin: 0 10px;
            color: white;
            transition: opacity 0.3s;
        }
        
        .new-footer .social-links a:hover {
            opacity: 0.7;
            text-decoration: none;
        }

        /* Responsive tweaks */
        @media (max-width: 767.98px) {
            .hero-text h1 {
                font-size: 1.75rem;
            }
            .inscribete-section .section-title {
                font-size: 2rem;
                margin-bottom: 40px;
            }
        }

    .hero {
      background: linear-gradient(135deg, #E91E63 0%, #F06292 100%);
      color: white;
      padding: 80px 0;
    }
    .hero h1 {
      font-weight: 700;
      font-size: 2.5rem;
      max-width: 550px;
    }
    .hero-btn .btn {
      margin-right: 15px;
      padding: 12px 25px;
      font-weight: 600;
      border-radius: 5px;
      transition: all 0.3s ease;
    }
    .hero-btn .btn:hover {
      background: #c2185b;
      color: white;
      text-decoration: none;
      transform: translateY(-2px);
    }
    .hero-image img {
      max-width: 100%;
      height: auto;
      filter: drop-shadow(0 10px 30px rgba(0,0,0,0.2));
    }
    .card img {
      height: 220px;
      object-fit: cover;
    }

            .modules-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .module-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(233, 30, 99, 0.15);
        }

        
        .module-card .duration {
            background: #e91e63;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
        }

        .module-card ul {
            list-style: none;
            padding: 0;
        }

        .module-card ul li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            color: #666;
        }

        .module-card ul li:last-child {
            border-bottom: none;
        }

        .module-card ul li i {
            color: #e91e63;
            margin-right: 10px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .hero-banner {
    min-height: 600px;
    background: linear-gradient(135deg, #E91E63 0%, #EC407A 50%, #F06292 100%);
    padding: 40px 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}


  </style>
</head>
<body>


<!-- Hero Start -->
<div class="hero" style="padding: 60px 0; background: #F06292;">
  <div class="container">
    <div class="row align-items-center">
      <!-- Texto hero -->
      <div class="col-lg-6">
        <div class="hero-text">
          <h1>Tu pasión por la belleza, nuestra inspiración para enseñarte.</h1>
          <div class="hero-btn mt-4">
            <a class="btn btn-primary mr-3" href="inscripcion.html">Haz una cita</a>
          </div>
        </div>
      </div>
      <!-- Imagen hero -->
      <div class="col-lg-6 text-center">
        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo1-26ie49cxZrPhgPZxpq9oxs5J6yZdMN.png" alt="fresitaslab Instituto de Belleza" class="img-fluid" style="max-width: 80%;">
      </div>
    </div>
  </div>
</div>
<!-- Hero End -->


  <!-- MÓDULOS -->
    <!-- Modules Section Start -->
    <div class="modules-section">
        <div class="container">
            
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="module-card">
                        <h3>Estilismo y Corte de Cabello</h3>
                        <ul>
                            <li><i class="fas fa-check"></i>Técnicas básicas de corte</li>
                            <li><i class="fas fa-check"></i>Cortes modernos y clásicos</li>
                            <li><i class="fas fa-check"></i>Manejo de herramientas profesionales</li>
                            <li><i class="fas fa-check"></i>Anatomía del cabello</li>
                            <li><i class="fas fa-check"></i>Tendencias actuales</li>
                            <li><i class="fas fa-check"></i>Práctica con modelos reales</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="module-card">
                        <h3>Colorimetría Avanzada</h3>
                        <ul>
                            <li><i class="fas fa-check"></i>Teoría del color</li>
                            <li><i class="fas fa-check"></i>Técnicas de decoloración</li>
                            <li><i class="fas fa-check"></i>Mechas y reflejos</li>
                            <li><i class="fas fa-check"></i>Corrección de color</li>
                            <li><i class="fas fa-check"></i>Balayage y ombré</li>
                            <li><i class="fas fa-check"></i>Productos profesionales</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="module-card">
                        <h3>Barbería Moderna</h3>
                        <ul>
                            <li><i class="fas fa-check"></i>Cortes masculinos clásicos</li>
                            <li><i class="fas fa-check"></i>Fade y degradados</li>
                            <li><i class="fas fa-check"></i>Arreglo de barba</li>
                            <li><i class="fas fa-check"></i>Afeitado tradicional</li>
                            <li><i class="fas fa-check"></i>Diseño de patillas</li>
                            <li><i class="fas fa-check"></i>Atención al cliente masculino</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="module-card">
                        <h3>Maquillaje Profesional</h3>
                        <ul>
                            <li><i class="fas fa-check"></i>Maquillaje social</li>
                            <li><i class="fas fa-check"></i>Maquillaje de novia</li>
                            <li><i class="fas fa-check"></i>Maquillaje artístico</li>
                            <li><i class="fas fa-check"></i>Técnicas de contouring</li>
                            <li><i class="fas fa-check"></i>Maquillaje para fotografía</li>
                            <li><i class="fas fa-check"></i>Productos y herramientas</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="module-card">
                        <h3>Uñas y Diseño de Manicure</h3>
                        <ul>
                            <li><i class="fas fa-check"></i>Manicure tradicional</li>
                            <li><i class="fas fa-check"></i>Uñas acrílicas</li>
                            <li><i class="fas fa-check"></i>Uñas de gel</li>
                            <li><i class="fas fa-check"></i>Nail art y decoración</li>
                            <li><i class="fas fa-check"></i>Pedicure spa</li>
                            <li><i class="fas fa-check"></i>Cuidado de cutículas</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="module-card">
                        <h3>Curso Integral de Belleza</h3>
                        <ul>
                            <li><i class="fas fa-check"></i>Todos los módulos incluidos</li>
                            <li><i class="fas fa-check"></i>Certificación completa</li>
                            <li><i class="fas fa-check"></i>Prácticas profesionales</li>
                            <li><i class="fas fa-check"></i>Emprendimiento en belleza</li>
                            <li><i class="fas fa-check"></i>Marketing personal</li>
                            <li><i class="fas fa-check"></i>Bolsa de trabajo</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="inscripcion.html" class="btn btn-lg" style="background: #e91e63; color: white; padding: 15px 40px; border-radius: 25px; font-weight: 600; text-decoration: none;">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Haz una cita ahora
                </a>
            </div>
        </div>
    </div>
    <!-- Modules Section End -->

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

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

</body>
</html>
