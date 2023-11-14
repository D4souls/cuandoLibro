<?php
include('../scripts/php/seguridad/seguridad.php');
include('../scripts/php/seguridad/conexion.php');
$dniUsuarioWeb = $conexion->real_escape_string($_SESSION["userwebdni"]);

$var_consulta = "SELECT e.dni, e.nombre, e.apellido1, e.apellido2, c.nombre AS 'nombreCategoria', d.nombre AS 'nombreDepartamento' FROM empleados e INNER JOIN categorias c ON c.id_categoria = e.n_categoria INNER JOIN departamentos d ON d.id_departamento = e.n_departamento WHERE e.dni = '$dniUsuarioWeb'";
$var_resultado = $conexion->query($var_consulta);

if (!$var_resultado) {
    die("Error en la consulta: " . $conexion->error);
}

if ($var_resultado->num_rows > 0) {
    $row = $var_resultado->fetch_assoc();

    $dni = $row['dni'];
    $nombre = $row['nombre'];
    $apellido1 = $row['apellido1'];
    $apellido2 = $row['apellido2'];
    $nombreCategoria = $row['nombreCategoria'];
    $nombreDepartamento = $row['nombreDepartamento'];
} else {
    echo "No se encontraron resultados para el usuario con DNI: $dniUsuarioWeb";
}

$var_resultado->close();
$conexion->close();
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
    <title>My site |
        <?php echo $nombre . " " . $apellido1 . " " . $apellido2 ?>
    </title>
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
                        <a href="#horarios">
                            <i class="bx bx-calendar-alt icon"></i>
                            <span class="text nav-text">Horarios</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="#avisos">
                            <i class="bx bx-error icon"></i>
                            <span class="text nav-text">Avisos</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="#avisos">
                            <i class='bx bx-wallet icon'></i>
                            <span class="text nav-text">Nóminas</span>
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
        <div class="text">Dashboard</div>
        <div class="stadisticas">
            <!-- Incluir la imagen del usuario -->
            <div class="user-img">
                <img alt="userImage">
            </div>
            <h3>Bienvenido de nuevo
                <?php echo $nombre . " " . $apellido1 . " " . $apellido2 ?>
            </h3>
            <table>
                <ul>
                    <li>Departamento:
                        <?php echo $nombreDepartamento ?>
                    </li>
                    <li>Categoria:
                        <?php echo $nombreCategoria ?>
                    </li>
                </ul>
            </table>
            <span>Última conexión: <?php echo $timestamp ?></span>
            <div class="edit-userweb">
                <i class='bx bx-edit'></i>
            </div>
        </div>
    </section>
    <script src="../scripts/js/dashboard.js"></script>
</body>

</html>