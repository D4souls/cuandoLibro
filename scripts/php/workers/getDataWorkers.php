<?php
function getDataWorkers($conexion)
{
    $query = "SELECT e.dni, e.nombre, e.apellido1, e.apellido2, e.n_categoria, e.n_departamento, c.nombre AS 'nombreCategoria', d.nombre AS 'nombreDepartamento' FROM empleados e 
    LEFT JOIN categorias c ON c.id_categoria = e.n_categoria
    LEFT JOIN departamentos d ON d.id_departamento = e.n_departamento";

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
    <h3>Hay $resultadoConsulta->num_rows departamentos en la base de datos</h3>
    <table class='tabla-datos'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Presupuesto</th>
        </tr>";

    while ($row = $resultadoConsulta->fetch_assoc()) {
        $datosEmpleados[] = $row;  // Almacena los datos en el nuevo array

        // Construye la tabla HTML como una cadena
        $tablaHtml .= "<tr class='datos' id='departamento_{$row["id_departamento"]}' onclick=\"window.location.href='../scripts/php/departmentEdit/departmentEdit.php?id_departamento={$row["id_departamento"]}'\">
            <td>" . $row['id_departamento'] . "</td>
            <td>" . $row['nombre'] . "</td>
            <td>" . $row['presupuesto'] . "€</td>

        </tr>";
    }

    $tablaHtml .= "</table>";

    $stm->close();

    // Devuelve la cadena de la tabla HTML
    return $tablaHtml;
}

function getDataCategory($conexion, $id_departamento, $nombre_departamento)
{
    $query = "SELECT * FROM categorias WHERE id_departamento = $id_departamento";

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
    <h3>Hay $resultadoConsulta->num_rows categorias en el departamento</h3>
    <table class='tabla-datos'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Sueldo base</th>
            <th>Sueldo plus</th>
        </tr>";

    while ($row = $resultadoConsulta->fetch_assoc()) {

        // Construye la tabla HTML como una cadena
        $tablaHtml .= "<tr class='datos' id='categoria_{$row["id_categoria"]}' onclick=\"window.location.href='../scripts/php/category/categoryEdit.php?id_categoria={$row["id_categoria"]}&id_departamento={$id_departamento}&nombre_departamento={$nombre_departamento}'\">
            <td>" . $row['id_categoria'] . "</td>
            <td>" . $row['nombre'] . "</td>
            <td>" . $row['sueldo_normal'] . "€/h</td>
            <td>" . $row['sueldo_plus'] . "€/h</td>
        </tr>";
    }

    $tablaHtml .= "</table>";

    $stm->close();

    // Devuelve la cadena de la tabla HTML
    return $tablaHtml;
}

function totalMoney($conexion) {
    $var_consulta = "SELECT * FROM departamentos";
    $var_resultado = $conexion->query($var_consulta);

    $data = array();

    if ($var_resultado->num_rows > 0) {
        while ($row = $var_resultado->fetch_assoc()) {
            $data[] = array(
                "id" => $row["id_departamento"],
                "nombre" => $row["nombre"],
                "dinero" => $row["presupuesto"],
            );
        }
    }

    return $data;
}

function totalWorkers($conexion) {
    $var_consulta = "SELECT COUNT(*) AS 'cantidad' FROM empleados";
    $var_resultado = $conexion->query($var_consulta);
    $data = $var_resultado->fetch_assoc();

    return $data['cantidad'];
}
