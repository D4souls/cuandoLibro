<?php
include('../scripts/php/seguridad/seguridad.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#695CFE" />
    <link href="../css/dashboard.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="img/cuandoLibro-logo.png">
    <title>Dashboard</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../img/cuandoLibro-logo.png" alt="logoClaro" />
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
                    <a href="../scripts/php/seguridad/cerrarSesion.php">
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
        <div class="text">Turnos publicados</div>
        <div class="addturno">
            <?php
            include("../scripts/php/seguridad/conexion.php");
            $query_schedule = "SELECT * FROM turnos_publicados";
            $result_schedule = $conexion->query($query_schedule);

            if ($result_schedule) {
                $datos_turno = $result_schedule->fetch_assoc();
            ?>
                <form action="../scripts/php/schedule/scheduleCreate.php" method="post">
                    <label>Fecha</label>
                    <input type="hidden" name="id_turnoP" value="<?php echo $datos_turno['id_turnoP']; ?>">
                    <input type="date" name="fecha" value="<?php echo $datos_turno['fecha']; ?>">
                    <!-- Agrega otros campos del formulario si es necesario -->
                    <button type="submit">Crear Turno</button>
                </form>
            <?php
            } else {
                echo "Error al obtener los datos del turno.";
            }
            ?>
        </div>

        <div class="contenedor-tabla">
            <?php
            include('../scripts/php/seguridad/conexion.php');
            $var_consulta = "SELECT * FROM turnos_publicados";
            $var_resultado = $conexion->query($var_consulta);
            echo '<button class="nav-text"><a href="#departmentAdd"><i class="bx bx-user-plus"></i>Nuevo departamento</a></button>';
            if ($var_resultado->num_rows > 0) {
                echo '<h3>Hay ' . $var_resultado->num_rows . ' departamentos en la base de datos</h3>';
                echo '<table class="tabla-datos">';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Fecha</th>';
                echo '<th>Trabajador</th>';
                echo '<th>Turno</th>';
                echo '</tr>';

                while ($var_fila = $var_resultado->fetch_array()) {
                    echo "<tr class='datos' id='idTurnoPublicado_{$var_fila["id_turnoP"]}' onclick=\"window.location.href='../scripts/php/departmentEdit/departmentEdit.php?id_turnoP={$var_fila["id_turnoP"]}'\">";
                    // Celdas de la fila
                    echo ("<td>{$var_fila["id_turnoP"]}</td>");
                    echo ("<td>{$var_fila["fecha"]}</td>");
                    echo ("<td>{$var_fila["dni"]}</td>");
                    echo ("<td>{$var_fila["id_turno"]}</td>");
                    echo '</tr>';
                }
                echo '</table>';
            }
            ?>

        </div>
    </section>
    </section>

    <script src="../scripts/js/dashboard.js"></script>
</body>

</html>