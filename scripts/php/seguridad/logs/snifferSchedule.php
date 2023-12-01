<?php
include("../conexion.php");
include("../mail/getDataToMail.php");
include("../mail/send.php");

if (!$conexion) {
    print("Fallo en la conexión con la base de datos.");
} else {
    $filename = 'logs.csv';
    $contents = file($filename);

    if ($contents) {
        $conteo = 0;
        foreach ($contents as $line) {
            list($uid, $fecha, $hora_entrada, $hora_salida) = explode(';', $line);

            $hora_salida == null ? $hora_salida = null : $hora_salida;

            $conteo++;
            print("\n=========== $conteo ===========\n");

            //! COMPROBAMOS QUE HAYA UN TURNO PUBLICADO CON LOS DATOS DEL CSV

            $check = "SELECT id_turnoP, fecha, hora_fichaje_entrada, hora_fichaje_salida, id_turno FROM turnos_publicados WHERE dni=? AND fecha = ?";
            $stm_check = $conexion->prepare($check);
            if ($stm_check) {
                print("✅ Consulta para registro nº" . $conteo . " completada\n");
            } else {
                die("❌ Preparacion: " . $conexion->error . "\n");
            }
            $stm_check->bind_param("ss", $uid, $fecha);

            if ($stm_check->execute()) {
                $stm_check->store_result();
                if ($stm_check->num_rows > 0) { //! SI NO HAY FILAS ES QUE NO HAY REGISTRO EN LA DB PARA ESTA LÍNEA DEL CSV
                    $stm_check->bind_result($id_turnoP, $fecha_existente, $hfe, $hfs, $id_turno);
                    $stm_check->fetch();
                    print("✅ Ejecución para registro nº" . $conteo . " completado\n");

                    //! COMPROBAMOS SI HFE Y HFS ESTÁN VACÍAS
                    /*
                    $query_checkExistenciaAvisos = "SELECT tp.id_turnoP, tp.dni FROM turnos_publicados tp INNER JOIN aviso a ON a.dni = tp.dni AND a.id_turnoP = tp.id_turnoP WHERE tp.id_turnoP = ? AND tp.dni = ?";
                    $query_checkExistenciaAvisos = $conexion->prepare($query_checkExistenciaAvisos);

                    if(!$query_checkExistenciaAvisos) {
                        die("❌ Preparación de la comprobación de query_checkExistenciaAvisos" . $conexion->error . "\n");
                    }

                    $query_checkExistenciaAvisos->bind_param("is", $id_turnoP, $uid);

                    if(!$query_checkExistenciaAvisos->execute()) {
                        die("❌ Error al ejecutar la query_checkExistenciaAvisos". $conexion->error . "\n");
                    }

                    $query_checkExistenciaAvisos->get_result();
                    */
                    if ($hfe !== null && $hfs !== null) {
                        print("❌ $uid ya tiene registro\n");
                        continue;
                    } else {

                        //! ACTUALIZAMOS LOS CAMPOS HFE Y HFS DE TURNOS_PUBLICADOS 

                        $update = 'UPDATE turnos_publicados SET hora_fichaje_entrada = ?, hora_fichaje_salida = ? WHERE dni=? AND fecha=?';
                        $stmt = $conexion->prepare($update);
                        $stmt->bind_param('ssss', $hora_entrada, $hora_salida, $uid, $fecha);

                        if (!$stmt->execute()) {
                            die("❌ Error en la actualización: " . $conexion->error . "\n");
                        } else {
                            echo "✅ Actualización exitosa\n";
                            $stmt->close();
                        }

                        //! COMPROBACIÓN DE LA HORA SEGÚN EL TURNO DEL EMPLEADO HFE Y HFS

                        $turnos = "SELECT hora_entrada, hora_salida FROM turnos WHERE id_turno = ?";
                        $stmt_turnos = $conexion->prepare($turnos);

                        if (!$stmt_turnos) {
                            die("Error al preparar la consulta de turnos: " . $conexion->error . "\n");
                        }
                        $stmt_turnos->bind_param("i", $id_turno);
                        if (!$stmt_turnos) {
                            die("Error al vincular datos en la consulta de turnos: " . $conexion->error . "\n");
                        }
                        if (!$stmt_turnos->execute()) {
                            die("Error al ejecutar la consulta de turnos: " . $conexion->error . "\n");
                        }

                        $stmt_turnos->bind_result($hora_entradaT, $hora_salidaT);
                        if ($stmt_turnos->fetch()) {
                            $stmt_turnos->close();

                            //! FORMATEAMOS LA HORA REAL A LA QUE ENTRA EL TRABAJADOR

                            $hora_entrada_timestamp = strtotime($hora_entrada);
                            $hora_entradaReal = date("H:i:s", $hora_entrada_timestamp);

                            //! CREAMOS EL RANGO MÁXIMO ACEPTADO DE LAS HORAS

                            $calcularhoraMaxima = strtotime('+5 minutes', strtotime($hora_entradaT));
                            $horaMaxima = date("H:i:s", $calcularhoraMaxima);

                            //! FORMATEAMOS LA HORA REAL A LA QUE SALE EL TRABAJADOR

                            $hora_salida_timestamp = strtotime($hora_salida);
                            $hora_salidaReal = date("H:i:s", $hora_salida_timestamp);

                            //! REALIZAMOS COMPARACIÓNES DE HORAS

                            if (strtotime($hora_entradaReal) > strtotime($horaMaxima)) {
                                $diferencia = date_diff(new DateTime($hora_entradaReal), new DateTime($hora_entradaT));
                                $comentarioAviso = "El trabajador ha entrado tarde " . $diferencia->format('%H:%I:%S');
                                $tipoAvisoEntrada = 1;

                                //! COMPROBAMOS SI YA HAY AVISO PARA ESTE EMPLEADO
                                $check_aviso = "SELECT tipo, dni, id_turnoP FROM aviso WHERE tipo = ? AND dni = ? AND id_turnoP = ?";
                                $query_chkAviso = $conexion->prepare($check_aviso);

                                if (!$query_chkAviso) {
                                    die("❌ Error al comprobar el aviso: " . $conexion->error . "\n");
                                }

                                $query_chkAviso->bind_param("isi", $tipoAvisoEntrada, $uid, $id_turnoP);

                                if (!$query_chkAviso) {
                                    die("❌ Error al vincular los parametros en comprobar el aviso: " . $conexion->error . "\n");
                                }

                                if (!$query_chkAviso->execute()) {
                                    die("❌ Error al ejecutar comprobar el aviso: " . $conexion->error . "\n");
                                }

                                $query_chkAviso->bind_result($chktipoAviso, $chkdniAviso, $chkid_turnoP);

                                if ($query_chkAviso->fetch()) {
                                    $query_chkAviso->close();
                                    print("❌ El trabajador ya ha recibido la alerta de entrada, imposible crear otra\n");
                                } else {
                                    $query_chkAviso->close();
                                    print("✅ El trabajador no ha recibido nungún aviso aún, siguiente paso...\n");

                                    //! CREAMOS E INSERTAMOS EL AVISO

                                    $aviso = "INSERT INTO aviso(tipo, comentario, dni, id_turnoP) VALUES (?,?,?,?)";
                                    $stmt_aviso = $conexion->prepare($aviso);
                                    if (!$stmt_aviso) {
                                        die("❌ Error al preparar el aviso: " . $conexion->error . "\n");
                                    }
                                    $stmt_aviso->bind_param("issi", $tipoAvisoEntrada, $comentarioAviso, $uid, $id_turnoP);
                                    if (!$stmt_aviso) {
                                        die("❌ Error al vincular los datos en la consulta de avisos: " . $conexion->error . "\n");
                                    }
                                    if (!$stmt_aviso->execute()) {
                                        die("❌ Error al insertar el aviso en la DB: " . $stmt_aviso->error . "\n");
                                    } else {
                                        print("📨 Aviso de entrada creado correctamente\n");
                                        $data = obtenerDatosParaMail($conexion, $uid);
                                        $datosComentarios = array(
                                            "fechaTurno" => $fecha,
                                            "hora_entradaReal" => $hora_entradaReal,
                                            "hora_entradaTrabajador" => $hora_entradaT,
                                            "diferenciaTiempo" => $diferencia,
                                        );
                                        $totalData = array_merge($data, $datosComentarios);
                                        $res = sendMail($totalData);
                                        print $res;

                                    }
                                    $stmt_aviso->close();
                                }
                            } else {
                                print("✅ " . $uid . " fichó correctamente\n");
                            }

                            //! COMPROBAMOS SI EL TRABAJADOR HA DESFICHADO PARA TENERLO EN CUENTA
                            //echo $hora_salidaReal . " " . $hora_salidaT;
                            if ($hora_salida !== null) {
                                if (strtotime($hora_salidaReal) < strtotime($hora_salidaT)) {
                                    $diferencia = date_diff(new DateTime($hora_salidaT), new DateTime($hora_salidaReal));
                                    $comentarioAviso = "El trabajador ha salido pronto " . $diferencia->format('%H:%I:%S');
                                    $tipoAvisoSalida = 5;

                                    //! COMPROBAMOS SI YA HAY AVISO PARA ESTE EMPLEADO
                                    $check_aviso = "SELECT tipo, dni, id_turnoP FROM aviso WHERE tipo = ? AND dni = ? AND id_turnoP = ?";
                                    $query_chkAviso = $conexion->prepare($check_aviso);

                                    if (!$query_chkAviso) {
                                        die("❌ Error al comprobar el aviso: " . $conexion->error . "\n");
                                    }

                                    $query_chkAviso->bind_param("isi", $tipoAvisoSalida, $uid, $id_turnoP);

                                    if (!$query_chkAviso) {
                                        die("❌ Error al vincular los parametros en comprobar el aviso: " . $conexion->error . "\n");
                                    }

                                    if (!$query_chkAviso->execute()) {
                                        die("❌ Error al ejecutar comprobar el aviso: " . $conexion->error . "\n");
                                    }

                                    $query_chkAviso->bind_result($chktipoAviso, $chkdniAviso, $chkid_turnoP);

                                    if ($query_chkAviso->fetch()) {
                                        $query_chkAviso->close();
                                        print("❌ El trabajador ya ha recibido la alerta de salida, imposible crear otra\n");
                                    } else {
                                        $query_chkAviso->close();

                                        //! AHORA INSERTAMOS EL AVISO
                                        $aviso = "INSERT INTO aviso(tipo, comentario, dni, id_turnoP) VALUES (?,?,?,?)";
                                        $stmt_aviso = $conexion->prepare($aviso);
                                        if (!$stmt_aviso) {
                                            die("❌ Error al preparar el aviso: " . $conexion->error . "\n");
                                        }
                                        $stmt_aviso->bind_param("issi", $tipoAvisoSalida, $comentarioAviso, $uid, $id_turnoP);
                                        if (!$stmt_aviso) {
                                            die("❌ Error al vincular los datos en la consulta de avisos: " . $conexion->error . "\n");
                                        }
                                        if (!$stmt_aviso->execute()) {
                                            die("❌ Error al insertar el aviso en la DB: " . $stmt_aviso->error . "\n");
                                        } else {
                                            print("📨 Aviso salida creado correctamente\n");
                                            $data = obtenerDatosParaMail($conexion, $uid);
                                            $datosComentarios = array(
                                                "fechaTurno" => $fecha,
                                                "hora_entradaReal" => $hora_salidaReal,
                                                "hora_entradaTrabajador" => $hora_salidaT,
                                                "diferenciaTiempo" => $diferencia,
                                            );
                                            $totalData = array_merge($data, $datosComentarios);
                                            $res = sendMail($totalData);
                                            print $res;
                                        }
                                        $stmt_aviso->close();
                                    }

                                } else {
                                    print("✅ El trabajador " . $uid . " salió a su hora\n");
                                }
                            } else {
                                print("⚠️ EL trabajador " . $uid . " no desfichó aún\n");
                            }

                        } else {
                            die("❌ No se encontraron datos en la tabla de turnos\n" . $conexion->error);
                        }
                    }
                } else {
                    echo "❌ $uid no tiene registro en la fecha $fecha\n";
                }

            } else {
                die("❌ Ejecucion: " . $conexion->error . "\n");
            }
            $stm_check->close();
        }
    } else {
        echo "❌ No hay datos que leer\n";
    }
}
$conexion->close();
?>