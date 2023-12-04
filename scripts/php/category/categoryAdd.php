<?php
include("../seguridad/conexion.php");

if ($conexion->connect_error) {
    die("[!] Conexión fallida: " . $conexion->connect_error);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"];
        $sueldo_normal = $_POST["sueldo_normal"];
        $sueldo_plus = $_POST["sueldo_plus"];
        $departamento_id = $_POST["n_departamento"];

        
        try {
            
            //!COMPROBACIÓN DE LA CATEGORÍA

            $query_category = "SELECT nombre FROM categorias WHERE nombre = ? AND id_departamento = ?";

            $resultado_comprobacion = $conexion->prepare($query_category);

            if (!$resultado_comprobacion) {
                $mensaje = "Error al preparar la consulta de comprobación de categoría";
                $response = array('success' => false, 'message' => $mensaje);
                echo json_encode($response);
            }

            $resultado_comprobacion->bind_param("si", $nombre, $departamento_id);

            if (!$resultado_comprobacion) {
                $mensaje = "Error al vincular parametros de la consulta de comprobación de categoría";
                $response = array('success' => false, 'message' => $mensaje);
                echo json_encode($response);
            }

            $resultado_comprobacion->execute();

            if (!$resultado_comprobacion) {
                $mensaje = "Error al ejecutar la consulta de comprobación de categoría";
                $response = array('success' => false, 'message' => $mensaje);
                echo json_encode($response);
            }

            if ($resultado_comprobacion->fetch()) {

                $mensaje = "Ya hay una categoría con el mismo nombre.";
                $response = array('success' => false, 'message' => $mensaje);
                echo json_encode($response);
            } else {

                //!CREACIÓN DE LA CATEGORÍA

                $query_insert = "INSERT INTO categorias (id_departamento, nombre, sueldo_normal, sueldo_plus) VALUES (?, ?, ?, ?)";
                
                $resultado_insert = $conexion->prepare($query_insert);

                if (!$resultado_insert) {
                    $mensaje = "Error al preparar la consulta de creación de categoría";
                    $response = array('success' => false, 'message' => $mensaje);
                    echo json_encode($response);
                }

                $resultado_insert->bind_param("isii", $departamento_id, $nombre, $sueldo_normal, $sueldo_plus);

                if (!$resultado_insert) {
                    $mensaje = "Error al vincular parametros de la consulta de creación de categoría";
                    $response = array('success' => false, 'message' => $mensaje);
                    echo json_encode($response);
                }
    
                $resultado_insert->execute();

                if (!$resultado_insert) {
                    $mensaje = "Error al ejecutar la consulta de creación de categoría";
                    $response = array('success' => false, 'message' => $mensaje);
                    echo json_encode($response);
                } else {
                    $mensaje = "Categoría creada correctamente";
                    $response = array('success' => true, 'message' => $mensaje);
                    echo json_encode($response);
                }

            }

        } catch (Exception $e) {
            $response = array('success' => false, 'message' => $e);
            echo json_encode($response);
        } finally {
            if ($conexion) {
                $conexion->close();
            }
        }

    }
}


?>