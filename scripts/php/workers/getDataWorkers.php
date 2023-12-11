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
    $tablaHtml = "";

    if ($resultadoConsulta->num_rows > 0) {
        if ($resultadoConsulta->num_rows == 1) {
            $tablaHtml .= "<h3>Hay 1 empleado dado de alta</h3>";
        } else {
            $tablaHtml .= "<h3>Hay " . $resultadoConsulta->num_rows . " empleados dados de alta</h3>";
        }

        $tablaHtml .= "
        <table class='tabla-datos'>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>1º Apellido</th>
                <th>2º Apellido</th>
                <th>Departamento</th>
                <th>Categoría</th>
            </tr>";

        while ($row = $resultadoConsulta->fetch_assoc()) {
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
    } else {
        $tablaHtml .= "<h2 class='text'>No hay ningún empleado dado de alta...</h2>";
    }

    $stm->close();

    return $tablaHtml;
}



function getDataDeraptment($conexion)
{
    $query = "SELECT id_departamento, nombre, presupuesto, gastos FROM departamentos";

    $stm = $conexion->prepare($query);
    if (!$stm) {
        die("Error de preparación de la consulta: " . $conexion->error);
    }
    $stm->execute();
    if ($stm->error) {
        die("Error al ejecutar la consulta: " . $stm->error);
    }

    $resultadoConsulta = $stm->get_result();
    $tablaHtml = "";

    if ($resultadoConsulta->num_rows > 0) {

        $plural = $resultadoConsulta->num_rows == 1 ? "" : "s";

        $tablaHtml = "
        <h3>Hay $resultadoConsulta->num_rows departamento{$plural} dados de alta</h3>
        <table class='tabla-datos'>
            <tr>
                <th>Nombre</th>
                <th>Presupuesto total</th>
                <th>Gastos</th>
                <th>Presupuesto restante</th>
            </tr>";

        while ($row = $resultadoConsulta->fetch_assoc()) {

            $tablaHtml .= "<tr class='datos hover:text-white hover hover:bg-[#41cf1d]' id='departamento_{$row["id_departamento"]}' onclick=\"window.location.href='../scripts/php/departmentEdit/departmentEdit.php?id_departamento={$row["id_departamento"]}'\">
                <td>" . $row['nombre'] . "</td>
                <td>" . number_format($row['presupuesto'], 2, ',', '.') . "€</td>
                <td>" . number_format($row['gastos'], 2, ',', '.') ."€</td>
                <td>" . number_format(($row['presupuesto'] - $row['gastos']), 2, ',', '.')."€</td>

            </tr>";
        }

        $tablaHtml .= "</table>";

    } else {
        $tablaHtml .= "<h3>No hay departamentos dados de alta...</h3>";
    }

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

    $tablaHtml = "";
    if ($resultadoConsulta->num_rows > 0) {

        $plural = $resultadoConsulta->num_rows == 1 ? "" : "s";

        $tablaHtml = "
        <h3>Hay $resultadoConsulta->num_rows categoria{$plural} activa.</h3>
        <table class='tabla-datos'>
            <tr>
                <!-- <th>ID</th> -->
                <th>Nombre</th>
                <th>Sueldo base</th>
                <th>Sueldo plus</th>
            </tr>";

        while ($row = $resultadoConsulta->fetch_assoc()) {

            // Construye la tabla HTML como una cadena
            $tablaHtml .= "<tr class='datos' id='categoria_{$row["id_categoria"]}' onclick=\"window.location.href='../scripts/php/category/categoryEdit.php?id_categoria={$row["id_categoria"]}&id_departamento={$id_departamento}&nombre_departamento={$nombre_departamento}'\">
                <!-- <td>" . $row['id_categoria'] . "</td> -->
                <td>" . $row['nombre'] . "</td>
                <td>" . number_format($row['sueldo_normal'], 2, ',', '.') . "€/h</td>
                <td>" . number_format($row['sueldo_plus'], 2, ',', '.') . "€/h</td>
            </tr>";
        }

        $tablaHtml .= "</table>";
        $tablaHtml .= "<center>
            <a href='../scripts/php/departmentEdit/departmentEdit.php?id_departamento=$id_departamento'>
                Volver atrás
            </a>
        </center>";
    } else {
        echo "<h3>No hay categorías aún...</h3>";
    }


    $stm->close();

    // Devuelve la cadena de la tabla HTML
    return $tablaHtml;
}

function totalMoney($conexion)
{
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

function totalWorkers($conexion)
{
    $var_consulta = "SELECT COUNT(*) AS 'cantidad' FROM empleados";
    $var_resultado = $conexion->query($var_consulta);
    $data = $var_resultado->fetch_assoc();

    return $data['cantidad'];
}
