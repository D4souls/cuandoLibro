<?php
include_once("../conexion.php");
include_once("./initNominas.php");

//? OBTENER FECHA ACTUAL

$fechaActual = date("Y-m");


//? CALCULAR EL SALARIO BASE
function calcularSalarioBase($salarioBase)
{
    return $salarioBase * 8;
}

//? OBTENER € DE CATEGORÍA

function obtenerDineroCategoria($id, $conexion)
{
    try {
        $sueldo_normal = '';
        $sueldo_plus = '';

        $query = "SELECT sueldo_normal, sueldo_plus FROM categorias WHERE id_categoria = ?";

        $stmt = $conexion->prepare($query);

        if (!$stmt) {
            throw new Exception("❌ Error al preparar la consulta" . $conexion->error);
        }

        $stmt->bind_param("i", $id);

        if (!$stmt) {
            throw new Exception("❌ Error al vincular parámetros en la consulta" . $conexion->error);
        }

        $stmt->execute();

        if (!$stmt) {
            throw new Exception("❌ Error al ejecutar la consulta" . $conexion->error);
        }

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($sueldo_normal, $sueldo_plus);
            $stmt->fetch();
            $stmt->close();

            return array("sueldo_normal" => calcularSalarioBase($sueldo_normal), "sueldo_plus" => $sueldo_plus);
        } else {
            throw new Exception("❌ No hay sueldo asignado para esa categoría: " . $conexion->error);
        }

    } catch (Exception $e) {
        return $e;

    }
}

//? CALCULAR LA CANT. DE HORAS EXTRAS REALIZADAS EN TODOS LOS TURNOS

function calcularHorasExtras($dni, $fechaActual, $conexion)
{
    try {
        $query = "SELECT DATE_FORMAT(tp.hora_fichaje_salida, '%H') AS hora_fichaje_salida, 
        DATE_FORMAT(t.hora_salida, '%H') AS hora_salida 
        FROM turnos_publicados tp 
        INNER JOIN turnos t ON t.id_turno = tp.id_turno WHERE tp.dni = ? AND DATE_FORMAT(tp.fecha, '%Y-%m') = ?";

        $stmt = $conexion->prepare($query);

        if (!$stmt) {
            throw new Exception("❌ Error al preparar la consulta de horas extras: " . $conexion->error);
        }

        $stmt->bind_param("ss", $dni, $fechaActual);

        if (!$stmt) {
            throw new Exception("❌ Error al vincular parámetros de la consulta de horas extras: " . $conexion->error);
        }

        $stmt->execute();

        if (!$stmt) {
            throw new Exception("❌ Error al ejecutar la consulta de horas extras: " . $conexion->error);
        }

        $stmt->store_result();

        if ($stmt->num_rows > 0) {

            //* INICIALIZACIÓN DE VARIABLES

            $hora_fichaje_salida = '';
            $hora_salida = '';
            $totalHoras = 0;

            $stmt->bind_result($hora_fichaje_salida, $hora_salida);

            while ($stmt->fetch()) {

                $horasExtras = $hora_fichaje_salida - $hora_salida;

                $totalHoras += $horasExtras;
            }

            return $totalHoras;

        } else {
            throw new Exception("❌ No hay datos de fichaje para este empleado" . $conexion->error);
        }
    } catch (Exception $e) {
        return $e;
    }
}


//? GENERAR CARPETA

function comprobarCarpeta($dni, $year)
{
    try {
        $rutaPrincipal = "../nominas";
        $rutaUsuario = $rutaPrincipal . "/" . $dni;
        $rutaAno = $rutaUsuario . "/" . $year;

        if (!file_exists($rutaAno)) {
            mkdir($rutaAno);
            return "✅ Carpeta creada para " . $dni . "\n";
        }

        return "❌ Ya tiene carpeta creada " . $dni . "\n";

    } catch (Exception $e) {
        return $e;
    }

}

//? OBTENER DATOS DE LOS TURNOS PUBLICADOS Y AÑADIR CANT. €

try {
    $query_TP = "SELECT tp.DNI, tp.categoria, COUNT(tp.DNI) AS 'cantidadTurnos', tp.id_turnoP, e.nombre, e.apellido1, e.apellido2, e.mail
    FROM turnos_publicados tp
    INNER JOIN empleados e ON e.dni = tp.dni
    WHERE DATE_FORMAT(fecha, '%Y-%m') = ? AND tp.hora_fichaje_entrada IS NOT NULL AND tp.hora_fichaje_salida IS NOT NULL
    GROUP BY dni
    ";

    $stmt_qTP = $conexion->prepare($query_TP);

    if (!$stmt_qTP) {
        print "Error al preparar la consulta de obtener TP";
    }

    $stmt_qTP->bind_param("i", $fechaActual);

    if (!$stmt_qTP) {
        print "Error al vincular parámetros de la consulta de obtener TP";
    }

    $stmt_qTP->execute();

    if (!$stmt_qTP) {
        throw new Exception("Error al ejecutar la consulta de obtener TP" . $conexion->error);
    } else {
        $stmt_qTP->store_result();

        if ($stmt_qTP->num_rows > 0) {

            $stmt_qTP->bind_result($dni, $categoria, $cantidadTurnos, $id_turnoP, $nombre, $apellido1, $apellido2, $mail);

            while ($stmt_qTP->fetch()) {

                //* OBTENEMOS LA CANTIDAD DE TURNOS Y CATEGORÍA DE CADA EMPLEADO

                $sueldoBase = obtenerDineroCategoria($categoria, $conexion);

                //*  CALCULAMOS EL SUELDO BASE QUE HAY QUE PAGAR Y LAS HORAS EXTRAS

                $horasExtras = calcularHorasExtras($dni, $fechaActual, $conexion);

                $datos[] = array(
                    'dni' => $dni,
                    'nombre' => $nombre,
                    'apellidos' => $apellido1 . ' ' . $apellido2,
                    'mail' => $mail,
                    'categoria' => $categoria,
                    'cantidadTurnos' => $cantidadTurnos,
                    'sueldo_normal' => $sueldoBase['sueldo_normal'],
                    'sueldo_plus' => $sueldoBase['sueldo_plus'],
                    'horas_extras' => $horasExtras,
                    'total_sueldo_normal' => $sueldoBase['sueldo_normal'] * $cantidadTurnos,
                    'total_sueldo_plus' => $sueldoBase['sueldo_plus'] * $horasExtras,
                    'total_nomina' => ($sueldoBase['sueldo_normal'] * $cantidadTurnos) + ($sueldoBase['sueldo_plus'] * $horasExtras)
                );

                $totalDatos = array();

                $res = array_merge($totalDatos, $datos);

            }
            
            // print_r($res);
            
            foreach($res as $dataEmpleado){

                $dni = $dataEmpleado['dni'];
                print("===========" . $dni . "===========\n");
                
                $carpeta = comprobarCarpeta($dni, date('Y'));
                print $carpeta;

                $nomina = creaNomina($dataEmpleado);
                print $nomina;

            }


        } else {
            print "❌ No hay turnos publicados para este mes";
        }

    }
} catch (Exception $e) {
    print("❌ Error detectado: " . $e);
} finally {
    if ($conexion) {
        $conexion->close();
    }
}

?>