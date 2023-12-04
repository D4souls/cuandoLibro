<?php
include_once('../seguridad/seguridad.php');
include_once('../seguridad/conexion.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../css/dashboard.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="../../../img/logo-alt.png">
    <script src="../../js/dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.all.min.js"></script>

    <title>CL | Editar trabajador</title>
</head>

<body>

    <?php
    $dni = $_GET["dni"];

    $query = "SELECT ta.nombre, a.dni, a.id_aviso, a.comentario FROM aviso a 
      INNER JOIN tipoaviso ta ON a.tipo = ta.id
      INNER JOIN turnos_publicados tp ON a.id_turnoP = tp.id_turnoP WHERE a.dni = ?";

    $query_avisosPorEmpleado=$conexion->prepare($query);

    if(!$query_avisosPorEmpleado){
        throw new Exception("Error al preparar la consulta" . $conexion->error);
    }

    $query_avisosPorEmpleado->bind_param("s", $dni);

    if(!$query_avisosPorEmpleado){
        throw new Exception("Error al vicular parametros en la consulta" . $conexion->error);
    }

    $query_avisosPorEmpleado->execute();

    if(!$query_avisosPorEmpleado){
        throw new Exception("Error al ejecutar la consulta" . $conexion->error);
    }

    $query_avisosPorEmpleado->get_result();

    if($query_avisosPorEmpleado->num_rows > 0){
        $query_avisosPorEmpleado->fetch();
        
        echo $query_avisosPorEmpleado["dni"];
    } else {
        echo "No hay datos";
    }

    ?>

</body>

</html>