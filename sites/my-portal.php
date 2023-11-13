<?php
include('../scripts/php/seguridad/seguridad.php');
include('../scripts/php/seguridad/conexion.php');
$dniUsuarioWeb = $_SESSION["userwebdni"];

$query_trabajador = "SELECT * FROM empleados WHERE dni = ?";
$query_obtener_trabajador = $conexion->prepare($query_trabajador);
$query_obtener_trabajador->bind_param("s", $dniUsuarioWeb);
$query_obtener_trabajador->execute();

$query_obtener_trabajador->store_result();

if ($query_obtener_trabajador->num_rows > 0) {
    $query_obtener_trabajador->bind_result($dni, $nombre, $apellido1, $apellido2, $IBAN, $n_categoria, $n_departamento);
    $query_obtener_trabajador->fetch();
    // Cerrar la consulta después de haberla utilizado
    $query_obtener_trabajador->close();
} else {
    // No se encontraron resultados, manejar de acuerdo a tu lógica
    $query_obtener_trabajador->close();
}

$nombreCompleto = $nombre . " " . $apellido1 ." ". $apellido2;

$query_nombreCategoria = "SELECT * FROM categorias WHERE id_categoria = ?";
$query_obtener_nombreCategoria = $conexion->prepare($query_nombreCategoria);
$query_obtener_nombreCategoria->bind_param("s", $n_categoria);
$query_obtener_nombreCategoria->execute();
$query_obtener_nombreCategoria->store_result();


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
        <?php echo $nombre . " ". $apellido1 . " " . $apellido2 ?>
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
            <h3>Bienvenido de nuevo <?php echo $nombreCompleto ?></h3>
            <table>
                <ul>
                    <li>Departamento: <?php echo $nombreCategoria ?></li>
                    <li>Categoria: <?php ?></li>
                </ul>
            </table>
            <span>Última conexión: 12/11/2023 23:27</span>
            <div class="edit-userweb">
                <i class='bx bx-edit'></i>
            </div>
        </div>
    </section>
    <script src="../scripts/js/dashboard.js"></script>
</body>

</html>