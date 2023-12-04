<?php
include('../seguridad/seguridad.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../css/dashboard.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="../../../img/logo-alt.png">
    <script src="../../js/dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.all.min.js"></script>

    <title>CL | Editar trabajador</title>
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

            $query_empleado = "SELECT e.dni, e.nombre, e.apellido1, e.apellido2, e.IBAN, e.mail, n_departamento, n_categoria, c.nombre AS 'nombreCategoria', d.nombre AS 'nombreDepartamento' FROM empleados e LEFT JOIN categorias c ON c.id_categoria = e.n_categoria LEFT JOIN departamentos d ON d.id_departamento = e.n_departamento WHERE dni = '$dni_empleado'";
            $resultado_empleado = mysqli_query($conexion, $query_empleado);

            if ($resultado_empleado && $resultado_empleado->num_rows > 0) {
                $datos_empleado = mysqli_fetch_assoc($resultado_empleado);
                ?>

                <form method="post" class="form" id="scheduleForm">
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
                        <input type="text" name="IBAN" value="<?php echo $datos_empleado['IBAN']; ?>" class="extendido">
                    </label>

                    <label for="mail">Email:
                        <input type="text" name="mail" value="<?php echo $datos_empleado['mail']; ?>" class="extendido">
                    </label>
                    <select name="n_departamento" id="departamento">
                        <option value="<?php echo $datos_empleado['n_departamento'] ?>">
                            Pertenece:
                            <?php echo $datos_empleado['nombreDepartamento'] ?>
                        </option>
                        <?php
                        // Fetch all departments
                        $query_departamentos = "SELECT * FROM departamentos";
                        $resultado_departamentos = mysqli_query($conexion, $query_departamentos);

                        // Display departments
                        while ($departamento = mysqli_fetch_assoc($resultado_departamentos)) {
                            echo "<option value='{$departamento['id_departamento']}'>{$departamento['nombre']}</option>";
                        }
                        ?>
                    </select>
                    <select name="n_categoria" id="categoria" disabled="">
                        <option value="<?php echo $datos_empleado['n_categoria'] ?>">
                            Pertenece:
                            <?php echo $datos_empleado['nombreCategoria'] ?>
                        </option>
                    </select>

                    <button onclick="saveChanges()" type="button" class="saveButton">Guardar Cambios</button>
                    <button onclick="resetPassword()" type="button" class="addButton">Reestablecer contraseña</button>
                    <?php

                    //! MOSTRAR BOTÓN SI TIENE AVISOS

                    $queryAvisos = "SELECT dni FROM aviso WHERE dni = ?";
                    $stmt_queryAvisos = $conexion->prepare($queryAvisos);

                    if (!$stmt_queryAvisos) {
                        throw new Exception("Error al preparar la comprobación de los avisos: " . $conexion->error);
                    }

                    $stmt_queryAvisos->bind_param("s", $dni_empleado);

                    if (!$stmt_queryAvisos->execute()) {
                        throw new Exception("Error al ejecutar la consulta de comprobación de avisos: " . $stmt_queryAvisos->error);
                    }

                    $resultado_queryAvisos = $stmt_queryAvisos->get_result();

                    if ($resultado_queryAvisos->num_rows > 0) {
                        ?>
                        <button onclick="redirectToWarnings()" type="button" class="addButton">
                            <i class='bx bx-history'></i>
                            Historial de avisos
                        </button>
                        <?php
                    }

                    $stmt_queryAvisos->close();
                    ?>


                    <button onclick="deleteEmployee()" type="button" class="deleteButton">Eliminar trabajador</button>
                    <!-- <a href="../../../sites/trabajadores.php">Volver atrás</a> -->
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

        //! FUNCIÓN AVISOS

        function redirectToWarnings() {

            var formData = {
                dni: $('[name="dni"]').val()
            };

            window.location.href = "historial-avisos.php?dni=" + formData.dni
        }

        //! FUNCIÓN ELIMINAR EMPLEADO

        function deleteEmployee() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará al trabajador. Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {

                    //* DATOS DEL FORMULARIO

                    var formData = {
                        dni: $('[name="dni"]').val()
                    };

                    $.ajax({
                        url: 'userDelete.php',
                        type: 'get',
                        data: { dni: formData.dni },
                        success: function (response) {
                            var result = JSON.parse(response);

                            if (result.success) {
                                Swal.fire({
                                    title: "Usuario eliminado correctamente.",
                                    icon: "success",
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                });
                                setTimeout(function () {
                                    window.location.href = "../../../sites/trabajadores.php";
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

        //! FUNCIÓN RESET PASSWORD

        function resetPassword() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción reiniciará la contraseña del usuario.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, reestrablecer'
            }).then((result) => {
                if (result.isConfirmed) {

                    //* DATOS DEL FORMULARIO

                    var formData = {
                        dni: $('[name="dni"]').val()
                    };

                    $.ajax({
                        url: 'resetPassword.php',
                        type: 'get',
                        data: { dni: formData.dni },
                        success: function (response) {
                            var result = JSON.parse(response);

                            if (result.success) {
                                Swal.fire({
                                    title: "Contraseña reseteada correctamente.",
                                    icon: "success",
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                });
                                setTimeout(function () {
                                    window.location.href = "../../../sites/trabajadores.php";
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

        //! GUARDAR CAMBIOS

        function saveChanges() {

            //* DATOS DEL FORMULARIO

            var formData = {
                dni: $('[name="dni"]').val(),
                nombre: $('[name="nombre"]').val(),
                apellido1: $('[name="apellido1"]').val(),
                apellido2: $('[name="apellido2"]').val(),
                iban: $('[name="IBAN"]').val().toUpperCase().trim().replace(/\s/g, ''),
                mail: $('[name="mail"]').val(),
                n_departamento: $('[name="n_departamento"]').val(),
                n_categoria: $('[name="n_categoria"]').val()
            };

            $.ajax({
                url: 'userSave.php',
                type: 'post',
                data: formData,
                success: function (response) {
                    // console.log(response);
                    var result = JSON.parse(response);

                    if (result.success) {
                        Swal.fire({
                            title: "Datos actualizados",
                            icon: "success",
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        setTimeout(function () {
                            window.location.href = "../../../sites/trabajadores.php";
                        }, 3000);

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

        //! OBTENER CATEGORÍA
        $(document).ready(function () {
            var categoria = $('#categoria');

            $('#departamento').change(function () {
                var departamento_id = $(this).val();
                if (departamento_id !== '') {
                    $.ajax({
                        data: {
                            departamento_id: departamento_id
                        },
                        dataType: 'html',
                        type: 'POST',
                        url: '../category/categoryGet.php'
                    }).done(function (data) {
                        categoria.html(data);
                        categoria.prop('disabled', false);
                    });
                } else {
                    categoria.val('');
                    categoria.prop('disabled', true);
                }
            });
        });
    </script>

</body>

</html>