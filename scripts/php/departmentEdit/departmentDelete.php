<?php
include("../seguridad/conexion.php");

$id = $_REQUEST["id"];

$query_delete = "DELETE FROM departamentos WHERE id_departamento = ?";

try {

    $stmt_queryDelete = $conexion->prepare($query_delete);

    if (!$stmt_queryDelete) {
        throw new Exception("Error al preparar la consulta de deleteDepartment" . $conexion->error);
    }

    $stmt_queryDelete->bind_param('i', $id);

    if (!$stmt_queryDelete) {
        throw new Exception("Error al vincular parametros en la consulta de deleteDepartment" . $conexion->error);
    }

    $stmt_queryDelete->execute();

    if (!$stmt_queryDelete) {
        $mensaje = "Error al preparar la consulta de borrado de depart.";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    } else {
        $mensaje = "Departamento eliminado correctamente.";
        $response = array('success' => true, 'message' => $mensaje);
        echo json_encode($response);
    }

    $stmt_queryDelete->close();

} catch (Exception $e) {
    $response = array('success' => false, 'message' => $e);
    echo json_encode($response);
} finally {
    if ($conexion) {
        $conexion->close();
    }
}
?>