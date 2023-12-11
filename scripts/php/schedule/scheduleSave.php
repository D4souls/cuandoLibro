<?php
include("../seguridad/conexion.php");

if (!$conexion) {
    throw new Exception("Error al conectar con la DB: " . $conexion->error);
}

try {
    $horario = mysqli_real_escape_string($conexion, $_REQUEST['horario']);
    $categoria = mysqli_real_escape_string($conexion, $_REQUEST['n_categoria']);
    $departamento = mysqli_real_escape_string($conexion, $_REQUEST['n_departamento']);
    $fecha = mysqli_real_escape_string($conexion, $_REQUEST['fecha']);
    $cantidad = mysqli_real_escape_string($conexion, $_REQUEST['cantidad']);

    $query_ObtenerDinero = "SELECT presupuesto, gastos FROM departamentos WHERE id_departamento = ?";
    $resultado_qObtenerDinero = $conexion->prepare($query_ObtenerDinero);

    if (!$resultado_qObtenerDinero) {
        throw new Exception("Error al preparar la consulta para obtener dinero: " . $conexion->error);
    }

    $resultado_qObtenerDinero->bind_param("i", $departamento);

    if (!$resultado_qObtenerDinero->execute()) {
        throw new Exception("Error al ejecutar la consulta para obtener dinero: " . $resultado_qObtenerDinero->error);
    }

    $resultado_qObtenerDinero->store_result();

    if ($resultado_qObtenerDinero->num_rows > 0) {
        $resultado_qObtenerDinero->bind_result($presupuesto, $gastos);
        $resultado_qObtenerDinero->fetch();

        $resultado_qObtenerDinero->close();


        //* COMPROBAMOS LOS GASTOS DEL DEPARTAMENTO

        if ($gastos < $presupuesto) {


            //* OBTENER SUELDO DEL TURNO

            $query_obtenerSueldo = "SELECT sueldo_normal FROM categorias WHERE id_categoria = ?";

            $stmt_qObtenerSueldo = $conexion->prepare($query_obtenerSueldo);

            if (!$stmt_qObtenerSueldo) {
                throw new Exception("Error al preparar la consulta de obtener sueldo turno: " . $conexion->error);
            }

            $stmt_qObtenerSueldo->bind_param("i", $categoria);

            if (!$stmt_qObtenerSueldo) {
                throw new Exception("Error al vincular parámetros de la consulta de obtener sueldo turno: " . $conexion->error);
            }

            $stmt_qObtenerSueldo->execute();

            if (!$stmt_qObtenerSueldo) {
                throw new Exception("Error al ejecutar la consulta de obtener sueldo turno: " . $conexion->error);
            }

            $stmt_qObtenerSueldo->store_result();

            if ($stmt_qObtenerSueldo->num_rows > 0) {
                $stmt_qObtenerSueldo->bind_result($sueldo_normal);
                $stmt_qObtenerSueldo->fetch();
                $stmt_qObtenerSueldo->close();

                //* COMPROBAMOS SI EL SUELDO DEL EMPLEADO AL INSERTARLO NO SUPERA EL LIMITE

                if ($gastos + ($sueldo_normal * $cantidad) <= $presupuesto) {

                    //! INICIALIZAMOS LAS TRANSACCIONES

                    $conexion->begin_transaction();

                    //* CREAMOS EL TURNO PUBLICADO

                    $query_insert = "INSERT INTO turnos_publicados(categoria, departamento, fecha, id_turno) VALUES (?, ?, ?, ?)";
                    $resultado_insert = $conexion->prepare($query_insert);

                    if (!$resultado_insert) {
                        throw new Exception("Error al preparar la consulta para insertar turnos: " . $conexion->error);
                    }

                    $resultado_insert->bind_param("iisi", $categoria, $departamento, $fecha, $horario);

                    if (!$resultado_insert) {
                        throw new Exception("Error al vincular parametros en la consulta para insertar turnos: " . $conexion->error);
                    }

                    $contador = 0;
                    while ($contador < $cantidad) {
                        $resultado_insert->execute();

                        if (!$resultado_insert && !$stmt_qGenerarGasto) {
                            throw new Exception("Error al ejecutar la consulta para insertar turnos & generar gasto: " . $conexion->error);
                        } else {
                            $contador++;
                        }
                    }

                    //* GENERAMOS EL GASTO AL DEPARTAMENTO

                    $gastoTotal = $gastos + ($sueldo_normal * $cantidad);

                    $query_generarGasto = "UPDATE departamentos SET gastos = ? WHERE id_departamento = ?";

                    $stmt_qGenerarGasto = $conexion->prepare($query_generarGasto);

                    if (!$stmt_qGenerarGasto) {
                        throw new Exception("Error al preparar la consulta para generar el gasto: " . $conexion->error);
                    }

                    $stmt_qGenerarGasto->bind_param("ds", $gastoTotal, $departamento);

                    if (!$stmt_qGenerarGasto) {
                        throw new Exception("Error al vincular parámetros en la consulta para generar el gasto: " . $conexion->error);
                    }

                    $stmt_qGenerarGasto->execute();

                    if (!$stmt_qGenerarGasto) {
                        throw new Exception("Error al ejecutar la consulta para generar el gasto: " . $conexion->error);
                    }

                    $stmt_qGenerarGasto->close();


                    //* EJECUTAMOS TODAS LAS CONSULTAS

                    $conexion->commit();

                    $resultado_insert->close();

                    $response = array('success' => true, 'message' => 'Turnos creados correctamente');
                    echo json_encode($response);
                } else {
                    $response = array('success' => false, 'message' => 'El departamento no puede pagar completamente este turno');
                    echo json_encode($response);
                }

            } else {
                $stmt_qObtenerSueldo->close();
                $response = array('success' => false, 'message' => 'La categoría seleccionada no tiene sueldo establecido');
                echo json_encode($response);
            }

        } else {
            $response = array('success' => false, 'message' => 'Los gastos del departamento superan el presupuesto');
            echo json_encode($response);
            exit();
        }
    }

} catch (Exception $e) {
    //! REVERTIMOS ACCIONES SI DA ERROR
    $conexion->rollback();

    $response = array('success' => false, 'message' => $e->getMessage());
    echo json_encode($response);
} finally {
    if ($conexion) {
        $conexion->close();
    }
}
?>