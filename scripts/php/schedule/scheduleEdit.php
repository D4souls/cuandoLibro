<?php
include("../seguridad/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../css/dashboard.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="../../../img/logo-alt.png">
    <title>CL | Editar turno</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../../../img/cuandoLibro-logo.png" alt="logoClaro" />
                </span>

                <div class="text header-text">
                    <span class="name">CuandoLibro</span>
                    <span class="profession">IAW & DB</span>
                </div>
            </div>
            <i class="bx bx-chevron-right toggle"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class="bx bx-search icon"></i>
                    <input type="text" placeholder="Buscar..." />
                </li>

                <ul class="menu-links">
                    <li class="nav-links">
                        <a href="../dashboard.php">
                            <i class="bx bx-home-alt-2 icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="horarios.php">
                            <i class="bx bx-calendar-alt icon"></i>
                            <span class="text nav-text">Horarios</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="trabajadores.php">
                            <i class="bx bx-user icon"></i>
                            <span class="text nav-text">Trabajadores</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="departamentos.php">
                            <i class="bx bx-briefcase-alt-2 icon"></i>
                            <span class="text nav-text">Departamentos</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="avisos.php">
                            <i class="bx bx-error icon"></i>
                            <span class="text nav-text">Avisos</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li class="">
                    <a href="../seguridad/cerrarSesion.php">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">Cerrar sesión</span>
                    </a>
                </li>
                <li class="mode">
                    <div class="moon-sun">
                        <i class="bx bx-moon icon moon"></i>
                        <i class="bx bx-sun icon sun"></i>
                    </div>
                    <span class="mode-text text">Modo oscuro</span>
                    <div class="toogle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>

    <section class="homeTitle" id="trabajadores">
        <div class="contenedor-formulario">
            <?php include("../seguridad/conexion.php");
            $id = $_GET['id_turnoP'];

            $query = "SELECT * FROM turnos_publicados WHERE id_turnoP = '$id'";
            $resultado = mysqli_query($conexion, $query);

            if ($resultado->num_rows > 0) {
                $datos = mysqli_fetch_assoc($resultado);
                ?>

                <form method="post" id="scheduleForm" class="form">
                    <h2 class="text">Realizar cambios</h2>
                    <input type="hidden" name="id_turnoP" value="<?php echo $datos['id_turnoP']; ?>">
                    <!-- <input type="hidden" name="categoria" value="<?php echo $datos['categoria']; ?>"> -->
                    <select name="dni">
                        <?php
                        $comprobación = "SELECT e.dni, e.nombre FROM empleados e 
                        INNER JOIN turnos_publicados tp ON e.dni = tp.dni
                        WHERE tp.id_turnoP = ?";

                        $stm = $conexion->prepare($comprobación);
                        $stm->bind_param("s", $id);
                        $stm->execute();
                        $stm->store_result();
                        $stm->bind_result($dniUsado, $nombreUsado);


                        if ($stm->fetch()) { // Si me devuleve algo me lo vas a mostrar
                            echo "<option value='$dniUsado'>$dniUsado - $nombreUsado</option>";
                        } else {
                            echo "<option>-Selecciona un empleado-</option>";
                        }

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
                    <div id="mensaje"></div>
                    <button class="saveButton" onclick="guardarCambios()">Guardar cambios</button>
                    <button onclick="changeActionAndSubmit()" type="button" class="deleteButton">Eliminar turno</button>
                    <a href="../../../sites/horarios.php">Volver atrás</a>
                </form>
                <?php
            } else {
                echo "No se encontraron datos para el departamento con ID: $id\n<a href='../../../sites/horarios.php'>Volver atrás</a>";
            }
            $conexion->close();
            ?>
        </div>
    </section>
    <!-- <script src="../scripts/js/dashboard.js"></script> -->
    <script src="../../js/dashboard.js"></script>
    <script>
        function changeActionAndSubmit() {
            var form = document.getElementById("scheduleForm");
            form.action = "scheduleDelete.php";  // Cambia la acción del formulario
            form.submit();  // Envía el formulario
        }

        function guardarCambios() {
            var form = document.getElementById("scheduleForm");
            form.action = "scheduleSaveChanges.php";  // Cambia la acción del formulario
            form.submit();  // Envía el formulario

        }
    </script>
</body>

</html>