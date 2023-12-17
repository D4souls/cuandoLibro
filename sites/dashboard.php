<?php
include_once('../scripts/php/seguridad/seguridad.php');
include_once('../scripts/php/seguridad/conexion.php');
include_once('../scripts/php/login/datosTrabajadorLogin.php');
include_once('../scripts/php/workers/getDataWorkers.php');

//? IMPORTAMOS SIDEBAR & RUTAS
include('../scripts/components/sidebar.php');

$nav_dashboard = 'dashboard.php';
$nav_turnosP = 'horarios.php';
$nav_workers = 'trabajadores.php';
$nav_department = 'departamentos.php';
$nav_warnigs = 'avisos.php';

$nav = sidebar($nav_dashboard, $nav_turnosP, $nav_workers, $nav_department, $nav_warnigs);


$datosLogin = obtenerDatosEmpleado($conexion, $_SESSION["userwebdni"]);

/* Cantidad total de empleados */
$totalEmpleados = totalWorkers($conexion);

//? ESTADISTICAS DEPARTAMENTOS
$dineroDepart = totalMoney($conexion);

//? CANTIDAD DE AVISOS
$cantidadAvisos = getWarnings($conexion);

function generarColorAleatorio()
{
  return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}

// print_r($cantidadAvisos);
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
    <div class="text">Dashboard</div>
    <div class="grid md:grid-cols-3 md:grid-rows-5 sm:grid-cols-1 gap-5 m-4 mt-[40px]">
      <!-- Datos usuario login -->
      <div
        class="flex p-2 gap-3 items-center border-box bg-white rounded-md shadow-2xl transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duraion-300 cursor-pointer"
        id="card">
        <!-- Incluir la imagen del usuario -->
        <div class="user-img">
          <img alt="userImage" src="../scripts/php/userImages/img/<?php echo $datosLogin['dni'] ?>.png">
        </div>
        <div>
          <h3 class="text-2xl font-black col-span-2">Bienvenido de nuevo
            <?php echo $datosLogin["nombre"] ?>
          </h3>
          <table>
            <ul class="text-base">
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
      </div>
      <!-- Graficos departamento -->
      <div id="graficoDepartamentos"
        class="items-center flex p-2 row-span-2 border-box bg-white rounded-md shadow-2xl transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duraion-300 cursor-pointer">
        <div>
          <canvas class="w-[60vh]" id="departmentMoney"></canvas>
        </div>
      </div>
      <!-- Ultimos empleados dado de alta -->
      <div
        class="flex p-2 gap-3 border-box items-center place-content-center content-center bg-white rounded-md shadow-2xl transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duraion-300 cursor-pointer">
        <span id="contador" class="text-3xl font-extrabold">
          <?php echo $totalEmpleados ?> trabajadores dados de alta
        </span>
      </div>
      <!-- Grafico de tipo de avisos -->
      <div id="graficoAvisos"
        class="items-center flex flex-col justify-center p-2 row-span-3 border-box bg-white rounded-md shadow-2xl transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duraion-300 cursor-pointer">
        <div>
          <?php 
            if($cantidadAvisos == ''){
              ?>
              <center><h3 class='text'>No hay ningún aviso</h3></center>
              <?php
            } else {
              ?>
              <canvas class="w-[60vh]" id="typeWarnings"></canvas>
              <?php
            }
          ?>
        </div>
      </div>
    </div>
  </section>
  <script src="scripts/js/dashboard.js"></script>
  <script>
    document.getElementById("card").onclick = function () {
      window.location.href = "../scripts/php/userEdit/myportlaEdit.php?dni=<?php echo $datosLogin['dni'] ?>&rol=<?php echo $datosLogin["rol"] ?>";
    }

    document.getElementById("graficoDepartamentos").onclick = function () {
      window.location.href = "departamentos.php";
    }

    document.getElementById("graficoAvisos").onclick = function () {
      window.location.href = "avisos.php";
    }

  </script>

  <script>
    const ctx = document.getElementById('departmentMoney');
    const nombresDepartamentos = <?php echo json_encode(array_column($dineroDepart, 'nombre')); ?>;
    const dineroDepartamentos = <?php echo json_encode(array_column($dineroDepart, 'dinero')); ?>;

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: nombresDepartamentos,
        datasets: [{
          label: '€/departamento',
          data: dineroDepartamentos,
          borderWidth: 1,
          backgroundColor: '#41cf1d',
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        }
      }
    });
  </script>

  <script>
    const grafico2 = document.getElementById('typeWarnings');

    const nombresAvisos = <?php echo json_encode(array_column($cantidadAvisos, 'nombre')); ?>;
    const cantidadesAvisos = <?php echo json_encode(array_column($cantidadAvisos, 'cantidad')); ?>;
    const coloresAvisos = <?php echo json_encode(array_map('generarColorAleatorio', $cantidadAvisos)); ?>;

    new Chart(grafico2, {
      type: 'doughnut',
      data: {
        labels: nombresAvisos,
        datasets: [{
          label: 'cantidad de avisos',
          data: cantidadesAvisos,
          borderWidth: 1,
          backgroundColor: coloresAvisos,
        }]
      },
      options: {
        responsive: true,
        plugins: {
          colors: {
            enabled: true
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              display: false
            }
          },
          x: {
            beginAtZero: true,
            grid: {
              display: false
            }
          }
        }
      }

    });
  </script>



  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Obtén el elemento del contador
      var contador = document.getElementById("contador");

      // Obtén el total de empleados desde el contenido del span
      var totalTrabajadores = parseInt(contador.textContent);

      // Inicia la animación
      animateCounter(contador, totalTrabajadores);
    });

    function animateCounter(element, target) {
      var current = 0;
      var increment = 1; // ajustar la velocidad de la animación 
      var interval = 50; // ajustar la frecuencia de actualización

      var animation = setInterval(function () {
        // Actualiza el contenido del elemento con el valor actual
        element.textContent = current + " trabajadores dados de alta";

        // Verificación
        if (current >= target) {
          clearInterval(animation);
        } else {
          // Incrementa el valor actual
          current += increment;
        }
      }, interval);
    }
  </script>


</body>

</html>