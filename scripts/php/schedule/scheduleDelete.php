<?php
    include("../seguridad/conexion.php");

    $query_delete = "DELETE FROM turnos_publicados WHERE id_turnoP = " . "'". $_REQUEST["id_turnoP"] . "'";
    
    print($query_delete);

    $stm = $conexion->prepare($query_delete);
    $stm->execute();
    $stm->close();
    print("<h3>[-] Departamento eliminado correctamente</h3>\n<a href='../../../sites/horarios.php'>Volver atrás</a>")
?>