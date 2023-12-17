<?php
include("../seguridad/conexion.php");

// Verifica la existencia de los parámetros requeridos
if (isset($_REQUEST["nombre"], $_REQUEST["apellido1"], $_REQUEST["apellido2"], $_REQUEST["dni"], $_REQUEST['mail'])) {

    if (isset($_REQUEST["userpassword"]) && $_REQUEST['userpassword'] !== "") {
        // Hash de la contraseña
        $hashed_password = hash("sha256", $_REQUEST["userpassword"]);
        $timestamp = date("Y-m-d H:i:s");

        // Prepara la consulta para actualizar los datos de empleados
        $query_modificar = "UPDATE empleados SET nombre = ?, apellido1 = ?, apellido2 = ?, mail = ? WHERE dni = ?";
        $stmt = $conexion->prepare($query_modificar);

        // Prepara la consulta para actualizar la contraseña de userweb
        $query_modificarPassword = "UPDATE userweb SET userpassword = ?, lastchangepassword = ? WHERE dniusuarioweb = ?";
        $stmt2 = $conexion->prepare($query_modificarPassword);

        if ($stmt && $stmt2) {

            // Asigna los parámetros
            $stmt->bind_param("sssss", $_REQUEST["nombre"], $_REQUEST["apellido1"], $_REQUEST["apellido2"], $_REQUEST['mail'], $_REQUEST["dni"]);
            // Asigna los parámetros
            $stmt2->bind_param("sss", $hashed_password, $timestamp, $_REQUEST["dni"]);

            // Ejecuta la consulta
            $stmt->execute();
            // Ejecuta la consulta
            $stmt2->execute();

            // Cierra la consulta preparada
            $stmt->close();
            // Cierra la consulta preparada
            $stmt2->close();

            $mensaje = "Datos y contraseña actualizados";
            $response = array('success' => true, 'message' => $mensaje);
            echo json_encode($response);
        } else {
            $mensaje = "Error al actualizar la contraseña";
            $response = array('success' => false, 'message' => $mensaje . " " . $conexion->error);
            echo json_encode($response);
        }
    } else {
        // Prepara la consulta para actualizar los datos de empleados
        $query_modificar = "UPDATE empleados SET nombre = ?, apellido1 = ?, apellido2 = ?, mail = ? WHERE dni = ?";
        $stmt = $conexion->prepare($query_modificar);

        if ($stmt) {
            // Asigna los parámetros
            $stmt->bind_param("sssss", $_REQUEST["nombre"], $_REQUEST["apellido1"], $_REQUEST["apellido2"], $_REQUEST['mail'], $_REQUEST["dni"]);

            // Ejecuta la consulta
            $stmt->execute();

            // Cierra la consulta preparada
            $stmt->close();

            $mensaje = "Datos actualizados correctamente";
            $response = array('success' => true, 'message' => $mensaje);
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => $conexion->error);
            echo json_encode($response);
        }
    }
} else {
    $mensaje = "Faltan datos por enviar";
    $response = array('success' => false, 'message' => $mensaje);
    echo json_encode($response);
}
$conexion->close();
?>