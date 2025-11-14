<?php
session_start(); // Inicia la sesión para poder acceder a las variables de sesión

// Destruye todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no solo los datos de sesión!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruye la sesión
session_destroy();

// Redirige al usuario a la página de inicio de sesión o a la página principal
header('Location: login.php'); // O puedes redirigir a 'index.html' o 'index.php'
exit(); // Asegúrate de que el script se detenga después de la redirección
?>