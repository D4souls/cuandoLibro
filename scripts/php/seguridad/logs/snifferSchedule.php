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
            $conteo++;
            echo "\n=========== $conteo ===========\n";

            //? Comporbación del turno publicado
            $check = "SELECT fecha, hora_fichaje_entrada, hora_fichaje_salida FROM turnos_publicados WHERE dni=? AND fecha = ?";
            $stm_check = $conexion->prepare($check);
            if ($stm_check) {
                echo "✅ Preparación\n";
            } else {
                die("❌ Preparacion: " . $conexion->error);
            }
            $stm_check->bind_param("ss", $uid, $fecha);

            if ($stm_check->execute()) {
                $stm_check->store_result();
                
                if ($stm_check->num_rows > 0) { //? Si no devuelve una fila no hay registro
                    $stm_check->bind_result($fecha_existente, $hfe, $hfs);
                    $stm_check->fetch();
                    echo "✅ Ejecucion\n";

                    if ($hfe !== null && $hfs !== null) {
                        echo "❌ $uid ya tiene registro\n";
                        continue;
                    } else {
                        echo "✅ No hay registro previo para $uid. Se realizará la actualización.\n";
                        // Actualizamos los campos
                        $update = 'UPDATE turnos_publicados SET hora_fichaje_entrada = ?, hora_fichaje_salida = ? WHERE dni=? AND fecha=?';
                        $stmt = $conexion->prepare($update);
                        $stmt->bind_param('ssss', $hora_entrada, $hora_salida, $uid, $fecha);

                        if ($stmt->execute()) {
                            echo "✅ Actualización exitosa";
                        } else {
                            echo "❌ Error en la actualización" . $conexion->error;
                        }
                    }
                } else {
                    echo "❌ $uid no tiene registro en la fecha $fecha\n";
                }

            } else {
                die("❌ Ejecucion: " . $conexion->error);
            }
        }
    } else {
        echo "❌ No hay datos que leer";
    }
}
$conexion->close();
?>