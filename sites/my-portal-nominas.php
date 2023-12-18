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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" href="../img/cuandoLibro-logo.png">
    <title>My site | Nominas</title>
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
    <?php

    if (!isset($_GET['year']) and !isset($_GET['dni'])) {
        ?>
        <section class="homeTitle">
            <div class="text">Años nominas</div>
            <?php

            $ruta = "../scripts/php/seguridad/nominas/" . $userLogin;

            if (file_exists($ruta) && is_dir($ruta)) {
                $contenidoRuta = scandir($ruta);

                $filtrarRutas = array_diff($contenidoRuta, array('.', '..'));

                foreach ($filtrarRutas as $anosCarpetas) {
                    ?>
                    <div class='card' id='<?php echo $anosCarpetas ?>'>
                        <div class='flex flex-row items-center'>
                            <span class='text-3xl'>
                                <?php echo $anosCarpetas ?>
                            </span>
                            <i class='bx bx-link-external'></i>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "Error al leer la carpete";
            }
            ?>
        </section>
        <?php
    } else {
        ?>
        <section class="homeTitle">
            <div class="text">Nominas año
                <?php echo $_GET['year'] ?>
            </div>

            <?php
            $dni = $_GET['dni'];
            $year = $_GET['year'];

            $ruta = '../scripts/php/seguridad/nominas/' . $dni . '/' . $year . '/';

            $getNominas = array_diff(scandir($ruta), array('.', '..'));

            if ($getNominas != null) {
                foreach ($getNominas as $pdf) {

                    $posicionGuion = strpos($pdf, '_');

                    $mes = substr($pdf, 0, $posicionGuion);

                    $mesesTraducidos = array(
                        'Jan' => 'Enero',
                        'Feb' => 'Febrero',
                        'Mar' => 'Marzo',
                        'Apr' => 'Abril',
                        'May' => 'Mayo',
                        'Jun' => 'Junio',
                        'Jul' => 'Julio',
                        'Aug' => 'Agosto',
                        'Sep' => 'Septiembre',
                        'Oct' => 'Octubre',
                        'Nov' => 'Noviembre',
                        'Dec' => 'Diciembre'
                    );

                    $mesFinal = $mesesTraducidos[$mes];

                    ?>
                    <div style='overflow: hidden;'
                        class='bg-white rounded-lg w-96 h-54 p-2 mt-[30px] ml-8 drop-shadow-xl flex flex-col items-center hover:drop-shadow-none transition:all ease-in-out delay-100 gap-2 cursor-pointer'>
                        <h2 class='text-2xl font-semibold'>Nómina del mes de
                            <?php echo $mesFinal ?>
                        </h2>
                        <iframe scrolling="no" src='<?php echo $ruta . $pdf ?>' type="application/pdf" class='blur-sm scroll-hidden' width="80%" height="30%"></iframe>
                        <a href='<?php echo $ruta . $pdf ?>' download="<?php echo $pdf ?>" class='text-lg'>
                            Descargar nómina <i class='bx bx-link-external'></i>
                        </a>
                    </div>

                    <?php
                }
            } else {
                ?>
                    <h2 class='text' aling="center">Vaya... parece que no has combrado aún :(</h2>
                <?php
            }

            ?>

        </section>
        <?php

    }

    ?>
    <!-- <script src="../scripts/js/dashboard.js"></script> -->
</body>

<script>
    function redireccionarAnoDNI(ano, dni) {
        var url = "my-portal-nominas.php?year=" + ano + "&dni=" + dni;
        window.location.href = url;
    }

    $('.card').on('click', function () {
        var ano = $(this).attr('id');
        redireccionarAnoDNI(ano, '<?php echo $userLogin; ?>');
    });
</script>

</html>