<?php
session_start();

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
if (!isset($_SESSION["autentificado"]) || $_SESSION["autentificado"] != "SI") {
    $error_message = "Credenciales no válidas";
    header("Location: ../../../index.php?error=".urlencode($error_message));
    exit();
} else {
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("d-m-Y H:i:s");
    $tiempoTranscurrido = (strtotime($ahora) - strtotime($fechaGuardada));

    if($tiempoTranscurrido >= 900){
        session_destroy();
        $error_message = "Pérdida de conexión por inactividad";
        header("Location: ../../../index.php?error=".urlencode($error_message));
    } else {
        $_SESSION["ultimoAcceso"] = date("d-m-Y H:i:s");
    }
}
?>