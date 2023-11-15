<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include("../seguridad/conexion.php");
    $id = $_GET['id_turnoP'];

    $query = "SELECT * FROM turnos_publicados WHERE id_turnoP = '$id'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado->num_rows > 0) {
        $datos = mysqli_fetch_assoc($resultado);
        ?>

        <form method="post" action="scheduleSaveChanges.php" id="scheduleForm">
            <input type="hidden" name="id_turnoP" value="<?php echo $datos['id_turnoP']; ?>">
            <!-- <input type="hidden" name="categoria" value="<?php echo $datos['categoria']; ?>"> -->
            <select name="dni">
                <option>-Selecciona un empleado-</option>
                <?php
                $empleados = "SELECT dni, nombre FROM empleados WHERE n_categoria = '{$datos['categoria']}' AND n_departamento = '{$datos['departamento']}'";
                $query = mysqli_query($conexion, $empleados);
                if ($query) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        $dni = $row["dni"];
                        $nombre = $row["nombre"];
                        echo "<option value='$dni'>$dni - $nombre</option>";
                    }
                } else {
                    echo "<option>No se pueden recuperar los empleados: " . mysqli_error($conexion) . "</option>";
                }
                ?>
            </select>
            <button>Guardar cambios</button>
            <button onclick="deleteSchedule()" type="button">Eliminar turno</button>
        </form>
        <a href="../../../sites/horarios.php">Volver atrás</a>
        <?php
    } else {
        echo "No se encontraron datos para el departamento con ID: $id\n<a href='../../../sites/horarios.php'>Volver atrás</a>";
    }
    $conexion->close();
    ?>
</body>
    <script>
        function deleteSchedule(){
            document.getElementById("scheduleForm").action = "scheduleDelete.php";
            document.getElementById("scheduleForm").submit();
        }
    </script>
</html>