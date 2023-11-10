<?php
include("../seguridad/conexion.php");

// Verifica si los parámetros necesarios están presentes en la solicitud
$query_modificar = "UPDATE empleados SET nombre = ?, apellido1 = ?, apellido2 = ?, IBAN = ?, n_departamento = ?, n_categoria = ? WHERE dni = ?";
    
    $stmt = $conexion->prepare($query_modificar);

    if ($stmt) {
        // Asigna los parámetros
        $stmt->bind_param("sssssss", $_REQUEST["nombre"], $_REQUEST["apellido1"], $_REQUEST["apellido2"], $_REQUEST["IBAN"], $_REQUEST["n_departamento"], $_REQUEST["n_categoria"], $_REQUEST["dni"]);

        // Ejecuta la consulta
        $stmt->execute();

        // Cierra la consulta preparada
        $stmt->close();

        echo "Datos actualizados correctamente.\n<a href='../../../dashboard.php#trabajadores'>Volver atrás</a>";
    } else {
        echo "Error en la preparación de la consulta.";
    }

// Cierra la conexión
$conexion->close();
?>
