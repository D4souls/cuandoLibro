<?php
include("../seguridad/conexion.php");
include("../seguridad/mail/sendUpdate.php");

try {
    if (!$conexion) {
        throw new Exception("Error en la conexion a la DB: " . $conexion->error);
    }

    if (isset($_REQUEST["id_turnoP"]) && isset($_REQUEST["dni"])) {
        $id_turno = $_REQUEST["id_turnoP"];
        $dni = $_REQUEST["dni"];

        //* OBTENER SUELDO DEL TURNO

        $query_quitarTurno = "UPDATE turnos_publicados SET dni = NULL WHERE id_turnoP = ?";

        $stmt_qQuitarTurno = $conexion->prepare($query_quitarTurno);

        if (!$stmt_qQuitarTurno) {
            throw new Exception("Error al preparar la consulta de obtener sueldo turno: " . $conexion->error);
        }

        $stmt_qQuitarTurno->bind_param("i", $id_turno);

        $mail = sendUpdateSchedule($id_turno, $dni, $conexion);

        if($mail){
            if (!$stmt_qQuitarTurno->execute()) {
                throw new Exception("Error al ejecutar la consulta de obtener sueldo turno: " . $conexion->error);
            } else {
                $response = array('success' => true, 'message' => 'Turno desasignado correctamente y aviso generado.');
                echo json_encode($response);
            }
        } else {
            throw new Exception($mail);
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