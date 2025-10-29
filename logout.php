<?php
// Iniciar sesión si no existe
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Eliminar todas las variables de sesión
$_SESSION = array();

// Destruir la sesión actual
session_destroy();

// Redirigir al login con mensaje
header("Location: index.php?logout=1");
exit();
?>