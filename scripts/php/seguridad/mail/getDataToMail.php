<?php
// include("../conexion.php");

function obtenerDatosParaMail($conexion, $dni)
{

    $nombreToMail = "";
    $ap1ToMail = "";
    $ap2ToMail = "";
    $mailToSend = "";

    $query = "SELECT nombre, apellido1, apellido2, mail FROM empleados WHERE dni = ?";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception("❌ Error al obtener los datos del empleado para enviar el mail");
    }

    $stmt->bind_param("s", $dni);

    if (!$stmt) {
        throw new Exception("❌ Error al insertar datos en la query: " . $conexion->error);
    }

    if ($stmt->execute()) {
        $stmt->bind_result($nombreToMail, $ap1ToMail, $ap2ToMail, $mailToSend);

        if ($stmt->fetch()) {
            $stmt->close();
            $data = array(
                "nombre" => $nombreToMail,
                "apellido1" => $ap1ToMail,
                "apellido2" => $ap2ToMail,
                "mail" => $mailToSend
            );
            if ($mailToSend == null) {
                return "⚠️ " . $nombreToMail . " no tiene correo electrónico";
            }
            return $data;
        } else {
            throw new Exception("❌ Usuario no encontrado en la db");
        }
    } else {
        throw new Exception("❌ Error al ejecutar al consulta: " . $conexion->error);
    }
}
// $data = obtenerDatosParaMail($conexion, "72210584Z");
// print_r($data)

?>