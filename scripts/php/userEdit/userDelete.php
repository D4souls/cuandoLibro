<?php
    include("../seguridad/conexion.php");

    $query_delete = "DELETE FROM empleados WHERE dni = " . "'". $_REQUEST["dni"] . "'";
    
    print($query_delete);

    $stm = $conexion->prepare($query_delete);
    $stm->execute();
    $stm->close();
    print("<h3>[-] Usuario eliminado correctamente</h3>\n<a href='../../../trabajadores.php'>Volver atrás</a>")
?>