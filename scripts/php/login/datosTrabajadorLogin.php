<?php
function obtenerDatosEmpleado($conexion, $userwebdni) {
    $datosEmpleado = array();
    
    $query = "SELECT e.dni, e.nombre AS 'nombre', e.apellido1, e.apellido2, c.nombre AS 'nombreCategoria', d.nombre AS 'nombreDepartamento', userweb.lastlogout AS 'lastlogin' FROM empleados e INNER JOIN categorias c ON c.id_categoria = e.n_categoria INNER JOIN departamentos d ON d.id_departamento = e.n_departamento INNER JOIN userweb ON userweb.dniusuarioweb = e.dni WHERE e.dni ='" . $userwebdni . "'";
    $query_ejecutar = $conexion->query($query);

    if ($query_ejecutar->num_rows > 0) {
        $row = $query_ejecutar->fetch_assoc();

        $datosEmpleado['dni'] = $row['dni'];
        $datosEmpleado['nombre'] = $row['nombre'];
        $datosEmpleado['apellido1'] = $row['apellido1'];
        $datosEmpleado['apellido2'] = $row['apellido2'];
        $datosEmpleado['categoria'] = $row['nombreCategoria'];
        $datosEmpleado['departamento'] = $row['nombreDepartamento'];
        $fecha = $row['lastlogin'];

        $datosEmpleado['lastlogin'] = date('d/m/Y H:i:s', strtotime($fecha));
    }

    return $datosEmpleado;
}
?>
