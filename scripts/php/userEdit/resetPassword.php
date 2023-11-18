<?php
include("../seguridad/conexion.php");

// Verifica si los parámetros necesarios están presentes en la solicitud
$query_modificar = "UPDATE userweb SET userpassword = ?, lastchangepassword = ? WHERE dniusuarioweb = ?";
    
    $stmt = $conexion->prepare($query_modificar);

    if ($stmt) {
        // Asigna los parámetros
        $null = NULL;
        $stmt->bind_param("sss", $_REQUEST["dni"], $null, $_REQUEST["dni"]);

        // Ejecuta la consulta
        $stmt->execute();

        // Cierra la consulta preparada
        $stmt->close();

        echo "Datos actualizados correctamente.\n<a href='../../../sites/trabajadores.php'>Volver atrás</a>";
    } else {
        echo "Error en la preparación de la consulta.";
    }

// Cierra la conexión
$conexion->close();
?>
