<?php
include("../seguridad/conexion.php");

if (!$conexion) {
    throw new Exception("Error al conectar con la DB:" . $conexion->error);
}

$query_modificar = "UPDATE userweb SET userpassword = ?, lastchangepassword = ? WHERE dniusuarioweb = ?";

try {
    $stmt = $conexion->prepare($query_modificar);

    if (!$stmt) {
        $mensaje = "Error al preparar la consulta.";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    $null = NULL;
    $stmt->bind_param("sss", $_REQUEST["dni"], $null, $_REQUEST["dni"]);

    if (!$stmt) {
        $mensaje = "Error al vincular parámetros la consulta.";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    if ($stmt->execute()) {
        $mensaje = "Contraseña reestablecida correctamente.";
        $response = array('success' => true, 'message' => $mensaje);
        echo json_encode($response);
    } else {
        $mensaje = "Error al ejecutar la consulta";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    $stmt->close();

} catch (Exception $e) {
    $response = array('success' => false, 'message' => $e);
    echo json_encode($response);
} finally {
    $conexion->close();
}
?>