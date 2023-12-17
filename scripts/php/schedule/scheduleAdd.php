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

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.all.min.js"></script>

    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
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

    <section class="homeTitle" id="trabajadores">
        <div class="contenedor-formulario">
            <form method="post" class="form">
                <h2 class="text">Crear nuevo turno</h2>
                <select name="horario">
                    <option value="">- Seleccione una horario -</option>
                    <?php
                    // Fetch all categories
                    $query_turnos = "SELECT * FROM turnos";
                    $resultado_turnos = mysqli_query($conexion, $query_turnos);

                    // Display categories
                    while ($turnos = mysqli_fetch_assoc($resultado_turnos)) {
                        // $selected = ($turnos['id_turno'] == $datos_empleado['n_categoria']) ? 'selected' : '';
                        echo "<option value='{$turnos['id_turno']}'>{$turnos['nombre']}</option>";
                    }
                    ?>
                </select>
                <select name="n_departamento" id="departamento">
                    <option value="">- Seleccione un departamento -</option>
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
                    <option value="">- Seleccione una categoría -</option>
                </select>
                <label style="text-align: justify;">
                    Fecha:
                    <input type="date" name="fecha">
                </label>
                <label>
                    Cantidad de registros?
                    <input type="number" name="cantidad" id="cantidad" placeholder="1">
                </label>
                <button type="button" class="saveButton" id="createSchedule">Crear turnos</button>
                <a href="../../../sites/horarios.php">Volver atrás</a>
            </form>
        </div>
    </section>
    <script>
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
                        categoria.prop('disabled', categoria.find('option').length === 0);
                    });
                } else {
                    categoria.val('');
                    categoria.prop('disabled', true);
                }
            });

            $('#createSchedule').click(function () {
                var formData = {
                    horario: $('[name="horario"]').val(),
                    n_departamento: $('[name="n_departamento"]').val(),
                    n_categoria: $('[name="n_categoria"]').val(),
                    fecha: $('[name="fecha"]').val(),
                    cantidad: $('[name="cantidad"]').val(),
                };

                if(formData.cantidad === '') {
                    formData.cantidad = 1;
                }

                if (formData.horario === '' || formData.n_departamento === '' || formData.n_categoria === '' || formData.fecha === '') {
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
                    console.log(formData);
                    $.ajax({
                        url: 'scheduleSave.php',
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
                                    window.location.href = "../../../sites/horarios.php";
                                }, 3000)
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
            });
        });

    </script>
</body>

</html>