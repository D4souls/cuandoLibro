<?php
include('scripts/php/seguridad/seguridad.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#695CFE" />
  <link href="./css/dashboard.css" rel="stylesheet" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <title>Dashboard</title>
</head>

<body>
  <nav class="sidebar close">
    <header>
      <div class="image-text">
        <span class="image">
          <img src="img/MicrosoftTeams-image (1).png" alt="logoClaro" />
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
            <a href="#horarios">
              <i class="bx bx-calendar-alt icon"></i>
              <span class="text nav-text">Horarios</span>
            </a>
          </li>
          <li class="nav-links">
            <a href="#trabajadores">
              <i class="bx bx-user icon"></i>
              <span class="text nav-text">Trabajadores</span>
            </a>
          </li>
          <li class="nav-links">
            <a href="#departamentos">
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
  </section>
  <section class="homeTitle" id="horarios">
    <div class="text">Horarios</div>
  </section>
  <section class="homeTitle" id="trabajadores">
    <div class="text">Trabajadores</div>
    <div class="contenedor-tabla">
      <?php
      include(__DIR__ . '/scripts/php/seguridad/conexion.php');
      $var_consulta = "SELECT e.dni, e.nombre, e.apellido1, e.apellido2, c.nombre AS 'nombreCategoria', d.nombre AS 'nombreDepartamento' FROM empleados e INNER JOIN categorias c ON c.id_categoria = e.n_categoria INNER JOIN departamentos d ON d.id_departamento = e.n_departamento";
      $var_resultado = $conexion->query($var_consulta);
      echo '<button class="nav-text"><a href="#userAdd"><i class="bx bx-user-plus"></i>Agregar empleado</a></button>';
      if ($var_resultado->num_rows > 0) {
        echo '<h3>Hay ' . $var_resultado->num_rows . ' trabajadores en la base de datos</h3>';
        echo '<table class="tabla-datos">';
        echo '<tr>';
        echo '<th>DNI</th>';
        echo '<th>Nombre</th>';
        echo '<th>Apellido</th>';
        echo '<th>Apellido 2</th>';
        echo '<th>Categoria</th>';
        echo '<th>Departamento</th>';
        echo '</tr>';

        while ($var_fila = $var_resultado->fetch_array()) {
          echo "<tr class='datos' id='empleado_{$var_fila["dni"]}' onclick=\"window.location.href='scripts/php/userEdit/userEdit.php?dni={$var_fila["dni"]}'\">";

          // Ocultar DNI
          $dni_oculto = str_repeat("*", 4) . substr($var_fila["dni"], 4);

          // Celdas de la fila
          echo ("<td>{$dni_oculto}</td>");
          echo ("<td>{$var_fila["nombre"]}</td>");
          echo ("<td>{$var_fila["apellido1"]}</td>");
          echo ("<td>{$var_fila["apellido2"]}</td>");
          echo ("<td>{$var_fila["nombreCategoria"]}</td>");
          echo ("<td>{$var_fila["nombreDepartamento"]}</td>");

          echo '</tr>';
        }



        echo '</table>';
        // Agregar contenedor del panel
        echo '<div id="panelEmpleado" class="panel">';
        echo '    <!-- Contenido del panel (puedes personalizarlo según tus necesidades) -->';
        echo '    <button onclick="cerrarPanel()">Cerrar</button>';
        echo '</div>';

        echo '</table>';
      }
      ?>

    </div>
  </section>
  <section class="homeTitle" id="departamentos">
    <div class="text">Departamentos</div>
  </section>
  <section class="homeTitle" id="avisos">
    <div class="text">Avisos</div>
  </section>

  <!-- Secciones ocultas -->
  <section class="homeTitle" id="userAdd">
    <div class="text">Agregar usuario</div>
    <div class="div-form-userAdd">
      <form class="form-userAdd" method="POST" action="scripts/php/userAdd/userAdd.php">
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
        <label>Numero categoría</label>
        <input type="number" placeholder="Nº Categoría..." name="n_cat">
        <label>Numero departamento</label>
        <input type="number" placeholder="Nº Departamento..." name="n_departamento">
        <button>Agregar Usuario</button>
      </form>
    </div>
  </section>
  <script src="scripts/js/dashboard.js"></script>
</body>

</html>