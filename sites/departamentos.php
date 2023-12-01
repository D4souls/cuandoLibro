<?php
include('../scripts/php/seguridad/conexion.php');
include("../scripts/php/seguridad/conexion.php");
include('../scripts/php/workers/getDataWorkers.php');

//? IMPORTAMOS SIDEBAR & RUTAS
include_once('../config.php');
include(COMPONENTS_PATH.'sidebar.php');

$nav_dashboard ='../dashboard.php';
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
  <title>CL | Departamentos</title>
</head>

<body>
  <?php echo $nav ?>

  <section class="homeTitle" id="department">
    <div class="text">Departamentos</div>
    <div class="contenedor-tabla">
      <button class="nav-text"><a href="#departmentAdd"><i class="bx bx-user-plus"></i>Nuevo departamento</a></button>
      <?php echo $data = getDataDeraptment($conexion) ?>
    </div>
  </section>

  <!-- Secciones ocultas -->
  <section class="homeTitle" id="departmentAdd">
    <div class="contenedor-formulario">
      <form class="form" method="POST" action="../scripts/php/departmentAdd/departmentAdd.php">
        <h2 class="text">Nuevo departamento</h2>
        <label>Nombre:
          <input type="text" placeholder="Nombre..." name="nombre">
        </label>
        <label>Presupuesto:
          <input type="number" placeholder="Presupuesto..." name="presupuesto">
        </label>
        <button class="saveButton">Guardar Cambios</button>
        <a href="departamentos.php#department">Volver atrás</a>
      </form>
    </div>
  </section>
  <script src="../scripts/js/dashboard.js"></script>
  <script>
    function verCategorias(idDepartamento) {
      // Redirige a la página de categorías con el ID del departamento
      window.location.href = `../scripts/php/category/categoryEdit.php?id_departamento=${idDepartamento}`;
    }
  </script>
</body>

</html>