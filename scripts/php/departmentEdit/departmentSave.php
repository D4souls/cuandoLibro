<?php
include("../seguridad/conexion.php");

$id = $_REQUEST["id"];
$nombre = $_REQUEST["nombre"];
$presupuesto = $_REQUEST["presupuesto"];

$query_modificar = "UPDATE departamentos SET nombre = ?, presupuesto = ? WHERE id_departamento = ?";

try {
    $stmt = $conexion->prepare($query_modificar);

    if (!$stmt) {
        $mensaje = "Error al preparar la consulta de actualización del depart.";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    $stmt->bind_param('sii', $nombre, $presupuesto, $id);

    if (!$stmt) {
        $mensaje = "Error al vincular parametros de la consulta de actualización del depart.";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    if (!$stmt->execute()) {
        $mensaje = "Error al ejecutar la consulta de actualización del depart.";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    } else {
        $mensaje = "Datos del departamento actualizados correctamente.";
        $response = array('success' => true, 'message' => $mensaje);
        echo json_encode($response);
        $stmt->close();
    }

} catch (Exception $e) {

} finally {
    if ($conexion) {
        $conexion->close();
    }
}
?>