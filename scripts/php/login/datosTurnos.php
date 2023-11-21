<?php

function proximosTrunos($conexion, $userwebdni){
    $proximosturnos = array();

    $query = "SELECT tp.fecha, t.nombre FROM turnos_publicados tp INNER JOIN turnos t ON tp.id_turno = t.id_turno WHERE tp.dni = '$userwebdni'";
    $query_ejecutar = $conexion->query($query);

    if ($query_ejecutar->num_rows > 0) {
        while ($row = $query_ejecutar->fetch_assoc()) {
            $fecha = $row["fecha"];
            $nombre = $row["nombre"];
            
            // Puedes hacer lo que necesites con $fecha y $nombre aquí
            // Por ejemplo, podrías agregarlos a tu array $proximosturnos
            $proximosturnos[] = array(
                'fecha' => $fecha,
                'nombre' => $nombre
            );
        }
    }

    return $proximosturnos;
}
?>
