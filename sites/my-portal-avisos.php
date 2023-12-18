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
        <div class="text">Avisos</div>
        <div class="contenedor-tabla">
            <table class="tabla-datos">
                <?php
                try {
                    $query = "SELECT ta.nombre, a.dni, a.id_aviso, a.comentario, tp.fecha FROM aviso a 
                    INNER JOIN tipoaviso ta ON a.tipo = ta.id
                    INNER JOIN turnos_publicados tp ON a.id_turnoP = tp.id_turnoP
                    WHERE a.dni = ?";
                    $stmt = $conexion->prepare($query);
                    if (!$stmt) {
                        throw new Exception("Error al preparar la consulta: " . $conexion->error);
                    }
                    $stmt->bind_param("s", $userLogin);
                    if ($stmt->execute()) {
                        $stmt->store_result(); //! ASEGURARSE DE ALMACENAR EL RESULTADO
                        if ($stmt->num_rows > 0) {
                            ?>
                            <tr>
                                <th>DNI</th>
                                <th>Tipo Aviso</th>
                                <th>Comentario</th>
                                <th>Fecha Aviso</th>
                            </tr>
                            <?php
                            $stmt->bind_result($tipoAviso, $dni, $id_aviso, $comentarioAviso, $fecha);
                            while ($stmt->fetch()) {
                                ?>
                                <tr class="datos">
                                    <td>
                                        <?php echo $dni ?>
                                    </td>
                                    <td>
                                        <?php echo $tipoAviso ?>
                                    </td>
                                    <td>
                                        <?php echo $comentarioAviso ?>
                                    </td>
                                    <td>
                                        <?php echo date('d/m/Y',strtotime($fecha)) ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <h3 class="text">Esto está desértico ¡Sigue asi!</h3>
                            <?php
                        }
                    } else {
                        throw new Exception("Error al ejecutar la consulta: " . $conexion->error);
                    }
                } catch (Exception $e) {
                    print("<p>$e</p>");
                } finally {
                    if ($conexion) {
                        $conexion->close();
                    }
                }

                ?>
            </table>
        </div>
    </section>
    <!-- <script src="../scripts/js/dashboard.js"></script> -->
</body>

</html>