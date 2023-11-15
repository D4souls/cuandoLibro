<?php
// include("../seguridad/conexion.php");

function obtenerDatosEmpleado($conexion, $dniWeb)
{
    $array = array(
        "dni" => "",
        "nombre" => "",
        "apellidos" => "",
        "nombreCat" => "",
        "nombreDep" => "",
        "lastlogout" => "",
    );

    $dni = "";
    $nombre = "";
    $apellidos = "";
    $nombreCat = "";
    $nombreDep = "";
    $lastlogout = "";

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    } else {
        $query = "SELECT e.dni, e.nombre, CONCAT(e.apellido1,' ',e.apellido2) AS 'apellidos', c.nombre, d.nombre, u.lastlogout FROM empleados e INNER JOIN departamentos d ON 
        d.id_departamento = e.n_departamento
        INNER JOIN categorias c ON c.id_categoria = e.n_categoria
        INNER JOIN userweb u ON e.dni = u.dniusuarioweb
        WHERE e.dni = ?";
        
        $stm = $conexion->prepare($query);
        if (!$stm) {
            die("Error de preparación de la consulta: " . $conexion->error);
        }

        $stm->bind_param("s", $dniWeb);
        $stm->execute();
        if ($stm->error) {
            die("Error al ejecutar la consulta: " . $stm->error);
        }

        $stm->store_result();
        $stm->bind_result(
            $dni,
            $nombre,
            $apellidos,
            $nombreCat,
            $nombreDep,
            $lastlogout
        );

        $stm->fetch();
        $array["dni"] = $dni;
        $array["nombre"] = $nombre;
        $array["apellidos"] = $apellidos;
        $array["nombreCat"] = $nombreCat;
        $array["nombreDep"] = $nombreDep;
        $array["lastlogout"] = $lastlogout;

        $stm->close();
    }

    return $array;
}

function obtenerHorarios($conexion, $dniWeb)
{

    $array = array(
        "fechaTurno" => "",
        "turno"=> "",
    );

    $fecha = "";
    $nombreT = "";

    $query = "SELECT tp.fecha, t.nombre FROM turnos_publicados tp INNER JOIN turnos t ON t.id_turno = tp.id_turno WHERE tp.dni = ?";
    $stm = $conexion->prepare($query);
    if (!$stm) {
        die("Error de preparación de la consulta: " . $conexion->error);
    }

    $stm->bind_param("s", $dniWeb);
    $stm->execute();
    if ($stm->error) {
        die("Error al ejecutar la consulta: " . $stm->error);
    }

    $stm->store_result();
    $stm->bind_result($fecha, $nombreT);

    $stm->fetch();
    $array["fechaTurno"] = $fecha;
    $array["turno"] = $nombreT;

    $stm->close();

    return $array;
}
// $datosUserLogin = obtenerDatosEmpleado($conexion, '12774250G');
// $datosHorarios = obtenerHorarios($conexion, '12774250G');

// $result = array_merge($datosUserLogin, $datosHorarios);
// print_r($result);
