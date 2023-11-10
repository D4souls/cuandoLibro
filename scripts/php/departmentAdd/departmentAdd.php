<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $presupuesto = $_POST["presupuesto"];

    include("../seguridad/conexion.php");

    if ($conexion->connect_error) {
        die("[!] Conexión fallida: " . $conexion->connect_error);
    }

    try {
        // Comprobar que el usuario no esté ya agregado
        $query_comprobacion_user = "SELECT * FROM departamentos WHERE nombre=?";
        $resultado_comprobacion = $conexion->prepare($query_comprobacion_user);
        $resultado_comprobacion->bind_param("s", $nombre);
        $resultado_comprobacion->execute();

        if ($resultado_comprobacion->fetch()) {
            print("<h3>[!] Error: Ya hay un departamento igual</h3>\n<a href='../../../sites/departamentos.php#departament'>Cerrar ventana</a>");
        } else {
            $query_insert = "INSERT INTO departamentos (nombre, presupuesto) VALUES (?, ?)";
            $resultado_insert = $conexion->prepare($query_insert);
            $resultado_insert->bind_param("ss", $nombre, $presupuesto);

            if ($resultado_insert->execute()) {
                echo "<h3>[+] Departamento dado de alta correctamente!</h3>\n<a href='../../../sites/departamentos.php#departament'>Cerrar ventana</a>";
                exit();
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Manejar el error de duplicidad de clave primaria
        if ($e->getCode() == 1062) {
            print("<h3>[!] Error: El DNI ya está registrado</h3>\n<a href='../../../sites/departamentos.php#departament'>Cerrar ventana</a>");
        } else {
            // Otro tipo de error
            print("<h3>[!] Error: " . $e->getMessage() . "</h3>");
        }
    }
}
