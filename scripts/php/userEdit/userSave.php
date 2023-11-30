<?php
include("../seguridad/conexion.php");

// Validar y escapar los datos
$nombre = mysqli_real_escape_string($conexion, $_REQUEST["nombre"]);
$apellido1 = mysqli_real_escape_string($conexion, $_REQUEST["apellido1"]);
$apellido2 = mysqli_real_escape_string($conexion, $_REQUEST["apellido2"]);
$IBAN = mysqli_real_escape_string($conexion, $_REQUEST["IBAN"]);
$mail = mysqli_real_escape_string($conexion, $_REQUEST["mail"]);
$n_departamento = mysqli_real_escape_string($conexion, $_REQUEST["n_departamento"]);
$n_categoria = mysqli_real_escape_string($conexion, $_REQUEST["n_categoria"]);
$dni = mysqli_real_escape_string($conexion, $_REQUEST["dni"]);

$query_modificar = "UPDATE empleados SET nombre = ?, apellido1 = ?, apellido2 = ?, IBAN = ?, mail = ?, n_departamento = ?, n_categoria = ? WHERE dni = ?";
$stmt = $conexion->prepare($query_modificar);

if ($stmt) {
    $stmt->bind_param("ssssssss", $nombre, $apellido1, $apellido2, $IBAN, $mail ,$n_departamento, $n_categoria, $dni);
    $stmt->execute();
    $stmt->close();

    $response = array('success' => true, 'message' => 'Datos actualizados correctamente');
    echo json_encode($response);
} else {
    $stmtMessage = "Error en la preparación de la consulta.";
    $response = array('success' => false, 'message' => $stmtMessage);
    echo json_encode($response);
    exit;
}

// Cierra la conexión
$conexion->close();
