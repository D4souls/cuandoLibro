<?php
include("../seguridad/conexion.php");
if (!$conexion) {
    throw new Exception("Error al conectar con la DB: " . $conexion->error);
}

if (isset($_REQUEST["horario"]) && isset( $_REQUEST["n_categoria"]) && isset( $_REQUEST["n_departamento"]) && isset($_REQUEST["fecha"]) && isset($_REQUEST["cantidad"])) {
    $horario = mysqli_real_escape_string($conexion, $_REQUEST['horario']);
    $categoria = mysqli_real_escape_string($conexion, $_REQUEST['n_categoria']);
    $departamento = mysqli_real_escape_string($conexion, $_REQUEST['n_departamento']);
    $fecha = mysqli_real_escape_string($conexion, $_REQUEST['fecha']);
    $cantidad = mysqli_real_escape_string($conexion, $_REQUEST['cantidad']);

    $query = "INSERT INTO turnos_publicados(categoria, departamento, fecha, id_turno) VALUES(?, ?, ?, ?)";
    $resultado = $conexion->prepare($query);

    if (!$resultado) {
        die("Error al preparar la query: " . $conexion->connect_error);
    }

    $resultado->bind_param("iisi", $categoria, $departamento, $fecha, $horario);

    if (!$resultado) {
        die("Error al vincular parametros en la query: " . $conexion->connect_error);
    }

    $contador = 0;
    while ($contador < $cantidad) {

        $resultado->execute();

        if (!$resultado) {
            die("Error al ejecutar la query: " . $conexion->connect_error);
        } else {
            $contador++;
        }
    }
    $resultado->close();
    $response = array('success' => true, 'message' => 'Turno creado correctamente');
    echo json_encode($response);
} else {
    $stmtMessage = "Error al ejecutar la consulta";
    $response = array('success' => false, 'message' => $stmtMessage);
    echo json_encode($response);
}
$conexion->close();
?>