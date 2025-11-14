<?php
session_start();
// Redireccionar si ya está logueado
if (isset($_SESSION['user_id'])) {
    header('Location: interfaz.php');
    exit;
}

include 'conexion.php';
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validaciones
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($password)) {
        $error_message = 'Todos los campos son obligatorios.';
    } elseif ($password !== $confirm_password) {
        $error_message = 'Las contraseñas no coinciden.';
    } elseif (strlen($password) < 6) {
        $error_message = 'La contraseña debe tener al menos 6 caracteres.';
    } else {
        // Verificar si el email ya existe
        $check_sql = "SELECT clienteID FROM cliente WHERE correo = ?";
        $stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error_message = 'Este correo ya está registrado. <a href="login.php" style="color: #007bff; font-weight: bold;">¿Ya tienes cuenta? Inicia sesión aquí</a>';
        } else {
            // Insertar nuevo cliente con nombre y apellidos separados
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_sql = "INSERT INTO cliente (nombre, apellidos, correo, contra) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($stmt, "ssss", $nombre, $apellidos, $email, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
                $success_message = 'Registro exitoso. Ahora puedes iniciar sesión.';
                // Limpiar formulario
                $nombre = $apellidos = $email = '';
            } else {
                $error_message = 'Error al registrar. Intenta nuevamente.';
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Modeline</title>
    <style>
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin: 50px auto;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }
        .form-group input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #C2185B;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            font-size: 14px;
        }
        .error {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
        .error a {
            color: #007bff;
            font-weight: bold;
            text-decoration: none;
        }
        .error a:hover {
            text-decoration: underline;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .register-link {
            margin-top: 20px;
            text-align: center;
        }
        .register-link a {
            color: #C2185B;
            text-decoration: none;

        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .name-container {
            display: flex;
            gap: 10px;
        }
        .name-container .form-group {
            flex: 1;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="login-container">
        <h2>Registro de Cliente</h2>
        <form action="registro.php" method="POST" id="registerForm">
            <div class="name-container">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required 
                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,30}"
                           title="Solo letras y espacios (2-30 caracteres)"
                           value="<?php echo htmlspecialchars($nombre ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" required 
                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}"
                           title="Solo letras y espacios (2-50 caracteres)"
                           value="<?php echo htmlspecialchars($apellidos ?? ''); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required
                       value="<?php echo htmlspecialchars($email ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required 
                       minlength="6"
                       title="La contraseña debe tener al menos 6 caracteres">
                <div class="password-requirements">Mínimo 6 caracteres</div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Registrarse">
            </div>
        </form>
        
        <div class="register-link">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
    </div>

    <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        let nombre = document.getElementById('nombre').value;
        let apellidos = document.getElementById('apellidos').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirm_password').value;
        let isValid = true;

        // Validación de nombre
        const nombrePattern = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,30}$/;
        if (!nombrePattern.test(nombre)) {
            alert('El nombre solo puede contener letras y espacios (2-30 caracteres).');
            isValid = false;
        }

        // Validación de apellidos
        const apellidosPattern = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}$/;
        if (!apellidosPattern.test(apellidos)) {
            alert('Los apellidos solo pueden contener letras y espacios (2-50 caracteres).');
            isValid = false;
        }

        // Validación de email
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            alert('Por favor ingrese un correo electrónico válido.');
            isValid = false;
        }

        // Validación de contraseña
        if (password.length < 6) {
            alert('La contraseña debe tener al menos 6 caracteres.');
            isValid = false;
        }

        // Validación de confirmación de contraseña
        if (password !== confirmPassword) {
            alert('Las contraseñas no coinciden.');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Validación en tiempo real para la confirmación de contraseña
    document.getElementById('confirm_password').addEventListener('input', function() {
        let password = document.getElementById('password').value;
        let confirmPassword = this.value;
        
        if (confirmPassword !== '' && password !== confirmPassword) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '#ddd';
        }
    });

    // Validación en tiempo real para nombre y apellidos
    document.getElementById('nombre').addEventListener('input', function() {
        const pattern = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{0,30}$/;
        if (!pattern.test(this.value)) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '#ddd';
        }
    });

    document.getElementById('apellidos').addEventListener('input', function() {
        const pattern = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{0,50}$/;
        if (!pattern.test(this.value)) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '#ddd';
        }
    });
    </script>

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

    <!-- Contact JavaScript File -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <!-- Template JavaScript -->
    <script src="interactivo.js"></script>
</body>
</html>