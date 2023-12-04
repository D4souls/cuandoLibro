<?php 


if (isset($_REQUEST["mail"]) && $_REQUEST["mail"] !== null) {
    $mail = $_REQUEST["mail"];

    
    
} else {
    throw new Exception("Mail no envíado: " . $conexion->error);
}

?>