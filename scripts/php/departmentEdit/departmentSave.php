<?php
include("../seguridad/conexion.php");

// Verifica si los parámetros necesarios están presentes en la solicitud
$query_modificar = "UPDATE departamentos SET id_departamento = ?, nombre = ?, presupuesto = ? WHERE id_departamento = ?";
    
    $stmt = $conexion->prepare($query_modificar);

    if ($stmt) {
        // Asigna los parámetros
        $stmt->bind_param("isii", $_REQUEST["id_departamento"], $_REQUEST["nombre"], $_REQUEST["presupuesto"], $_REQUEST["id_departamento"]);

        // Ejecuta la consulta
        $stmt->execute();

        // Cierra la consulta preparada
        $stmt->close();

        echo "Datos actualizados correctamente.\n<a href='../../../sites/departamentos.php#department'>Volver atrás</a>";
    } else {
        echo "Error en la preparación de la consulta.";
    }

// Cierra la conexión
$conexion->close();
?>
