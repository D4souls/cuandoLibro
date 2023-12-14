<?php
include("../seguridad/conexion.php");
include("../seguridad/seguridad.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../css/dashboard.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../js/alerts.js"></script>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="icon" href="../../../img/logo-alt.png">
    <title>CL | Editar perfil</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../../../img/cuandoLibro-logo.png" alt="logoClaro" />
                </span>
            </div>
            <i class="bx bx-chevron-right toggle"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <ul class="menu-links">
                    <li class="nav-links">
                        <a href="../dashboard.php">
                            <i class="bx bx-home-alt-2 icon"></i>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="horarios.php">
                            <i class="bx bx-calendar-alt icon"></i>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="trabajadores.php">
                            <i class="bx bx-user icon"></i>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="departamentos.php">
                            <i class="bx bx-briefcase-alt-2 icon"></i>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="avisos.php">
                            <i class="bx bx-error icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li class="">
                    <a href="../seguridad/cerrarSesion.php">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">Cerrar sesión</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <section class="homeTitle" id="trabajadores">
        <div class="contenedor-formulario">
            <?php
            $dni_empleado = $_GET['dni'];
            $rol = $_GET["rol"];

            $query_empleado = "SELECT e.dni, e.nombre, e.apellido1, e.apellido2, e.IBAN, n_departamento, n_categoria, c.nombre AS 'nombreCategoria', d.nombre AS 'nombreDepartamento' FROM empleados e INNER JOIN categorias c ON c.id_categoria = e.n_categoria INNER JOIN departamentos d ON d.id_departamento = e.n_departamento WHERE dni = '$dni_empleado'";
            $resultado_empleado = mysqli_query($conexion, $query_empleado);

            if ($resultado_empleado && $resultado_empleado->num_rows > 0) {
                $datos_empleado = mysqli_fetch_assoc($resultado_empleado);
                ?>

                <form action="myPortalSave.php" method="get" class="form flex flex-cols" id="scheduleForm">
                    <h2 class="text">Modificar trabajador</h2>

                    <label for="nombre">Nombre:

                        <input type="text" name="nombre" value="<?php echo $datos_empleado['nombre']; ?>">
                    </label>

                    <label for="apellido1">Apellido 1:
                        <input type="text" name="apellido1" value="<?php echo $datos_empleado['apellido1']; ?>">

                    </label>

                    <label for="apellido2">Apellido 2:

                        <input type="text" name="apellido2" value="<?php echo $datos_empleado['apellido2']; ?>">
                    </label>

                    <label for="IBAN">IBAN:

                        <input type="text" name="IBAN" size="24" value="<?php echo $datos_empleado['IBAN']; ?>">
                    </label>

                    <label>Contraseña:
                        <input type="password" name="userpassword">
                    </label>

                    <button class="addButton" type="button" onclick="changePhoto()">Seleccionar Foto</button>
                    <button class="saveButton">Guardar Cambios</button>
                    <?php
                    if ($rol === "1") {
                        print("<a href='../../../sites/my-portal.php'>Volver atrás</a>");
                    } else {
                        print("<a href='../../../dashboard.php'>Volver atrás</a>");
                    }
                    ?>
                </form>

                <?php
            } else {
                echo "No se encontraron datos para el trabajador con DNI: $dni_empleado";
            }

            // Cerrar la conexión
            $conexion->close();
            ?>
        </div>
    </section>
    <!-- <script src="../scripts/js/dashboard.js"></script> -->
    <script src="../../js/dashboard.js"></script>
    <script>

        function changePhoto(){
            window.location.href = "../userImages/cambiar-imagen.php?dni=<?php echo $dni_empleado ?>";
        }

    </script>
</body>

</html>