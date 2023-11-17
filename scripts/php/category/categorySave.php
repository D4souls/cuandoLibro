<?php
include("../seguridad/conexion.php");
$departamento_id = $_GET["id_departamento"];
// Verifica si los parámetros necesarios están presentes en la solicitud
$query_modificar = "UPDATE categorias SET nombre = ?, sueldo_normal = ?, sueldo_plus = ? WHERE id_categoria = ?";
    
    $stmt = $conexion->prepare($query_modificar);

    if ($stmt) {
        // Asigna los parámetros
        $stmt->bind_param("siii", $_REQUEST["nombre"], $_REQUEST["sueldo_normal"], $_REQUEST["sueldo_plus"], $_REQUEST["id_categoria"]);

        // Ejecuta la consulta
        $stmt->execute();

        // Cierra la consulta preparada
        $stmt->close();

        echo "<center>Datos actualizados correctamente.\n<a href='../../../sites/categorias.php?id_departamento=$departamento_id'>Volver atrás</a></center>";
    } else {
        echo "Error en la preparación de la consulta.";
    }

// Cierra la conexión
$conexion->close();
?>
