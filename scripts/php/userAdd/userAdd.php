<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = $_POST["apellido2"];
    $iban = $_POST["iban"];
    $mail = $_POST["mail"];
    $n_categoria = $_POST["n_categoria"];
    $n_departamento = $_POST["n_departamento"];

    // Generando IBAN aleatorio
    // include("generadorIBAN.php");
    // $numeroPaises = array(1, 2, 3, 4);
    // $indiceAleatorio = array_rand($numeroPaises);
    // $numeroAleatorio = $numeroPaises[$indiceAleatorio];
    // $iban = generadorIBAN($numeroAleatorio);

    include("../seguridad/conexion.php");

    if ($conexion->connect_error) {
        die("[!] Conexión fallida: " . $conexion->connect_error);
    }

    try {
        // Comprobar que el usuario no esté ya agregado
        $query_comprobacion_user = "SELECT * FROM empleados WHERE dni=?";
        $resultado_comprobacion = $conexion->prepare($query_comprobacion_user);
        $resultado_comprobacion->bind_param("s", $dni);
        $resultado_comprobacion->execute();

        if ($resultado_comprobacion->fetch()) {
            $mensaje = "Ya hay un usuario con el mismo DNI";
            $response = array('success' => false, 'message' => $mensaje);
            echo json_encode($response);
        } else {
            $query_insert = "INSERT INTO empleados (dni, nombre, apellido1, apellido2, iban, mail, n_categoria, n_departamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $resultado_insert = $conexion->prepare($query_insert);
            $resultado_insert->bind_param("ssssssss", $dni, $nombre, $apellido1, $apellido2, $iban, $mail, $n_categoria, $n_departamento);

            if ($resultado_insert->execute()) {
                $mensaje = "Usuario dado de alta!";
                $response = array('success' => true, 'message' => $mensaje);
                echo json_encode($response);
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Manejar el error de duplicidad de clave primaria
        if ($e->getCode() == 1062) {
            $mensaje = "Ya hay un usuario con el mismo DNI";
            $response = array('success' => false, 'message' => $mensaje);
            echo json_encode($response);
        } else {
            // Otro tipo de error
            $response = array('success' => false, 'message' => $e->getMessage());
            echo json_encode($response);
        }
    }
}
