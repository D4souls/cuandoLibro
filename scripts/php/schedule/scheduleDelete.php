<?php
include("../seguridad/conexion.php");

if (!$conexion) {
    throw new Exception("Error en la conexion a la DB: " . $conexion->error);
}

try {

    if (isset($_REQUEST["id_turnoP"]) && isset($_REQUEST["id_categoria"])) {

        $id_turno = $_REQUEST["id_turnoP"];
        $id_categoria = $_REQUEST["id_categoria"];

        //* OBTENER SUELDO DEL TURNO

        $query_obtenerSueldo = "SELECT sueldo_normal, id_departamento FROM categorias WHERE id_categoria = ?";

        $stmt_qObtenerSueldo = $conexion->prepare($query_obtenerSueldo);

        if (!$stmt_qObtenerSueldo) {
            throw new Exception("Error al preparar la consulta de obtener sueldo turno: " . $conexion->error);
        }

        $stmt_qObtenerSueldo->bind_param("i", $id_categoria);

        if (!$stmt_qObtenerSueldo) {
            throw new Exception("Error al vincular parámetros de la consulta de obtener sueldo turno: " . $conexion->error);
        }

        $stmt_qObtenerSueldo->execute();

        if (!$stmt_qObtenerSueldo) {
            throw new Exception("Error al ejecutar la consulta de obtener sueldo turno: " . $conexion->error);
        }

        $stmt_qObtenerSueldo->store_result();

        if ($stmt_qObtenerSueldo->num_rows > 0) {
            $stmt_qObtenerSueldo->bind_result($sueldo_normal, $id_departamento);
            $stmt_qObtenerSueldo->fetch();
            $stmt_qObtenerSueldo->close();


            //* DESCONTAMOS EL DINERO DLE TURNO ELIMINADO AL DPT. 

            $query_delete = "DELETE FROM turnos_publicados WHERE id_turnoP = ?";
    
            $stm = $conexion->prepare($query_delete);
    
            if (!$stm) {
                throw new Exception("Error al preparar la consulta" . $conexion->error);
            }
    
            $stm->bind_param("i", $id_turno);
    
            if (!$stm) {
                throw new Exception("Error al vincular parametros de la consulta" . $conexion->error);
            }
    
            $query_descontarDinero = "UPDATE departamentos SET gastos = gastos - ? WHERE id_departamento = ?";

            $stmt_qDescontarDinero = $conexion->prepare($query_descontarDinero);

            if(!$stmt_qDescontarDinero){
                throw new Exception("Error al preparar la consulta de descontar dienero dep." . $conexion->error);
            }

            $stmt_qDescontarDinero->bind_param("di", $sueldo_normal, $id_departamento);

            if(!$stmt_qDescontarDinero){
                throw new Exception("Error al vincular parámetros en la consulta de descontar dinero dep." . $conexion->error);
            }
    
            if ($stmt_qDescontarDinero->execute() && $stm->execute()) {
                $stmt_qDescontarDinero->close();
                $stm->close();
                $response = array('success' => true, 'message' => 'Turno eliminado correctamente');
                echo json_encode($response);
            } else {
                $stmt_qDescontarDinero->close();
                $stm->close();
                throw new Exception("Error al ejecutar las consultas: " . $conexion->error);
            }

        } else {
            $response = array('success' => false, 'message' => 'Esta categoría no tiene sueldo asignado');
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