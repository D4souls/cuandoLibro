<?php
include("../seguridad/conexion.php");

// Verifica la existencia de los parámetros requeridos
if (isset($_REQUEST["nombre"], $_REQUEST["apellido1"], $_REQUEST["apellido2"], $_REQUEST["IBAN"], $_REQUEST["dni"])) {

    // Prepara la consulta para actualizar los datos de empleados
    $query_modificar = "UPDATE empleados SET nombre = ?, apellido1 = ?, apellido2 = ?, IBAN = ? WHERE dni = ?";
    $stmt = $conexion->prepare($query_modificar);

    if ($stmt) {
        // Asigna los parámetros
        $stmt->bind_param("sssss", $_REQUEST["nombre"], $_REQUEST["apellido1"], $_REQUEST["apellido2"], $_REQUEST["IBAN"], $_REQUEST["dni"]);

        // Ejecuta la consulta
        $stmt->execute();

        // Cierra la consulta preparada
        $stmt->close();

        echo "<a href='../../../sites/my-portal.php'>Datos de empleados actualizados correctamente.<a>\n";
    } else {
        echo "Error en la preparación de la consulta para datos de empleados: " . $conexion->error;
    }
} else {
    echo "Faltan parámetros necesarios para la actualización de datos de empleados.";
}

// Verifica si se proporciona una nueva contraseña
if (isset($_REQUEST["userpassword"])) {
    // Hash de la contraseña
    $hashed_password = hash("sha256", $_REQUEST["userpassword"]);
    $timestamp = date("Y-m-d H:i:s");

    // Prepara la consulta para actualizar la contraseña de userweb
    $query_modificarPassword = "UPDATE userweb SET userpassword = ?, lastchangepassword = ? WHERE dniusuarioweb = ?";
    $stmt2 = $conexion->prepare($query_modificarPassword);

    if ($stmt2) {
        // Asigna los parámetros
        $stmt2->bind_param("sss", $hashed_password, $timestamp, $_REQUEST["dni"]);

        // Ejecuta la consulta
        $stmt2->execute();

        // Cierra la consulta preparada
        $stmt2->close();

        echo "<a href='../../../sites/my-portal.php'>Contraseña actualizada correctamente.<a>";
    } else {
        echo "Error en la preparación de la consulta para la contraseña: " . $conexion->error;
    }
}

// Cierra la conexión
$conexion->close();