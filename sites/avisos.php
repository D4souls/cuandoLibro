<?php
include('../scripts/php/seguridad/seguridad.php');
include('../scripts/php/seguridad/conexion.php');
include('../scripts/php/seguridad/config.php');
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
            <a href="#dashboard">
              <i class="bx bx-home-alt-2 icon"></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-links">
            <a href="<?php echo SCHEDULE; ?>">
              <i class="bx bx-calendar-alt icon"></i>
              <span class="text nav-text">Horarios</span>
            </a>
          </li>
          <li class="nav-links">
            <a href="<?php echo WORKERS; ?>">
              <i class="bx bx-user icon"></i>
              <span class="text nav-text">Trabajadores</span>
            </a>
          </li>
          <li class="nav-links">
            <a href="<?php echo DEPARTMENT; ?>">
              <i class="bx bx-briefcase-alt-2 icon"></i>
              <span class="text nav-text">Departamentos</span>
            </a>
          </li>
          <li class="nav-links">
            <a href="<?php echo WARNINGS; ?>">
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
  <section class="homeTitle" id="dashboard">
    <div class="text">Avisos</div>
    <div class="grid md:grid-cols-6 gap-5 m-4 mt-[40px] contenedor-tabla">
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
                <td><?php echo $comentarioAviso?></td>
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