<?php
include('../scripts/php/seguridad/seguridad.php');
include('../scripts/php/seguridad/conexion.php');
// include('../scripts/php/login/datosTrabajadorLogin.php');
include('../scripts/php/login/datosTurnos.php');
$userLogin = $_SESSION['userwebdni'];
$datosHorarios = todosTurnos($conexion, $userLogin);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#695CFE" />
    <link href="../css/dashboard.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../img/cuandoLibro-logo.png">
    <title>My site | Horarios</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../img/cuandoLibro-logo.png" alt="logoClaro" />
                </span>
            </div>
            <i class="bx bx-chevron-right toggle"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <ul class="menu-links">
                    <li class="nav-links">
                        <a href="my-portal.php">
                            <i class="bx bx-home-alt-2 icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="my-portal-horarios.php">
                            <i class="bx bx-calendar-alt icon"></i>
                            <span class="text nav-text">Horarios</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="my-portal-avisos.php">
                            <i class="bx bx-error icon"></i>
                            <span class="text nav-text">Avisos</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="my-portal-nominas.php">
                            <i class='bx bx-wallet icon'></i>
                            <span class="text nav-text">Nóminas</span>
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
            </div>
        </div>
    </nav>
    <section class="homeTitle" id="trabajadores">
        <div class="text">Turnos publicados</div>
        <div class="contenedor-tabla">
            <?php
            if (isset($datosHorarios) && !empty($datosHorarios)) {
                ?>
                <table class='tabla-datos'>
                    <tr>
                        <th>Fecha</th>
                        <th>Turno</th>
                        <th>Hora entrada</th>
                        <th>Hora salida</th>
                        <th>Estado</th>
                    </tr>

                    <?php
                    foreach ($datosHorarios as $turno) {
                        ?>
                        <tr class='datos'>
                            <td>
                                <?php echo date("d/m/Y", strtotime($turno['fecha'])) ?>
                            </td>
                            <td
                                title="Hora entrada: <?php echo date("H:i", strtotime($turno['he'])) . '| Hora salida: ' . date("H:i", strtotime($turno['hs'])); ?>">
                                <?php echo $turno['nombre'] . " (" . date("H:i", strtotime($turno['he'])) . " a " . date("H:i", strtotime($turno['hs'])) . ")" ?>
                            </td>
                            <td>
                                <?php echo isset($turno['hfe']) ? date("H:i:s", strtotime($turno['hfe'])) : "Sin datos..." ?>
                            </td>
                            <td>
                                <?php echo isset($turno['hfs']) ? date("H:i:s", strtotime($turno['hfs'])) : "Sin datos..." ?>
                            </td>
                            <?php if ($turno['hfe'] == null) {
                                echo "<td class='text-red-500'>Turno sin realizar...</td>";
                            } elseif ($turno['hfe'] != null && $turno['hfs'] == null) {
                                echo "<td>Turno en proceso...</td>";
                            } elseif ($turno['hfe'] != null && $turno['hfs'] != null) {
                                echo "<td class='text-green-500'>Turno realizado</td>";
                            }
                            ?>
                        </tr>
                        <?php
                    } ?>

                </table>
                <?php
            } else {
                echo "<h3 class='text'>Juhuju!!! No tienes ningún turno (de momento)</h3>";
            }
            ?>
        </div>
    </section>
    <!-- <script src="../scripts/js/dashboard.js"></script> -->
</body>

</html>