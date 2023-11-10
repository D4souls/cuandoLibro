<?php
    include("../seguridad/conexion.php");

    $query_delete = "DELETE FROM departamentos WHERE id_departamento = " . "'". $_REQUEST["id_departamento"] . "'";
    
    print($query_delete);

    $stm = $conexion->prepare($query_delete);
    $stm->execute();
    $stm->close();
    print("<h3>[-] Departamento eliminado correctamente</h3>\n<a href='../../../sites/departamentos.php#department'>Volver atrás</a>")
?>