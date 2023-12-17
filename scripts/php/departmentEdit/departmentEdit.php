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
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.all.min.js"></script>
    <link rel="icon" href="../../../img/logo-alt.png">
    <title>CL | Editando departamentos</title>
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
                    <li class='nav-links'>
                        <a href='http://localhost/phpmyadmin/index.php?route=/database/structure&db=fichajedb' target='_blank'>
                            <i class='bx bx-data icon'></i>
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

    <section class="homeTitle" id="department">
        <div class="contenedor-formulario">
            <?php
            include("../seguridad/conexion.php");
            $id = isset($_GET['id_departamento']) ? $_GET['id_departamento'] : null;

            $query_departamentos = "SELECT * FROM departamentos WHERE id_departamento = '$id'";
            $resultado_departamentos = mysqli_query($conexion, $query_departamentos);

            if ($resultado_departamentos->num_rows > 0) {
                $datos_departamentos = mysqli_fetch_assoc($resultado_departamentos);
                ?>

                <form method="post" class="form" id="scheduleForm">
                    <h2 class="text">Editar departamento</h2>
                    <input type="hidden" name="id_departamento"
                        value="<?php echo $datos_departamentos['id_departamento']; ?>" readonly>


                    <label for="nombre">Nombre:
                        <input type="text" name="nombre" value="<?php echo $datos_departamentos['nombre']; ?>">
                    </label>


                    <label for="presupuesto">Presupuesto:
                        <input type="number" step="0.01" name="presupuesto" value="<?php echo $datos_departamentos['presupuesto']; ?>">
                    </label>

                    <button onclick="saveChanges()" type="button" class="saveButton">Guardar Cambios</button>
                    <button onclick="changeToCategory()" type="button" class="addButton">Ver categorías</button>
                    <button onclick="deleteDepartment()" type="button" class="deleteButton">Eliminar departamento</button>
                    <a href="../../../sites/departamentos.php">Volver atrás</a>
                </form>
                <?php
            } else {
                echo "No se encontraron datos para el departamento con ID: $id";
            }


            // Cerrar la conexión
            $conexion->close();
            ?>
        </div>
    </section>
    <script src="../../js/dashboard.js"></script>
    <script>

        //! GUARDAR CAMBIOS

        function saveChanges() {
            var formData = {
                id: $('[name=id_departamento]').val(),
                nombre: $('[name=nombre]').val(),
                presupuesto: $('[name=presupuesto]').val(),
            }

            if (formData.nombre === '' || formData.presupuesto === '') {
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
                                title: "Datos del departamento actualizados.",
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

                            // Redirigir o realizar otras acciones necesarias después del éxito
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: result.message,
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

        //! ELIMINAR DEPARTAMENTO

        function deleteDepartment() {

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará el departamento. Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {

                    //* DATOS DEL FORMULARIO

                    var formData = {
                        id: $('[name=id_departamento]').val()
                    }

                    $.ajax({
                        url: 'departmentDelete.php',
                        type: 'post',
                        data: formData,
                        success: function (response) {
                            var result = JSON.parse(response);
                            // console.log(result);

                            if (result.success) {
                                Swal.fire({
                                    title: "Departamento eliminado correctamente.",
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

                                // Redirigir o realizar otras acciones necesarias después del éxito
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.message,
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
            });
        }

        //! ACCEDER A categorías

        function changeToCategory() {
            window.location.href = '../../../sites/categorias.php?id_departamento=<?php echo $_GET['id_departamento']?>&nombre_departamento=<?php echo $datos_departamentos['nombre']?>'
        }
    </script>
</body>

</html>