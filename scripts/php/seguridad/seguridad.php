<?php
session_start();

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
if (!isset($_SESSION["autentificado"]) || $_SESSION["autentificado"] != "SI") {
    //si no existe, envío a la página de autenticación
    header("Location: index.php");
    //además salgo de este script
    exit();
}
?>