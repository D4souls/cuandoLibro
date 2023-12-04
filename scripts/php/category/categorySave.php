<?php
include("../seguridad/conexion.php");

try {
    $query_modificar = "UPDATE categorias SET nombre = ?, sueldo_normal = ?, sueldo_plus = ? WHERE id_categoria = ?";

    $stmt = $conexion->prepare($query_modificar);

    if (!$stmt) {
        $mensaje = "Error al preparar la consulta de guardado";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    $stmt->bind_param("sddi", $_REQUEST["nombre"], $_REQUEST["sueldo_normal"], $_REQUEST["sueldo_plus"], $_REQUEST["id_categoria"]);

    if (!$stmt) {
        $mensaje = "Error al vincular parámetros de la consulta de guardado";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    if (!$stmt->execute()) {
        $mensaje = "Error al ejecutar la consulta de guardado";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    } else {
        $mensaje = "Cambios guardados con éxito.";
        $response = array('success' => true, 'message' => $mensaje);
        echo json_encode($response);
    }
} catch (Exception $e) {
    $response = array('success' => false, 'message' => $e);
    echo json_encode($response);
} finally {
    if ($conexion) {
        $conexion->close();
    }
}
?>