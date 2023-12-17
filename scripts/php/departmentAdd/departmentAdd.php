<?php
include('../seguridad/seguridad.php');
include("../seguridad/conexion.php");
include('../workers/getDataWorkers.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../css/dashboard.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="../../../img/logo-alt.png">
    <!-- <script src="../../js/dashboard.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.all.min.js"></script>

    <title>CL | Nuevo departamento</title>
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
                <ul class="menu-links">
                    <li class="nav-links">
                        <a href="../../../sites/dashboard.php">
                            <i class="bx bx-home-alt-2 icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="../../../sites/horarios.php">
                            <i class="bx bx-calendar-alt icon"></i>
                            <span class="text nav-text">Horarios</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="../../../sites/trabajadores.php">
                            <i class="bx bx-user icon"></i>
                            <span class="text nav-text">Trabajadores</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="../../../sites/departamentos.php">
                            <i class="bx bx-briefcase-alt-2 icon"></i>
                            <span class="text nav-text">Departamentos</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="../../../sites/avisos.php">
                            <i class="bx bx-error icon"></i>
                            <span class="text nav-text">Avisos</span>
                        </a>
                    </li>
                    <li class='nav-links'>
                        <a href='http://localhost/phpmyadmin/index.php?route=/database/structure&db=fichajedb' target='_blank'>
                            <i class='bx bx-data icon'></i>
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
    <section class="homeTitle" id="departmentAdd">
        <div class="contenedor-formulario">
            <form class="form" method="POST" action="../scripts/php/departmentAdd/departmentAdd.php">
                <h2 class="text">Nuevo departamento</h2>
                <label>Nombre:
                    <input type="text" placeholder="Nombre..." name="nombre">
                </label>
                <label>Presupuesto:
                    <input type="number" placeholder="Presupuesto..." name="presupuesto">
                </label>
                <button type="button" onclick="createDepartment()" class="saveButton">Guardar Cambios</button>
            </form>
        </div>
    </section>
    <script src="../scripts/js/dashboard.js"></script>
    <script>
        function createDepartment() {

            //* DATOS DEL FORMULARIO

            var formData = {
                nombre: $('[name="nombre"]').val(),
                presupuesto: $('[name="presupuesto"]').val(),
            };

            if (formData.nombre === '' | formData.presupuesto === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Por favor, completa todos los campos del formulario.',
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            } else {
                $.ajax({
                    url: 'departmentSave.php',
                    type: 'post',
                    data: formData,
                    success: function (response) {
                        // console.log(response);
                        var result = JSON.parse(response);

                        if (result.success) {
                            Swal.fire({
                                title: "Departamento creado correctamente.",
                                icon: "success",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                            setTimeout(function () {
                                window.location.href = "../../../sites/departamentos.php";
                            }, 3000);

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: result.message,
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


        }

    </script>
</body>

</html>