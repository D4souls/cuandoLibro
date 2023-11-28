<?php
include("../conexion.php");

if (!$conexion) {
    echo "Fallo en la conexión con la base de datos.";
} else {
    $filename = 'logs.csv';
    $contents = file($filename);

    if ($contents) {
        $conteo = 0;
        foreach ($contents as $line) {
            list($uid, $fecha, $hora_entrada, $hora_salida) = explode(';', $line);

            $hora_salida == null ? $hora_salida = null : $hora_salida;

            $conteo++;
            echo "\n=========== $conteo ===========\n";

            //? Comporbación del turno publicado
            $check = "SELECT id_turnoP, fecha, hora_fichaje_entrada, hora_fichaje_salida, id_turno FROM turnos_publicados WHERE dni=? AND fecha = ?";
            $stm_check = $conexion->prepare($check);
            if ($stm_check) {
                echo "✅ Consulta para registro nº" . $conteo . " completada\n";
            } else {
                die("❌ Preparacion: " . $conexion->error);
            }
            $stm_check->bind_param("ss", $uid, $fecha);

            if ($stm_check->execute()) {
                $stm_check->store_result();
                if ($stm_check->num_rows > 0) { //? Si no devuelve una fila no hay registro
                    $stm_check->bind_result($id_turnoP, $fecha_existente, $hfe, $hfs, $id_turno);
                    $stm_check->fetch();
                    echo "✅ Ejecución para registro nº" . $conteo . " completado\n";

                    if ($hfe !== null && $hfs !== null) {
                        echo "❌ $uid ya tiene registro\n";
                        continue;
                    } else {
                        $update = 'UPDATE turnos_publicados SET hora_fichaje_entrada = ?, hora_fichaje_salida = ? WHERE dni=? AND fecha=?';
                        $stmt = $conexion->prepare($update);
                        $stmt->bind_param('ssss', $hora_entrada, $hora_salida, $uid, $fecha);

                        if ($stmt->execute()) {
                            echo "✅ Actualización exitosa\n";
                        } else {
                            echo "❌ Error en la actualización\n" . $conexion->error;
                        }
                        $stmt->close();

                        $turnos = "SELECT hora_entrada, hora_salida FROM turnos WHERE id_turno = ?";
                        $stmt_turnos = $conexion->prepare($turnos);

                        if (!$stmt_turnos) {
                            die("Error al preparar la consulta de turnos\n" . $conexion->error);
                        }
                        $stmt_turnos->bind_param("i", $id_turno);
                        if (!$stmt_turnos) {
                            die("Error al vincular datos en la consulta de turnos\n" . $conexion->error);
                        }
                        if (!$stmt_turnos->execute()) {
                            die("Error al ejecutar la consulta de turnos\n" . $conexion->error);
                        }

                        $stmt_turnos->bind_result($hora_entradaT, $hora_salidaT);
                        if ($stmt_turnos->fetch()) {
                            $stmt_turnos->close();
                            //? FORMATEAMOS LA HORA REAL A LA QUE ENTRA EL TRABAJADOR
                            
                            $hora_entrada_timestamp = strtotime($hora_entrada);
                            $hora_entradaReal = date("H:i:s", $hora_entrada_timestamp);

                            //? CREAMOS EL RANGO MÁXIMO ACEPTADO DE LAS HORAS
                            
                            $calcularhoraMaxima = strtotime('+5 minutes', strtotime($hora_entradaT));
                            $horaMaxima = date("H:i:s", $calcularhoraMaxima);

                            //? CREAMOS EL RANGO MÍNIMO ACEPTADO DE LAS HORAS
                            
                            $calcularhoraMinima = strtotime('-1 hour', strtotime($hora_salidaT));
                            $horaMinima = date("H:i:s", $calcularhoraMinima);

                            //? REALIZAMOS COMPARACIÓNES DE HORAS

                            if (strtotime($hora_entradaReal) > strtotime($horaMaxima)) {
                                $diferencia = date_diff(new DateTime($hora_entradaReal), new DateTime($horaMaxima));
                                $comentarioAviso = "El trabajador ha entrado tarde " . $diferencia->format('%H:%I:%S');
                                
                                //! COMPROBAMOS SI YA HAY AVISO PARA ESTE EMPLEADO
                                $check_avio = "";


                                //? AHORA INSERTAMOS EL AVISO
                                $aviso = "INSERT INTO aviso(tipo, comentario, dni, id_turnoP) VALUES (?,?,?,?)";
                                $stmt_aviso = $conexion->prepare($aviso);
                                if(!$stmt_aviso){
                                    die("Error al preparar el aviso: ".$conexion->error);
                                }
                                $tipoviso = 1;
                                $stmt_aviso->bind_param("issi", $tipoviso, $comentarioAviso, $uid, $id_turnoP);
                                if(!$stmt_aviso){
                                    die("Error al vincular los datos en la consulta de avisos: ".$conexion->error);
                                }
                                if(!$stmt_aviso->execute()){
                                    die("Error al insertar el aviso en la DB: ".$stmt_aviso->error);
                                } else {
                                    print ("✅ Aviso creado correctamente");
                                }
                                $stmt_aviso->close();
                            } else {
                                print("✅ ".$uid." fichó correctamente");
                            }
                        } else {
                            die("No se encontraron datos en la tabla de turnos\n" . $conexion->error);
                        }
                        //? Comprobación de la fecha a la que sale
                    }
                } else {
                    echo "❌ $uid no tiene registro en la fecha $fecha\n";
                }

            } else {
                die("❌ Ejecucion: " . $conexion->error);
            }
            $stm_check->close();
        }
    } else {
        echo "❌ No hay datos que leer";
    }
}
$conexion->close();
?>