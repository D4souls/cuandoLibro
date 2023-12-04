<?php
    include("../seguridad/conexion.php");
    $dni = $_GET["dni"];

    $query_delete = "DELETE FROM empleados WHERE dni = ?";

    $stmt = $conexion->prepare($query_delete);

    if(!$stmt){
        $mensaje = "Error al preparar la consulta";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    $stmt->bind_param("s", $dni);

    if(!$stmt){
        $mensaje = "Error al vincular datos en la consulta";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    }

    $stmt->execute();

    if(!$stmt){
        $mensaje = "Error al ejecutar la consulta";
        $response = array('success' => false, 'message' => $mensaje);
        echo json_encode($response);
    } else {
        $mensaje = "Trabajador eliminado correctamente";
        $response = array('success' => true, 'message' => $mensaje);
        echo json_encode($response);
    }

    $stmt->close();
    $conexion->close();
?>