<?php
include("../seguridad/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../css/dashboard.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="../../../img/logo-alt.png">
    <title>CL | Editar turno</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../../../img/cuandoLibro-logo.png" alt="logoClaro" />
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
                    <a href="../seguridad/cerrarSesion.php">
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

    <section class="homeTitle" id="trabajadores">
        <div class="contenedor-formulario">
            <?php
            include("../seguridad/conexion.php");
            $dni_empleado = $_GET['dni'];

            $query_empleado = "SELECT e.dni, e.nombre, e.apellido1, e.apellido2, e.IBAN, n_departamento, n_categoria, c.nombre AS 'nombreCategoria', d.nombre AS 'nombreDepartamento' FROM empleados e INNER JOIN categorias c ON c.id_categoria = e.n_categoria INNER JOIN departamentos d ON d.id_departamento = e.n_departamento WHERE dni = '$dni_empleado'";
            $resultado_empleado = mysqli_query($conexion, $query_empleado);

            if ($resultado_empleado && $resultado_empleado->num_rows > 0) {
                $datos_empleado = mysqli_fetch_assoc($resultado_empleado);
                ?>

                <form action="myPortalSave.php" method="get" class="form" id="scheduleForm">
                    <h2 class="text">Modificar trabajador</h2>
                    <label for="dni">DNI:
                        <input type="text" name="dni" value="<?php echo $datos_empleado['dni']; ?>" readonly>
                    </label>

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

                    <label> Departamento:
                        <?php
                        $query_departamentos = "SELECT * FROM departamentos WHERE id_departamento = {$datos_empleado['n_departamento']}";
                        $resultado_departamentos = mysqli_query($conexion, $query_departamentos);

                        if ($resultado_departamentos && $resultado_departamentos->num_rows > 0) {
                            $datosDepartamentos = mysqli_fetch_assoc($resultado_departamentos);
                            ?>
                            <input type="hidden" name="n_departamento" value="<?php echo $datosDepartamentos['id_departamento']?>">
                            <input type="text" name="nombreDepartamento" value="<?php echo $datosDepartamentos['nombre']?>" readonly>
                        <?php
                        } else { ?>
                            <input type="text" name="nombreDepartamento" value="Sin asignar...">
                        <?php
                        } ?>
                    </label>

                    <label> Categoría:
                        <?php
                        $query_categoria = "SELECT * FROM categorias WHERE id_categoria = {$datos_empleado['n_categoria']}";
                        $resultado_categoria = mysqli_query($conexion, $query_categoria);

                        if ($resultado_categoria && $resultado_categoria->num_rows > 0) {
                            $datoscategoria = mysqli_fetch_assoc($resultado_categoria);
                            ?>
                            <input type="hidden" name="n_departamento" value="<?php echo $datoscategoria['id_categoria']?>">
                            <input type="text" name="nombreCategoria" size="40" value="<?php echo $datoscategoria['nombre']?>" readonly>
                        <?php
                        } else { ?>
                            <input type="text" name="nombreCategoria" value="Sin asignar...">
                        <?php
                        } ?>
                    </label>
                    
                    <label>Contraseña:
                        <input type="password" name="userpassword">
                    </label>

                    <button class="saveButton">Guardar Cambios</button>
                    <button onclick="changeActionAndSubmit()" type="button" class="deleteButton">Eliminar trabajador</button>
                    <a href="../../../dashboard.php">Volver atrás</a>
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
        function changeActionAndSubmit() {
            alert('No puedes eliminarte!');
        }
    </script>
</body>

</html>