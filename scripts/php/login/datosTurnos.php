<?php

function proximosTrunos($conexion, $userwebdni)
{
    $proximosturnos = array();

    $query = "SELECT tp.fecha, t.nombre FROM turnos_publicados tp LEFT JOIN turnos t ON tp.id_turno = t.id_turno WHERE tp.dni = '$userwebdni'";
    $query_ejecutar = $conexion->query($query);

    if ($query_ejecutar->num_rows > 0) {
        while ($row = $query_ejecutar->fetch_assoc()) {
            $fecha = $row["fecha"];
            $nombre = $row["nombre"];
            $proximosturnos[] = array(
                'fecha' => $fecha,
                'nombre' => $nombre
            );
        }
    }

    return $proximosturnos;
}

function todosTurnos($conexion, $userwebdni)
{
    $proximosturnos = array();

    $query = "SELECT tp.fecha, t.nombre, tp.hora_fichaje_entrada, tp.hora_fichaje_salida, t.hora_salida, t.hora_entrada FROM turnos_publicados tp LEFT JOIN turnos t ON tp.id_turno = t.id_turno WHERE tp.dni = '$userwebdni'";
    $query_ejecutar = $conexion->query($query);

    if ($query_ejecutar->num_rows > 0) {
        while ($row = $query_ejecutar->fetch_assoc()) {
            $fecha = $row["fecha"];
            $nombre = $row["nombre"];
            $hfe = $row["hora_fichaje_entrada"];
            $hfs = $row["hora_fichaje_salida"];
            $he = $row["hora_entrada"];
            $hs = $row["hora_salida"];


            $proximosturnos[] = array(
                'fecha' => $fecha,
                'nombre' => $nombre,
                'hfe' => $hfe,
                'hfs' => $hfs,
                'he' => $he,
                'hs' => $hs
            );
        }
    }

    return $proximosturnos;
}

?>