<?php
include('../scripts/php/seguridad/seguridad.php');
include('../scripts/php/seguridad/conexion.php');

//? IMPORTAMOS SIDEBAR & RUTAS
include('../scripts/components/sidebar.php');

$nav_dashboard = 'dashboard.php';
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
  <link rel="icon" href="../img/cuandoLibro-logo.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style type="text/tailwindcss">
    @layer utilities {
      .content-auto {
        content-visibility: auto;
      }
    }
  </style>
  <title>CL | Dashboard</title>
</head>

<body>
  <?php echo $nav ?>
  <section class="homeTitle" id="dashboard">
    <div class="text">Avisos</div>
    <div class="contenedor-tabla">
      <table class="tabla-datos">
        <tr>
          <th>DNI</th>
          <th>Tipo Aviso</th>
          <th>Comentario</th>
        </tr>
        <?php
        $query = "SELECT ta.nombre, a.dni, a.id_aviso, a.comentario FROM aviso a 
      INNER JOIN tipoaviso ta ON a.tipo = ta.id
      INNER JOIN turnos_publicados tp ON a.id_turnoP = tp.id_turnoP";
        $stmt = $conexion->prepare($query);
        if (!$stmt) {
          die("<p>Error al preparar la consulta: </p>" . $conexion->error);
        }
        if ($stmt->execute()) {
          $stmt->store_result(); //! ASEGURARSE DE ALMACENAR EL RESULTADO
          if ($stmt->num_rows > 0) {
            $stmt->bind_result($tipoAviso, $dni, $id_aviso, $comentarioAviso);
            while ($stmt->fetch()) {
              ?>
              <tr class="datos">
                <td>
                  <?php echo $dni ?>
                </td>
                <td>
                  <?php echo $tipoAviso ?>
                </td>
                <td>
                  <?php echo $comentarioAviso ?>
                </td>
              </tr>
            </table>
            <?php
            }
          }
        } else {
          die("<p>Error al ejecutar la consulta: </p>" . $conexion->error);
        }

        ?>
      </table>
    </div>
  </section>
  <script src="scripts/js/dashboard.js"></script>
  <script>
    document.getElementById(<?php echo $id_aviso ?>).onclick = function () {
      alert("Funciona")
      //window.location.href = "scripts/php/userEdit/myportlaEdit.php?dni=<?php echo $datosLogin['dni'] ?>&rol=<?php echo $datosLogin["rol"] ?>";
    }

    document.getElementById("graficoDepartamentos").onclick = function () {
      window.location.href = "sites/departamentos.php";
    }
  </script>

  <script>

  </script>


</body>

</html>