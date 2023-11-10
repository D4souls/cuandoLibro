<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = $_POST["apellido2"];
    $iban = $_POST["iban"];
    $n_cat = $_POST["n_cat"];
    $n_departamento = $_POST["n_departamento"];

    // Generando IBAN aleatorio
    include("scripts/php/generadorIBAN.php");
    $numeroPaises = array(1, 2, 3, 4);
    $indiceAleatorio = array_rand($numeroPaises);
    $numeroAleatorio = $numeroPaises[$indiceAleatorio];
    $iban = generadorIBAN($numeroAleatorio);

    include("scripts/php/conexion.php");

    if ($conexion->connect_error) {
        die("[!] Conexión fallida: " . $conexion->connect_error);
    }

    // Comprobar que el usuario no esté ya agregado
    $query_comprobacion_user = "SELECT * FROM empleados WHERE dni=?";
    $resultado_comprobacion = $conexion->prepare($query_comprobacion_user);
    $resultado_comprobacion->bind_param("s", $dni);
    $resultado_comprobacion->execute();

    if ($resultado_comprobacion->fetch()) {
        print("
        <h3>[!] Error: Ya hay un trabajador registrado con estos datos</h3>
        <a href='../dashboard.php#userAdd'>Volver atrás</a>
        ");
    } else {
        $query_insert = "INSERT INTO empleados (dni, nombre, apellido1, apellido2, iban, n_categoria, n_departamento) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $resultado_insert = $conexion->prepare($query_insert);
        $resultado_insert->bind_param("sssssss", $dni, $nombre, $apellido1, $apellido2, $iban, $n_cat, $n_departamento);

        if ($resultado_insert->execute()) {
            print("
            <h3>[+] Trabajador dado de alta correctamente!</h3>
            <a href='../dashboard.php#trabajadores'>Volver atrás</a>
            ");
        }

    }

} else {
    print("[!] Error: No se han recibido datos.");
}
?>