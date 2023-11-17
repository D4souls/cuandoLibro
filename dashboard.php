<?php
include('scripts/php/seguridad/seguridad.php');
include('scripts/php/seguridad/conexion.php');
include('scripts/php/login/datosTrabajadorLogin.php');
$datosLogin = obtenerDatosEmpleado($conexion, $_SESSION["userwebdni"]);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#695CFE" />
  <link href="./css/dashboard.css" rel="stylesheet" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="img/cuandoLibro-logo.png">
  <title>CL | Dashboard</title>
</head>

<body>
  <nav class="sidebar close">
    <header>
      <div class="image-text">
        <span class="image">
          <img src="img/cuandoLibro-logo.png" alt="logoClaro" />
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
            <a href="#dashboard">
              <i class="bx bx-home-alt-2 icon"></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-links">
            <a href="sites/horarios.php">
              <i class="bx bx-calendar-alt icon"></i>
              <span class="text nav-text">Horarios</span>
            </a>
          </li>
          <li class="nav-links">
            <a href="sites/trabajadores.php">
              <i class="bx bx-user icon"></i>
              <span class="text nav-text">Trabajadores</span>
            </a>
          </li>
          <li class="nav-links">
            <a href="sites/departamentos.php">
              <i class="bx bx-briefcase-alt-2 icon"></i>
              <span class="text nav-text">Departamentos</span>
            </a>
          </li>
          <li class="nav-links">
            <a href="#avisos">
              <i class="bx bx-error icon"></i>
              <span class="text nav-text">Avisos</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="bottom-content">
        <li class="">
          <a href="scripts/php/seguridad/cerrarSesion.php">
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
  <section class="homeTitle" id="dashboard">
    <div class="text">Dashboard</div>
    <div class="card">
      <!-- Incluir la imagen del usuario -->
      <div class="user-img">
        <img alt="userImage" src="img/imagen-prueba.jpg">
      </div>
      <h3>Bienvenido de nuevo
        <?php echo $datosLogin["nombre"] ?>
      </h3>
      <table>
        <ul>
          <li>Departamento:
            <?php echo $datosLogin["nombreDep"] ?>
          </li>
          <li>Categoria:
            <?php echo $datosLogin["nombreCat"] ?>
          </li>
          <li>Última conexión:
            <?php echo $datosLogin["lastlogout"] ?>
          </li>
        </ul>
      </table>
    </div>
  </section>
  <script src="scripts/js/dashboard.js"></script>
</body>

</html>