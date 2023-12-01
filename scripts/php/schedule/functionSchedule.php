<?php
function getSchedule($conexion)
{
    $var_consulta = "SELECT tp.id_turnoP AS 'idturnoP', d.nombre AS 'nombreDepartamento', c.nombre AS 'nombreCat', tp.fecha AS 'fecha', tp.hora_fichaje_entrada AS 'hfe', tp.hora_fichaje_salida AS 'hfs', tp.dni AS 'dni', t.nombre AS 'nombreTurno' FROM turnos_publicados tp
            INNER JOIN departamentos d ON tp.departamento = d.id_departamento
            INNER JOIN categorias c ON c.id_categoria = tp.categoria
            INNER JOIN turnos t ON t.id_turno = tp.id_turno;";
    $var_resultado = $conexion->query($var_consulta);
    $tablaHtml = "";
    if ($var_resultado->num_rows > 0) {
        $tablaHtml .= "
        <h3 class='text-lg font-bold'>Hay $var_resultado->num_rows turnos en la base de datos</h3>
        <table class='bg-white rounded-lg'>
        <tr class='bg-slate-100'>
            <th class=''>Departamento</th>
            <th>Categoria</th>
            <th>Fecha</th>
            <th>Trabajador</th>
            <th>Turno</th>
            <th>Estado</th>
        </tr>";

        while ($var_fila = $var_resultado->fetch_array()) {
            $fechaToSTR = strtotime($var_fila['fecha']);
            $fechaFormateada = date("d/m/Y", $fechaToSTR);
            $tablaHtml .= "
            <tr class='' id='idTurnoPublicado_{$var_fila["idturnoP"]}' onclick=\"window.location.href='../scripts/php/schedule/scheduleEdit.php?id_turnoP={$var_fila["idturnoP"]}'\">
                <td>{$var_fila['nombreDepartamento']}</td>
                <td>{$var_fila['nombreCat']}</td>
                <td>{$fechaFormateada}</td>
                <td>{$var_fila['dni']}</td>
                <td>{$var_fila['nombreTurno']}</td>";

                if (!$var_fila['hfe'] == null && $var_fila['hfs'] == null) {
                    $tablaHtml .= "<td>En proceso...</td>";
                } elseif ($var_fila['hfe'] == null && $var_fila['hfe'] == null) {
                    $tablaHtml .= "<td>Sin realizar</td>";
                } else {
                    $tablaHtml .= "<td class='truncate'>Completado</td>";
                }
            $tablaHtml .= "</tr>";
        }
        $tablaHtml .= "</table>";
    }

    $var_resultado->close();
    return $tablaHtml;
}
?>