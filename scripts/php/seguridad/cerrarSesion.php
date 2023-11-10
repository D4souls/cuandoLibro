<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["autentificado"]) || $_SESSION["autentificado"] != "SI") {
    // Si no está autenticado, redirige a la página de inicio
    header("Location: ../../../../index.php");
    exit();
}

// Destruye la sesión
session_destroy();

// Redirige a la página de inicio después de cerrar sesión
header("Location: ../../../../index.php");
exit();
?>
