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
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.all.min.js"></script>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="icon" href="../../../img/logo-alt.png">
    <title>CL | Editar perfil</title>
</head>

<body>

    <?php

    if ($_GET['rol'] == 1) {
        ?>
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
                            <a href="../../../sites/my-portal.php">
                                <i class="bx bx-home-alt-2 icon"></i>
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-links">
                            <a href="../../../sites/my-portal-horarios.php">
                                <i class="bx bx-calendar-alt icon"></i>
                                <span class="text nav-text">Horarios</span>
                            </a>
                        </li>
                        <li class="nav-links">
                            <a href="../../../sites/my-portal-avisos.php">
                                <i class="bx bx-error icon"></i>
                                <span class="text nav-text">Avisos</span>
                            </a>
                        </li>
                        <li class="nav-links">
                            <a href="../../../sites/my-portal-nominas.php">
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
                </div>
            </div>
        </nav>
        <?php
    } else {
        ?>
        <nav class='sidebar close'>
            <header>
                <div class='image-text'>
                    <span class='image'>
                        <img src='../../../img/cuandoLibro-logo.png' alt='logoClaro' />
                    </span>
                </div>
                <i class='bx bx-chevron-right toggle'></i>
            </header>

            <div class='menu-bar'>
                <div class='menu'>


                    <ul class='menu-links'>
                        <li class='nav-links'>
                            <a href='../../../sites/dashboard.php'>
                                <i class='bx bx-home-alt-2 icon'></i>
                            </a>
                        </li>
                        <li class='nav-links'>
                            <a href='../../../sites/horarios.php'>
                                <i class='bx bx-calendar-alt icon'></i>
                            </a>
                        </li>
                        <li class='nav-links'>
                            <a href='../../../sites/trabajadores.php'>
                                <i class='bx bx-user icon'></i>
                            </a>
                        </li>
                        <li class='nav-links'>
                            <a href='../../../sites/departamentos.php'>
                                <i class='bx bx-briefcase-alt-2 icon'></i>
                            </a>
                        </li>
                        <li class='nav-links'>
                            <a href='../../../sites/avisos.php'>
                                <i class='bx bx-error icon'></i>
                            </a>
                        </li>
                        <li class='nav-links'>
                            <a href='http://localhost/phpmyadmin/index.php?route=/database/structure&db=fichajedb'
                                target='_blank'>
                                <i class='bx bx-data icon'></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class='bottom-content'>
                    <li class=''>
                        <a href='../scripts/php/seguridad/cerrarSesion.php'>
                            <i class='bx bx-log-out icon'></i>
                        </a>
                    </li>

                </div>
            </div>
        </nav>
        <?php
    }
    ?>

    <section class="homeTitle" id="trabajadores">
        <div class="contenedor-formulario">
            <?php
            $dni_empleado = $_GET['dni'];
            $rol = $_GET["rol"];

            $query_empleado = "SELECT e.dni, e.nombre, e.apellido1, e.apellido2, e.IBAN, e.mail, n_departamento, n_categoria, c.nombre AS 'nombreCategoria', d.nombre AS 'nombreDepartamento' FROM empleados e INNER JOIN categorias c ON c.id_categoria = e.n_categoria INNER JOIN departamentos d ON d.id_departamento = e.n_departamento WHERE dni = '$dni_empleado'";
            $resultado_empleado = mysqli_query($conexion, $query_empleado);

            if ($resultado_empleado && $resultado_empleado->num_rows > 0) {
                $datos_empleado = mysqli_fetch_assoc($resultado_empleado);
                ?>

                <form class="form flex flex-cols" id="scheduleForm">
                    <h2 class="text">Modificar trabajador</h2>
                    <input type="hidden" name="dni" value="<?php echo $datos_empleado['dni']; ?>" readonly>
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
                        <input type="text" name="IBAN" value="<?php echo $datos_empleado['IBAN']; ?>" readonly>
                    </label>

                    <label for="mail">Email:
                        <input type="text" name="mail" size="24" value="<?php echo $datos_empleado['mail']; ?>">
                    </label>

                    <input type="hidden" name="n_departamento" value="<?php echo $datos_empleado['n_departamento']; ?>" readonly>
                    <input type="hidden" name="n_categoria" value="<?php echo $datos_empleado['n_categoria']; ?>" readonly>

                    <label>Contraseña:
                        <input type="password" name="userpassword">
                    </label>
                    <button type="button" class="saveButton" onclick="saveChanges()">Guardar Cambios</button>
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
    <script>
        function saveChanges() {

            //* DATOS DEL FORMULARIO

            var formData = {
                dni: $('[name="dni"]').val(),
                nombre: $('[name="nombre"]').val(),
                apellido1: $('[name="apellido1"]').val(),
                apellido2: $('[name="apellido2"]').val(),
                mail: $('[name="mail"]').val(),
                userpassword: $('[name="userpassword"]').val(),
            };
            $.ajax({
                url: 'myPortalSave.php',
                type: 'post',
                data: formData,
                success: function (response) {
                    console.log(response);
                    var result = JSON.parse(response);

                    if (result.success) {
                        Swal.fire({
                            title: result.message,
                            icon: "success",
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        setTimeout(function () {
                            window.location.href = "../../../sites/dashboard.php";
                        }, 3000);

                    } else {
                        Swal.fire({
                            title: result.message,
                            icon: "error",
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en la solicitud AJAX',
                        text: 'Hubo un problema al enviar los datos. Por favor, inténtalo de nuevo.'
                    });
                }
            });
        }
    </script>
</body>

</html>