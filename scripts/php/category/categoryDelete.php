<?php
include("../seguridad/conexion.php");

try {
    $query_delete = "DELETE FROM categorias WHERE id_categoria = ?";

    $stm = $conexion->prepare($query_delete);

    if(!$stm){
        $mensaje = "Error al preparar la consulta de eliminado";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    $stm->bind_param('s', $_REQUEST['id_categoria']);

    if(!$stm){
        $mensaje = "Error al vincular parámetros de la consulta de eliminado";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    if(!$stm->execute()){
        $mensaje = "Error al ejecutar la consulta de eliminado";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    } else {
        $mensaje = "Categoría eliminada correctamente";
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