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
  <link rel="icon" href="../img/logo-alt.png">
  <title>CL | Agregar trabajador</title>
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
    <div class="contenedor-formulario">
      <form method="POST" action="../scripts/php/userAdd/userAdd.php" class="form">
        <h2 class="text">Agregar usuario</h2>
        <label>DNI:
          <input type="text" placeholder="DNI..." name="dni">
        </label>
        <label>Nombre:
          <input type="text" placeholder="Nombre..." name="nombre">
        </label>
        <label>Apellido 1:
          <input type="text" placeholder="Apellido 1..." name="apellido1">
        </label>
        <label>Apellido 2:
          <input type="text" placeholder="Apellido 2..." name="apellido2">
        </label>
        <label>IBAN:
          <input type="text" placeholder="IBAN..." name="iban">
        </label>

        <?php $datos_empleado = []; ?>

        <select name="n_departamento" id="departamento">
          <option value="">- Seleccione un departamento -</option>
          <?php
          // Fetch all departments
          $query_departamentos = "SELECT * FROM departamentos";
          $resultado_departamentos = mysqli_query($conexion, $query_departamentos);

          // Display departments
          while ($departamento = mysqli_fetch_assoc($resultado_departamentos)) {
            echo "<option value='{$departamento['id_departamento']}'>{$departamento['nombre']}</option>";
          }
          ?>
        </select>
        <select name="n_categoria" id="categoria" disabled="">
          <option value="">- Seleccione una categoría -</option>
        </select>
        <button class="saveButton">Guardar Cambios</button>
        <a href="trabajadores.php">Volver atrás</a>
      </form>
    </div>
  </section>

  <script src="../scripts/js/dashboard.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    $(document).ready(function () {
      var categoria = $('#categoria');

      $('#departamento').change(function () {
        var departamento_id = $(this).val();
        if (departamento_id !== '') {
          $.ajax({
            data: { departamento_id: departamento_id },
            dataType: 'html',
            type: 'POST',
            url: '../scripts/php/category/categoryGet.php'
          }).done(function (data) {
            categoria.html(data);
            categoria.prop('disabled', false);
          });
        } else {
          categoria.val('');
          categoria.prop('disabled', true);
        }
      });
    });
  </script>
</body>

</html>