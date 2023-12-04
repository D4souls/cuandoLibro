<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_REQUEST["nombre"];
    $presupuesto = $_REQUEST["presupuesto"];

    include("../seguridad/conexion.php");

    if ($conexion->connect_error) {
        throw new Exception("Error al conectar con la base de datos: " . $conexion->error);
    }

    try {
        // Comprobar que el usuario no esté ya agregado
        $query_comprobacion_user = "SELECT * FROM departamentos WHERE nombre=?";
        $resultado_comprobacion = $conexion->prepare($query_comprobacion_user);

        if (!$resultado_comprobacion) {
            $mensaje = "Error al preparar la consulta de comprobación de depart.";
            $response = array('success' => false, 'message' => $mensaje);
            echo json_encode($response);
        }

        $resultado_comprobacion->bind_param("s", $nombre);

        if (!$resultado_comprobacion) {
            $mensaje = "Error al vincular parametros en la consulta de comprobación de depart.";
            $response = array('success' => false, 'message' => $mensaje);
            echo json_encode($response);
        }

        $resultado_comprobacion->execute();

        if (!$resultado_comprobacion) {
            $mensaje = "Error al ejecutar consulta de comprobación de depart.";
            $response = array('success' => false, 'message' => $mensaje);
            echo json_encode($response);
        }

        if ($resultado_comprobacion->fetch()) {
            $resultado_comprobacion->close();
            $mensaje = "Ya hay un departamento con el mismo nombre";
            $response = array('success' => false, 'message' => $mensaje);
            echo json_encode($response);
        } else {
            $query_insert = "INSERT INTO departamentos (nombre, presupuesto) VALUES (?, ?)";

            $resultado_insert = $conexion->prepare($query_insert);

            if (!$resultado_comprobacion) {
                $mensaje = "Error al preparar la consulta para insertar depart.";
                $response = array('success' => false, 'message' => $mensaje);
                echo json_encode($response);
            }

            $resultado_insert->bind_param("ss", $nombre, $presupuesto);

            if (!$resultado_comprobacion) {
                $mensaje = "Error al vincular parametros de la consulta para insertar depart.";
                $response = array('success' => false, 'message' => $mensaje);
                echo json_encode($response);
            }

            if ($resultado_insert->execute()) {
                $resultado_insert->close();
                $mensaje = "Departamento creado con éxito.";
                $response = array('success' => true, 'message' => $mensaje);
                echo json_encode($response);
                exit();
            }
        }
    } catch (mysqli_sql_exception $e) {
        $response = array('success' => false, 'message' => $e);
        echo json_encode($response);
    } finally {
        if($conexion){
            $conexion->close();
        }
    }
}
