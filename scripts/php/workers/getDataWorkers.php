<?php
function getDataWorkers($conexion)
{
    $query = "SELECT e.dni, e.nombre, e.apellido1, e.apellido2, e.n_categoria, e.n_departamento, c.nombre AS 'nombreCategoria', d.nombre AS 'nombreDepartamento' FROM empleados e 
    INNER JOIN categorias c ON c.id_categoria = e.n_categoria
    INNER JOIN departamentos d ON d.id_departamento = e.n_departamento";

    $stm = $conexion->prepare($query);
    if (!$stm) {
        die("Error de preparación de la consulta: " . $conexion->error);
    }
    $stm->execute();
    if ($stm->error) {
        die("Error al ejecutar la consulta: " . $stm->error);
    }

    $resultadoConsulta = $stm->get_result();
    $tablaHtml = "
    <h3>Hay $resultadoConsulta->num_rows trabajadores en la base de datos</h3>
    <table class='tabla-datos'>
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellido1</th>
            <th>Apellido2</th>
            <th>Departamento</th>
            <th>Categoría</th>
        </tr>";

    while ($row = $resultadoConsulta->fetch_assoc()) {
        $datosEmpleados[] = $row;
        $dni_oculto = str_repeat("*", 4) . substr($row["dni"], 4);
        $tablaHtml .= "<tr class='datos' id='trabajador_{$row["dni"]}' onclick=\"window.location.href='../scripts/php/userEdit/userEdit.php?dni={$row["dni"]}'\">
        <td>" . $dni_oculto . "</td>
        <td>" . $row['nombre'] . "</td>
        <td>" . $row['apellido1'] . "</td>
        <td>" . $row['apellido2'] . "</td>
        <td>" . $row['nombreDepartamento'] . "</td>
        <td>" . $row['nombreCategoria'] . "</td>
        </tr>";
    }

    $tablaHtml .= "</table>";

    $stm->close();

    return $tablaHtml;
}


function getDataDeraptment($conexion)
{
    $query = "SELECT * FROM departamentos";

    $stm = $conexion->prepare($query);
    if (!$stm) {
        die("Error de preparación de la consulta: " . $conexion->error);
    }
    $stm->execute();
    if ($stm->error) {
        die("Error al ejecutar la consulta: " . $stm->error);
    }

    $resultadoConsulta = $stm->get_result();
    $tablaHtml = "
    <h3>Hay $resultadoConsulta->num_rows trabajadores en la base de datos</h3>
    <table class='tabla-datos'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Presupuesto</th>
        </tr>";

    while ($row = $resultadoConsulta->fetch_assoc()) {
        $datosEmpleados[] = $row;  // Almacena los datos en el nuevo array

        // Construye la tabla HTML como una cadena
        $tablaHtml .= "<tr class='datos' id='departamento_{$row["id_departamento"]}' onclick=\"window.location.href='#trabajadoresEdit?id_departamento={$row["id_departamento"]}'\">
            <td>" . $row['id_departamento'] . "</td>
            <td>" . $row['nombre'] . "</td>
            <td>" . $row['presupuesto'] . "</td>
        </tr>";
    }

    $tablaHtml .= "</table>";

    $stm->close();

    // Devuelve la cadena de la tabla HTML
    return $tablaHtml;
}

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
        <h3>Hay $var_resultado->num_rows turnos en la base de datos</h3>
        <table class='tabla-datos'>
        <tr>
        <th>Departamento</th>
        <th>Categoria</th>
        <th>Fecha</th>
        <th>Trabajador</th>
        <th>Turno</th>
        </tr>";

        while ($var_fila = $var_resultado->fetch_array()) {
            $tablaHtml .= "
            <tr class='datos' id='idTurnoPublicado_{$var_fila["idturnoP"]}' onclick=\"window.location.href='../scripts/php/schedule/scheduleEdit.php?id_turnoP={$var_fila["idturnoP"]}'\">
            <td>{$var_fila['nombreDepartamento']}</td>
            <td>{$var_fila['nombreCat']}</td>
            <td>{$var_fila['fecha']}</td>
            <td>{$var_fila['dni']}</td>
            <td>{$var_fila['nombreTurno']}</td>
            </tr>";
        }
        $tablaHtml .= "</table>";
    }

    $var_resultado->close();
    return $tablaHtml;
}
