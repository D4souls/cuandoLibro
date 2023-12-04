<?php
include('../scripts/php/seguridad/conexion.php');
include("../scripts/php/seguridad/conexion.php");
include('../scripts/php/workers/getDataWorkers.php');
$nombreDepartamento = isset($_GET['nombre_departamento']) ? urldecode($_GET['nombre_departamento']) : '';

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
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.min.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../scripts/js/dashboard.js"></script>
  <link rel="icon" href="../img/logo-alt.png">
  <title>CL | Categorías</title>
</head>

<body>
  <?php echo $nav ?>

  <section class="homeTitle" id="category">
    <div class="text">Categorias del departamento
      <?php echo $nombreDepartamento ?>
    </div>
    <div class="contenedor-tabla">
      <button type="button" onclick="newCategory()" class="nav-text"><i class="bx bx-user-plus"></i>Nueva categoria</button>
      <?php
      $id_departamento = isset($_GET['id_departamento']) ? $_GET['id_departamento'] : null;
      echo getDataCategory($conexion, $id_departamento, $nombreDepartamento);
      ?>
    </div>
  </section>

  <script>
    function newCategory() {
      window.location.href = '../scripts/php/category/categoryCreate.php?id_departamento=<?php echo $id_departamento?>&nombre_departamento=<?php echo $nombreDepartamento?>'
    }
  </script>
</body>

</html>