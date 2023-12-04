<?php
include("../seguridad/conexion.php");


if (!$conexion) {
    $mensaje = "Error al conectarse a la DB";
    $response = array('success' => false, 'message' => $mensaje);
    echo json_encode($response);
    exit();
}

$nombre = $_REQUEST["nombre"];
$apellido1 = $_REQUEST["apellido1"];
$apellido2 = $_REQUEST["apellido2"];
$IBAN = $_REQUEST["iban"];
$mail = $_REQUEST["mail"];
$n_departamento = $_REQUEST["n_departamento"];
$n_categoria = $_REQUEST["n_categoria"];
$dni = $_REQUEST["dni"];

$query_modificar = "UPDATE empleados SET nombre = ?, apellido1 = ?, apellido2 = ?, IBAN = ?, mail = ?, n_departamento = ?, n_categoria = ? WHERE dni = ?";
try {
    $stmt = $conexion->prepare($query_modificar);

    if (!$stmt) {
        $mensaje = "Error al preparar la consulta";
        $response = array('success' => false, 'message' => $mensaje);
        
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param("ssssssss", $nombre, $apellido1, $apellido2, $IBAN, $mail, $n_departamento, $n_categoria, $dni);

    if (!$stmt) {
        $mensaje = "Error al vincular parametros en la consulta";
        $response = array('success' => false, 'message' => $mensaje);
        
        echo json_encode($response);
        exit();
    }

    if ($stmt->execute()) {
        $mensaje = "Datos actualizados correctamente";
        $response = array('success' => true, 'message' => $mensaje);
        
        echo json_encode($response);
    } else {
        $mensaje = "Error al ejecutar la consulta";
        $response = array('success' => false, 'message' => $mensaje);
        
        echo json_encode($response);
    }
    $stmt->close();

} catch (Exception $e) {
    $mensaje = "Error: " . $e->getMessage();
    $response = array('success' => false, 'message' => $mensaje);
    
    echo json_encode($response);
} finally {
    if ($conexion) {
        $conexion->close();
    }
}
