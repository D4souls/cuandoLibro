<?php
function getSchedule($conexion)
{   
    if(!$conexion){
        throw new Exception("Error en la conexión de la base de datos: " .$conexion->error);
    }
    try{

        $var_consulta = "SELECT tp.id_turnoP AS 'idturnoP', d.nombre AS 'nombreDepartamento', c.nombre AS 'nombreCat', tp.fecha AS 'fecha', tp.hora_fichaje_entrada AS 'hfe', tp.hora_fichaje_salida AS 'hfs', tp.dni AS 'dni', t.nombre AS 'nombreTurno' FROM turnos_publicados tp
                INNER JOIN departamentos d ON tp.departamento = d.id_departamento
                INNER JOIN categorias c ON c.id_categoria = tp.categoria
                INNER JOIN turnos t ON t.id_turno = tp.id_turno;";
        $var_resultado = $conexion->query($var_consulta);
        $tablaHtml = "";
        if ($var_resultado->num_rows > 0) {
            if($var_resultado->num_rows == 1){
                $tablaHtml.= "<h3 class='text-lg font-bold'>Hay 1 turno en la base de datos</h3>";
            } else {
                $tablaHtml.= "
                <h3 class='text-lg font-bold'>Hay {$var_resultado->num_rows} turnos en la base de datos</h3>
                ";
            }
            $tablaHtml .= "
            <table class='tabla-datos'>
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
    
                if($var_fila['hfe'] == null){
                    $tablaHtml .= "<tr class='datos' id='idTurnoPublicado_{$var_fila["idturnoP"]}' onclick=\"window.location.href='../scripts/php/schedule/scheduleEdit.php?id_turnoP={$var_fila["idturnoP"]}'\">";
                } else {
                    $tablaHtml .= "<tr class='datos'>";
                }
    
                $tablaHtml .= "
                
                    <td>{$var_fila['nombreDepartamento']}</td>
                    <td>{$var_fila['nombreCat']}</td>
                    <td>{$fechaFormateada}</td>
                    <td>{$var_fila['dni']}</td>
                    <td>{$var_fila['nombreTurno']}</td>";
    
                    if (!$var_fila['hfe'] == null && $var_fila['hfs'] == null) {
                        $tablaHtml .= "<td>En proceso...</td>";
                    } elseif ($var_fila['hfe'] == null && $var_fila['hfe'] == null) {
                        $tablaHtml .= "<td class='text-red-500 hover:text-white'>Sin realizar</td>";
                    } else {
                        $tablaHtml .= "<td class='text-green-500 hover:text-white'>Completado</td>";
                    }
                $tablaHtml .= "</tr>";
            }
            $tablaHtml .= "</table>";
        } else {
            $tablaHtml .= "<h3 class='text'>No hay turnos publicados...</h3>";
        }
    
        return $tablaHtml;
    } catch (mysqli_sql_exception $e) {
        die("Error al ejecutar la functionSchedule.php: ".$e->getMessage());
    } finally{
        $var_resultado->close();
    }
}
?>