<?php
session_start();
include 'conexion.php';

$error_message = '';

// Redirección si ya está logueado
if (isset($_SESSION['user_type'])) {
    switch ($_SESSION['user_type']) {
        case 'administrador':
            header('Location: admin.php');
            exit;
        case 'empleado':
            header('Location: empleado.php');
            exit;
        case 'cliente':
            header('Location: interfaz.php');
            exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validación básica
    if (empty($email) || empty($password)) {
        $error_message = 'Por favor, complete todos los campos.';
    } else {
        // Buscar usuario en todas las tablas
        $user = null;
        $user_type = '';

        // 1. Buscar en administradores
        $sql = "SELECT administradorID as id, nombre, apellidos, correo, contra FROM administrador WHERE correo = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($fila = mysqli_fetch_assoc($resultado)) {
            $user = $fila;
            $user_type = 'administrador';
        }
        mysqli_stmt_close($stmt);

        // 2. Buscar en empleados si no se encontró admin
        if (!$user) {
            $sql = "SELECT empleadoID as id, nombre, correo, contra, especialidad FROM empleado WHERE correo = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            
            if ($fila = mysqli_fetch_assoc($resultado)) {
                $user = $fila;
                $user_type = 'empleado';
            }
            mysqli_stmt_close($stmt);
        }

        // 3. Buscar en clientes si no se encontró en las anteriores
        if (!$user) {
            $sql = "SELECT clienteID as id, nombre, correo, contra FROM cliente WHERE correo = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            
            if ($fila = mysqli_fetch_assoc($resultado)) {
                $user = $fila;
                $user_type = 'cliente';
            }
            mysqli_stmt_close($stmt);
        }

        // Verificar usuario y contraseña
        if ($user) {
            $login_success = false;
            
            // Verificar contraseña según el tipo de usuario
            if ($user_type === 'cliente') {
                // Para clientes, usar password_verify (contraseñas encriptadas)
                if (password_verify($password, $user['contra'])) {
                    $login_success = true;
                } if ($password === $user['contra'] || password_verify($password, $user['contra'])) {
                    $login_success = true;
                }
            } else {
                // Para administradores y empleados, comparación directa (sin encriptar)
                // Y también verificar con password_verify por si ya están encriptadas
                if ($password === $user['contra'] || password_verify($password, $user['contra'])) {
                    $login_success = true;
                }
            }

            if ($login_success) {
                // Configurar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['correo'];
                $_SESSION['user_firstname'] = $user['nombre'];
                $_SESSION['user_lastname'] = $user['apellidos'] ?? '';
                $_SESSION['user_type'] = $user_type;
                $_SESSION['isAdmin'] = ($user_type === 'administrador');

                if ($user_type === 'empleado') {
                    $_SESSION['especialidad'] = $user['especialidad'];
                }

                // Redirección según tipo de usuario
                switch ($user_type) {
                    case 'administrador':
                        header('Location: admin.php');
                        break;
                    case 'empleado':
                        header('Location: empleado.php');
                        break;
                    case 'cliente':
                        header('Location: interfaz.php');
                        break;
                }
                exit;
            } else {
                $error_message = 'Contraseña incorrecta.';
            }
        } else {
            $error_message = 'Correo no encontrado. <a href="registro.php" style="color: #007bff;">¿Quieres registrarte?</a>';
        }
    }
    mysqli_close($conn);
}
?>

<?php include 'header.php'; ?>

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
    <!-- Custom Styles for Header --> <head>
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
        background-color: #C2185B;;
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
    }
    .error {
        color: #dc3545;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
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
</style> </head>

<div class="login-container">
    <h2>Iniciar Sesión</h2>
    <form action="login.php" method="POST" id="loginForm">
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required 
                   pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                   title="Por favor ingrese un correo electrónico válido">
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required 
                   minlength="6"
                   title="La contraseña debe tener al menos 6 caracteres">
        </div>
        <div class="form-group">
            <input type="submit" value="Acceder">
        </div>
    </form>

    <div class="register-link">
        <p>¿Eres cliente nuevo? <a href="registro.php">Regístrate aquí</a></p>
    </div>

    <?php if (!empty($error_message)): ?>
        <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>
</div>

<!-- JavaScript para validación frontend -->
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let isValid = true;

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

    if (!isValid) {
        e.preventDefault();
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

<!-- Scripts -->
<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="interactivo.js"></script>
</body>
</html> 