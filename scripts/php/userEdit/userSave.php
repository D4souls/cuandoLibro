<?php
include("../seguridad/conexion.php");

$query_modificar = "UPDATE empleados SET nombre = ?, apellido1 = ?, apellido2 = ?, IBAN = ?, n_departamento = ?, n_categoria = ? WHERE dni = ?";
$stmt = $conexion->prepare($query_modificar);

if ($stmt) {
    $stmt->bind_param("sssssss", $_REQUEST["nombre"], $_REQUEST["apellido1"], $_REQUEST["apellido2"], $_REQUEST["IBAN"], $_REQUEST["n_departamento"], $_REQUEST["n_categoria"], $_REQUEST["dni"]);
    $stmt->execute();
    $stmt->close();


    $response = array('success' => true, 'message' => 'Datos actualizados correctamente');
    echo json_encode($response);
} else {

    $stmtMessage = "Error en la preparación de la consulta.";
    $response = array('success' => false, 'message' => $stmtMessage);
    echo json_encode($response);
    exit;
}

// Cierra la conexión
$conexion->close();
