<?php
include('../seguridad/conexion.php');
include("../seguridad/conexion.php");
$id_departamento = $_GET["id_departamento"];
$nombre_departamento = $_GET["nombre_departamento"];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#695CFE" />
    <link href="../../../css/dashboard.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.all.min.js"></script>
    <script src="../../js/dashboard.js"></script>
    <link rel="icon" href="../../../img/logo-alt.png">
    <title>CL | Nueva categoría</title>
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
            </div>
        </div>
    </nav>

    <section class="homeTitle" id="categoryAdd">
        <div class="contenedor-formulario">
            <form class="form">
                <h2 class="text">Nueva categoria</h2>
                <input type="hidden" name="n_departamento" value="<?php echo $id_departamento ?>">
                <label>Nombre:
                    <input type="text" placeholder="Nombre..." name="nombre">
                </label>
                <label>Sueldo base:
                    <input type="number" step="0.01" placeholder="Sueldo base..." name="sueldo_normal">
                </label>
                <label>Sueldo plus:
                    <input type="number" step="0.01" placeholder="Sueldo plus..." name="sueldo_plus">
                </label>
                </select>
                <button type="button" onclick="categoryAdd()" class="saveButton">Guardar Cambios</button>
            </form>
        </div>
    </section>
    <script>
        function categoryAdd() {

            var formData = {
                n_departamento: $('[name="n_departamento"]').val(),
                nombre: $('[name="nombre"]').val(),
                sueldo_normal: $('[name="sueldo_normal"]').val(),
                sueldo_plus: $('[name="sueldo_plus"]').val()
            }


            if (formData.n_departamento === '' || formData.nombre === '' || formData.sueldo_normal === '' || formData.sueldo_plus === '') {
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
                    url: 'categoryAdd.php',
                    type: 'post',
                    data: formData,
                    success: function (response) {
                        // console.log(response);
                        var result = JSON.parse(response);

                        if (result.success) {
                            Swal.fire({
                                title: "Categoría creada correctamente.",
                                icon: "success",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                            setTimeout(function () {
                                window.location.href = "../../../sites/categorias.php?id_departamento=<?php echo $id_departamento?>&nombre_departamento=<?php echo $nombre_departamento?>";
                            }, 3000);

                            // Redirigir o realizar otras acciones necesarias después del éxito
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