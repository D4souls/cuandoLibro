<?php
include('../scripts/php/seguridad/seguridad.php');
include("../scripts/php/seguridad/conexion.php");
include('../scripts/php/workers/getDataWorkers.php');

//? IMPORTAMOS SIDEBAR & RUTAS
include_once('../config.php');
include(COMPONENTS_PATH . 'sidebar.php');

$nav_dashboard = '../dashboard.php';
$nav_turnosP = 'horarios.php';
$nav_workers = 'trabajadores.php';
$nav_department = 'departamentos.php';
$nav_warnigs = 'avisos.php';

$nav = sidebar($nav_dashboard, $nav_turnosP, $nav_workers, $nav_department, $nav_warnigs);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#695CFE" />
  <link href="../css/dashboard.css" rel="stylesheet" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="../img/logo-alt.png">
  <title>CL | Trabajadores</title>
</head>

<body>
  <?php echo $nav ?>

  <section class="homeTitle" id="trabajadores">
    <div class="text">Trabajadores</div>
    <div class="contenedor-tabla">
      <button class="nav-text"><a href="alta-trabajador.php"><i class="bx bx-user-plus"></i>Agregar
          empleado</a></button>
      <?php echo $data = getDataWorkers($conexion) ?>
    </div>
  </section>
  <script src="../scripts/js/dashboard.js"></script>
</body>

</html>