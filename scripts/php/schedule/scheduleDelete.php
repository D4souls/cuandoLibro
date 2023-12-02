<?php
include("../seguridad/conexion.php");

if (!$conexion) {
    throw new Exception("Error en la conexion a la DB: " . $conexion->error);
}

try {

    if (isset($_REQUEST["id_turnoP"])) {
        $query_delete = "DELETE FROM turnos_publicados WHERE id_turnoP = ?";


        $stm = $conexion->prepare($query_delete);

        if (!$stm) {
            throw new Exception("Error al preparar la consulta" . $conexion->error);
        }

        $stm->bind_param("s", $_REQUEST["id_turnoP"]);

        if (!$stm) {
            throw new Exception("Error al vincular parametros de la consulta" . $conexion->error);
        }


        if ($stm->execute()) {
            $stm->close();
            $response = array('success' => true, 'message' => 'Turno eliminado correctamente');
            echo json_encode($response);
        } else {
            $stm->close();
            $response = array('success' => false, 'message' => 'Error al ejecutar la consulta');
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'Faltan datos por enviar');
        echo json_encode($response);
    }

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
} finally {
    $conexion->close();
}
?>