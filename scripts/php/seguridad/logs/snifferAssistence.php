<?php

try {

    function checkAviso($dni, $id_turno, $tipo, $conexion)
    {
        $query_check = "SELECT dni FROM aviso WHERE dni = ? AND id_turnoP = ? AND tipo = ?";

        $stmt_check = $conexion->prepare($query_check);

        $stmt_check->bind_param("sii", $dni, $id_turno, $tipo);

        if ($stmt_check->execute()) {

            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                return true;
            } else {
                return false;
            }

        } else {
            throw new Exception($conexion->error);
        }
    }

    function crearAviso($dni, $id_turnoP, $fecha, $conexion)
    {

        try {

            $tipo = 6;

            $query_check = "SELECT dni FROM aviso WHERE dni = ? AND id_turnoP = ? AND tipo = ?";

            $stmt_check = $conexion->prepare($query_check);

            $stmt_check->bind_param("sii", $dni, $id_turnoP, $tipo);

            if ($stmt_check->execute()) {

                $stmt_check->store_result();

                if ($stmt_check->num_rows > 0) {
                    $stmt_check->close();
                    return false;
                } else {
                    //? SI NO LO HAY LO GENERA

                    $query = "INSERT INTO aviso (tipo, comentario, dni, id_turnoP) VALUES (?, ?, ?, ?)";

                    $stmt = $conexion->prepare($query);

                    if (!$stmt) {
                        throw new Exception($conexion->error);
                    }

                    //? VOLVEMOS A OBTENER LA FECHA ACTUAL

                    $paisTimeZone = new DateTimeZone('Europe/Madrid');

                    $paisDateTime = new DateTime('now', $paisTimeZone);

                    $formatoDateTime = $paisDateTime->format('d/m/Y');

                    $comentario = "Ausencia sin justificar en la fecha " . $formatoDateTime;

                    $stmt->bind_param("issi", $tipo, $comentario, $dni, $id_turnoP);

                    if (!$stmt) {
                        throw new Exception($conexion->error);
                    }

                    if ($stmt->execute()) {
                        return true;
                    } else {
                        throw new Exception($conexion->error);
                    }
                }

            } else {
                throw new Exception($conexion->error);
            }
            
        } catch (Exception $e) {
            return ("Error en la funcion: " . $e);
        }


    }

    include("../conexion.php");
    include("../mail/sendAssistence.php");

    //? DIA DE HOY

    $paisTimeZone = new DateTimeZone('Europe/Madrid');

    $paisDateTime = new DateTime('now', $paisTimeZone);

    $formatoDateTime = $paisDateTime->format('Y-m-d');


    //* QUERY A LA DB

    $query = "SELECT dni, id_turnoP FROM turnos_publicados 
    WHERE dni IS NOT NULL
    AND hora_fichaje_entrada IS NULL 
    AND hora_fichaje_salida IS NULL 
    AND fecha = ?";

    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception($conexion->error);
    }

    $stmt->bind_param("s", $formatoDateTime);

    if (!$stmt) {
        throw new Exception($conexion->error);
    }

    if ($stmt->execute()) {

        $stmt->store_result();

        if (!$stmt) {
            throw new Exception($conexion->error);
        }

        if ($stmt->num_rows > 0) {

            $stmt->bind_result($dni, $id_turnoP);

            while ($stmt->fetch()) {

                $datos[] = array(
                    'dni' => $dni,
                    'id_turnoP' => $id_turnoP,
                    'fecha' => $formatoDateTime,
                );
            }

            $totalData = array();

            $res = array_merge($totalData, $datos);

            // print_r($res);

            foreach ($res as $dniNoAssistence) {

                $dniNoA = $dniNoAssistence['dni'];
                $id_turnoPNoA = $dniNoAssistence['id_turnoP'];
                $fechaActual = $dniNoAssistence['fecha'];

                print("======" . $dniNoA . "======\n");

                $aviso = crearAviso($dniNoA, $id_turnoPNoA, $fechaActual, $conexion);
                if ($aviso) {
                    print("✅ Aviso creado correctamente\n");

                    $mail = sendNoAssistence($dniNoA, $conexion);

                    if ($mail) {
                        print "✅ Mail enviado correctamente para " . $dniNoA . "\n";
                    } else {
                        print $e;
                    }
                } else {
                    print("❌ " . $dniNoA . " ya tiene al aviso generado");
                }
            }

        } else {
            throw new Exception("❌ No hay datos en la fecha " . $formatoDateTime);
        }

    } else {
        throw new Exception($conexion->error);
    }

} catch (Exception $e) {
    print($e);
} finally {
    if ($conexion) {
        $conexion->close();
    }
}
?>