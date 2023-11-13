<?php
include('../scripts/php/seguridad/seguridad.php');
include('../scripts/php/seguridad/conexion.php');
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
            <a href="dashboard.php">
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
  <!-- Secciones ocultas -->
  <section class="homeTitle" id="userAdd">
    <div class="text">Agregar usuario</div>
    <div class="div-form-userAdd">
      <form class="form-userAdd" method="POST" action="../scripts/php/userAdd/userAdd.php">
        <label>DNI</label>
        <input type="text" placeholder="DNI..." name="dni">
        <label>Nombre</label>
        <input type="text" placeholder="Nombre..." name="nombre">
        <label>Apellido 1</label>
        <input type="text" placeholder="Apellido 1..." name="apellido1">
        <label>Apellido 2</label>
        <input type="text" placeholder="Apellido 2..." name="apellido2">
        <label>IBAN</label>
        <input type="text" placeholder="IBAN..." name="iban">

        <select name="n_departamento">
          <option value="">- Seleccione un departamento -</option>
          <?php
          // Fetch all departments
          $query_departamentos = "SELECT * FROM departamentos";
          $resultado_departamentos = mysqli_query($conexion, $query_departamentos);

          // Display departments
          while ($departamento = mysqli_fetch_assoc($resultado_departamentos)) {
            $selected = ($departamento['id_departamento'] == $datos_empleado['n_departamento']) ? 'selected' : '';
            echo "<option value='{$departamento['id_departamento']}' $selected>{$departamento['nombre']}</option>";
          }
          ?>
        </select>

        <select name="n_categoria">
          <option value="">- Seleccione una categoría -</option>
          <?php
          // Fetch all categories
          $query_categorias = "SELECT * FROM categorias";
          $resultado_categorias = mysqli_query($conexion, $query_categorias);

          // Display categories
          while ($categoria = mysqli_fetch_assoc($resultado_categorias)) {
            $selected = ($categoria['id_categoria'] == $datos_empleado['n_categoria']) ? 'selected' : '';
            echo "<option value='{$categoria['id_categoria']}' $selected>{$categoria['nombre']}</option>";
          }
          ?>
        </select>
        <button>Agregar Usuario</button>
      </form>
    </div>
  </section>

  <script src="../scripts/js/dashboard.js"></script>
</body>

</html>