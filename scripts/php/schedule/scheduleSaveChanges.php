<?php
include("../seguridad/conexion.php");

// Verifica si los parámetros necesarios están presentes en la solicitud
$query_modificar = "UPDATE turnos_publicados SET dni = ? WHERE id_turnoP = ?";
    
    $stmt = $conexion->prepare($query_modificar);

    if ($stmt) {
        // Asigna los parámetros
        $stmt->bind_param("si", $_REQUEST["dni"], $_REQUEST["id_turnoP"]);

        // Ejecuta la consulta
        $stmt->execute();

        // Cierra la consulta preparada
        $stmt->close();

        echo "Datos actualizados correctamente.\n<a href='../../../sites/horarios.php'>Volver atrás</a>";
    } else {
        echo "Error en la preparación de la consulta.";
    }

// Cierra la conexión
$conexion->close();
?>
