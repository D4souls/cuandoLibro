<?php
session_start();

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
if (!isset($_SESSION["autentificado"]) || $_SESSION["autentificado"] != "SI") {
    //si no existe, envío a la página de autenticación
    $error_message = "Credenciales no válidas";
    header("Location: ../../../index.php?error=".urlencode($error_message));
    //además salgo de este script
    exit();
}
?>