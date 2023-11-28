<?php
include("../conexion.php");

if (!$conexion) {
    die("Error en la conexión de la base de datos: " . $conexion->error);
} else {

    function getCurrentDate()
    {
        $date = date('Y-m-d');
        return $date;
    }

    function getTipoAviso($conexion, $name)
    {
        $id = "";
        $query = "SELECT id FROM tipoaviso WHERE nombre = ?";
        $stmt = $conexion->prepare($query);
        if (!$stmt) {
            die("Error al preparar la consulta" . $conexion->error);
        }
        $stmt->bind_param("s", $name);
        $stmt->execute();
        if (!$stmt) {
            die("Error al ejecutar la consulta" . $conexion->error);
        }

        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id);
            $stmt->fetch();
            $stmt->close();
            return $id;
        } else {
            $stmt->close();
            return ("No hay datos en la tabla tipoaviso");
        }
    }

    function getTurnos($conexion, $id)
    {
        $hora_entrada = "";
        $hora_salida = "";
        $query_horarios = "SELECT hora_salida, hora_entrada FROM turnos WHERE id_turno = ?";
        $stmt_horarios = $conexion->prepare($query_horarios);
        if (!$stmt_horarios) {
            die("Error al preparar la consulta" . $conexion->error);
        }
        $stmt_horarios->bind_param("i", $id);
        $stmt_horarios->execute();
        if (!$stmt_horarios) {
            die("Error al ejecutar la consulta" . $conexion->error);
        }

        $stmt_horarios->store_result();
        if ($stmt_horarios->num_rows > 0) {
            $stmt_horarios->bind_result($hora_salida, $hora_entrada);
            $stmt_horarios->fetch();
            $stmt_horarios->close();
            return array('hora_entrada' => $hora_entrada, 'hora_salida' => $hora_salida);
        } else {
            $stmt_horarios->close();
            print("No hay datos en la tabla turnos");
        }
    }


    //? Query fichajes con gestión de errores
    $query_ficahje = "SELECT id_turnoP, fecha, hora_fichaje_entrada, hora_fichaje_salida, dni FROM turnos_publicados WHERE fecha = ?";
    $stmt_fichaje = $conexion->prepare($query_ficahje);
    if (!$stmt_fichaje) {
        die("Error al preparar la consulta" . $conexion->error);
    }
    $date = getCurrentDate();
    $stmt_fichaje->bind_param("s", $date);
    $stmt_fichaje->execute();
    if (!$stmt_fichaje) {
        die("Error al ejecutar la consulta" . $conexion->error);
    }
    $stmt_fichaje->store_result();
    if ($stmt_fichaje->num_rows > 0) {
        $stmt_fichaje->bind_result($idTurnoP,$fecha, $hfe, $hfs, $dniTurnoP);

        if($hfe == null && $hfs == null){
            $query_falta = "INSERT INTO aviso (tipo, dni, turno_P) VALUES ?, ?, ?";
            $query_falta = $conexion->prepare($query_falta);
            if(!$query_falta){
                die("No se pudo preparar la consulta: ".$conexion->error);
            }
            
        }
    } else {
        print("No hay registro para esta fecha");
    }
    $conexion->close();
}
?>