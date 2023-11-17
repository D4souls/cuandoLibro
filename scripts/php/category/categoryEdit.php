<?php
include('../seguridad/conexion.php');
include("../seguridad/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#695CFE" />
    <link href="../../../css/dashboard.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="../../../img/logo-alt.png">
    <title>CL | Editando categorías</title>
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

    <section class="homeTitle" id="department">
    <div class="contenedor-formulario">
            <?php
            include("../seguridad/conexion.php");
            $id_categoria = isset($_GET['id_categoria']) ? $_GET['id_categoria'] : null;
            $id_departamento = isset($_GET['id_departamento']) ? $_GET['id_departamento'] : null;
            $nombre_departamento = isset($_GET['nombre_departamento']) ? $_GET['nombre_departamento'] : null;

            $query_departamentos = "SELECT * FROM categorias WHERE id_categoria = '$id_categoria'";
            $resultado_departamentos = mysqli_query($conexion, $query_departamentos);

            if ($resultado_departamentos->num_rows > 0) {
                $datos_departamentos = mysqli_fetch_assoc($resultado_departamentos);
            ?>

                <form action="categorySave.php" method="get" class="form" id="scheduleForm">
                <h2 class="text">Editar categoria</h2>
                <input type="hidden" name="id_departamento" value="<?php echo $datos_departamentos['id_departamento']; ?>">
                    <label for="id_categoria">ID:
                        <input type="text" name="id_categoria" value="<?php echo $datos_departamentos['id_categoria']; ?>" readonly>
                    </label>

                    <label for="nombre">Nombre:
                        <input type="text" name="nombre" value="<?php echo $datos_departamentos['nombre']; ?>">
                    </label>
                    

                    <label for="sueldo_normal">Sueldo base:
                        <input type="text" name="sueldo_normal" value="<?php echo $datos_departamentos['sueldo_normal'] . "€"; ?>">
                    </label>
                    <label for="sueldo_plus">Sueldo plus:
                        <input type="text" name="sueldo_plus" value="<?php echo $datos_departamentos['sueldo_plus'] . "€"; ?>">
                    </label>
                    

                    <button class="saveButton">Guardar Cambios</button>
                    <button onclick="changeActionAndSubmit()" type="button" class="deleteButton">Eliminar categoría</button>
                    <a href="../../../sites/categorias.php?id_departamento=<?php echo $id_departamento?>&nombre_departamento=<?php echo $nombre_departamento?>">Volver atrás</a>
                </form>
            <?php
            } else {
                echo "No se encontraron datos para el departamento con ID: $id_categoria";
            }


            // Cerrar la conexión
            $conexion->close();
            ?>

        </div>
    </section>
    <script src="../../js/dashboard.js"></script>
    <script>
        function changeActionAndSubmit() {
            var form = document.getElementById("scheduleForm");
            form.action = "categoryDelete.php";  // Cambia la acción del formulario
            form.submit();  // Envía el formulario
        }
    </script>
</body>

</html>