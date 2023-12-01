<?php
include('../scripts/php/seguridad/seguridad.php');
include('../scripts/php/seguridad/conexion.php');

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
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../img/logo-alt.png">
  <title>CL | Agregar trabajador</title>
</head>

<body>
  <?php echo $nav; ?>
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
        <label>Correo electrónico:
          <input type="text" placeholder="email..." name="mail">
        </label>
        

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