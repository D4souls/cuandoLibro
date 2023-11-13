<?php
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
  <link rel="icon" href="../img/cuandoLibro-logo.png">
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
            <a href="#department">
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

  <section class="homeTitle" id="department">
    <div class="text">Departamentos</div>
    <div class="contenedor-tabla">
      <?php
      include('../scripts/php/seguridad/conexion.php');
      $var_consulta = "SELECT * FROM departamentos";
      $var_resultado = $conexion->query($var_consulta);
      echo '<button class="nav-text"><a href="#departmentAdd"><i class="bx bx-user-plus"></i>Nuevo departamento</a></button>';
      if ($var_resultado->num_rows > 0) {
        echo '<h3>Hay ' . $var_resultado->num_rows . ' departamentos en la base de datos</h3>';
        echo '<table class="tabla-datos">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nombre</th>';
        echo '<th>Presupuesto</th>';
        echo '</tr>';

        while ($var_fila = $var_resultado->fetch_array()) {
          echo "<tr class='datos' id='departamento_{$var_fila["id_departamento"]}' onclick=\"window.location.href='../scripts/php/departmentEdit/departmentEdit.php?id_departamento={$var_fila["id_departamento"]}'\">";
          // Celdas de la fila
          echo ("<td>{$var_fila["id_departamento"]}</td>");
          echo ("<td>{$var_fila["nombre"]}</td>");
          echo ("<td>{$var_fila["presupuesto"]}€</td>");
          echo '</tr>';
        }
        echo '</table>';
      }
      ?>

    </div>
  </section>

  <!-- Secciones ocultas -->
  <section class="homeTitle" id="departmentAdd">
    <div class="text">Nuevo departamento</div>
    <div class="div-form-userAdd">
      <form class="form-userAdd" method="POST" action="../scripts/php/departmentAdd/departmentAdd.php">
        <label>Nombre</label>
        <input type="text" placeholder="Nombre..." name="nombre">
        <label>Presupuesto</label>
        <input type="number" placeholder="Presupuesto..." name="presupuesto">
        <button>Crear departamento</button>
      </form>
    </div>
  </section>

  <section class="homeTitle" id="departmentEdit">
    <div class="text">Editar departameto</div>
    <div class="div-form-userAdd">
      <?php
      include("../scripts/php/seguridad/conexion.php");
      $id = isset($_POST['id_departamento']) ? $_POST['id_departamento'] : null;

      $query_departamentos = "SELECT * FROM departamentos WHERE id_departamento = '$id'";
      $resultado_departamentos = mysqli_query($conexion, $query_departamentos);

      if ($resultado_departamentos->num_rows > 0) {
        $datos_departamentos = mysqli_fetch_assoc($resultado_departamentos);
        ?>

        <form action="departmentSave.php" method="get">
          <label for="id_departamento">ID</label>
          <input type="text" name="id_departamento" value="<?php echo $datos_departamentos['id_departamento']; ?>"
            readonly>

          <label for="nombre">Nombre:</label>
          <input type="text" name="nombre" value="<?php echo $datos_departamentos['nombre']; ?>">

          <label for="presupuesto">Presupuesto:</label>
          <input type="text" name="presupuesto" value="<?php echo $datos_departamentos['presupuesto']; ?>">

          <button type="submit">Guardar Cambios</button>
        </form>

        <!-- Botón para eliminar al departamento -->
        <form action="departmentDelete.php" method="post">
          <input type="hidden" name="id_departamento" value="<?php echo $datos_departamentos['id_departamento']; ?>">
          <button type="submit">Eliminar Departamento</button>
        </form>

        <?php
      } else {
        echo "No se encontraron datos para el departamento con ID: $id";
      }

      // Cerrar la conexión
      $conexion->close();
      ?>
    </div>
  </section>

  <script src="../scripts/js/dashboard.js"></script>
</body>

</html>