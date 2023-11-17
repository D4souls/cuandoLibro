<?php
include('../scripts/php/seguridad/conexion.php');
include("../scripts/php/seguridad/conexion.php");
include('../scripts/php/workers/getDataWorkers.php');
$nombreDepartamento = isset($_GET['nombre_departamento']) ? urldecode($_GET['nombre_departamento']) : '';
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

  <section class="homeTitle" id="category">
    <div class="text">Categorias del departamento <?php echo $nombreDepartamento ?></div>
    <div class="contenedor-tabla">
      <button class="nav-text"><a href="#categoryAdd"><i class="bx bx-user-plus"></i>Nueva categoria</a></button>
      <?php
      $id_departamento = isset($_GET['id_departamento']) ? $_GET['id_departamento'] : null;
      echo getDataCategory($conexion, $id_departamento, $nombreDepartamento);
      ?>
    </div>
    <center><a href="../scripts/php/departmentEdit/departmentEdit.php?id_departamento=<?php echo $id_departamento ?>">Volver atrás</a></center>
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
        <a href="categorias.php?id_departamento=<?php echo $id_departamento ?>&nombre_departamento=<?php echo $nombreDepartamento?>">Volver atrás</a>
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