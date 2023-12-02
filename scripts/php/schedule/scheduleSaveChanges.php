<?php
include("../seguridad/conexion.php");

if (!$conexion) {
    throw new Exception("Error en la conexion a la DB: " . $conexion->error);
}

try {

    if (isset($_REQUEST["dni"]) && isset($_REQUEST["id_turnoP"]) && isset($_REQUEST["fecha"])) {

        //!COMPROBAMOS SI EL TRABAJADOR YA TIENE ANTES UN TURNO ASIGNADO PARA ESA FECHA

        $check_query = "SELECT dni FROM turnos_publicados WHERE fecha = ? AND dni = ?";

        $stmt_check = $conexion->prepare($check_query);

        if (!$stmt_check) {
            throw new Exception("Error al preparar la consulta" . $conexion->error);
        }

        $stmt_check->bind_param("ss", $_REQUEST["fecha"], $_REQUEST["dni"]);

        if (!$stmt_check) {
            throw new Exception("Error al vincular parametros de la consulta" . $conexion->error);
        }

        $stmt_check->execute();

        if (!$stmt_check) {
            throw new Exception("Error al ejecutar consulta de comprobación: " . $conexion->error);
        }

        $stmt_check->store_result();

        if(!$stmt_check){
            throw new Exception("Error al almacenar la consulta de comprobación: ". $conexion->error);
        }

        if ($stmt_check->num_rows > 0) {
            $stmt_check->close();
            $response = array('success' => false, 'message' => 'El trabajador ya tiene asignado otro turno en esa fecha');
            echo json_encode($response);
        } else {

            $query_modificar = "UPDATE turnos_publicados SET dni = ? WHERE id_turnoP = ?";
            $stmt = $conexion->prepare($query_modificar);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta" . $conexion->error);
            }

            $stmt->bind_param("si", $_REQUEST["dni"], $_REQUEST["id_turnoP"]);

            if (!$stmt) {
                throw new Exception("Error al vincular parametros de la consulta" . $conexion->error);
            }

            if ($stmt->execute()) {
                $stmt->close();
                $response = array('success' => true, 'message' => 'Turno asignado correctamente');
                echo json_encode($response);
            } else {
                $stmt->close();
                $response = array('success' => false, 'message' => 'Error al asignar turno correctamente');
                echo json_encode($response);
            }
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