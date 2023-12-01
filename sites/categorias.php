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
      <button class="nav-text"><a href="#categoryAdd"><i class="bx bx-user-plus"></i>Nueva categoria</a></button>
      <?php
      $id_departamento = isset($_GET['id_departamento']) ? $_GET['id_departamento'] : null;
      echo getDataCategory($conexion, $id_departamento, $nombreDepartamento);
      ?>
    </div>
    <center><a
        href="../scripts/php/departmentEdit/departmentEdit.php?id_departamento=<?php echo $id_departamento ?>">Volver
        atrás</a></center>
  </section>

  <!-- Secciones ocultas -->
  <section class="homeTitle" id="categoryAdd">
    <div class="contenedor-formulario">
      <form class="form" method="POST" action="../scripts/php/category/categoryAdd.php">
        <h2 class="text">Nueva categoria</h2>
        <input type="hidden" name="n_departamento" value="<?php echo $id_departamento ?>">
        <label>Nombre:
          <input type="text" placeholder="Nombre..." name="nombre">
        </label>
        <label>Sueldo base:
          <input type="number" placeholder="Sueldo base..." name="sueldo_normal">
        </label>
        <label>Sueldo plus:
          <input type="number" placeholder="Sueldo plus..." name="sueldo_plus">
        </label>
        </select>
        <button class="saveButton">Guardar Cambios</button>
        <a
          href="categorias.php?id_departamento=<?php echo $id_departamento ?>&nombre_departamento=<?php echo $nombreDepartamento ?>">Volver
          atrás</a>
      </form>
    </div>
  </section>
  <script src="../scripts/js/dashboard.js"></script>
  <script>
    function changeToCategory() {
      var form = document.getElementById("scheduleForm");
      form.action = "../scripts/php/categorias.php?id_departamento=<?php echo $id_departamento; ?>";
      form.submit();
    }
  </script>
</body>

</html>