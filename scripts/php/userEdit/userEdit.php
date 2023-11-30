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
        <?php
        $stmtMessage = isset($_GET['status']) ? $_GET['status'] : '';
        ?>
        <div id="resultado"></div>
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
                        <input type="text" name="IBAN" value="<?php echo $datos_empleado['IBAN']; ?>">
                    </label>

                    <label for="IBAN">email:
                        <input type="text" name="mail" value="<?php echo $datos_empleado['mail']; ?>">
                    </label>

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

                    <button type="button" class="saveButton" id="saveChanges">Guardar Cambios</button>
                    <button onclick="resetPassword()" type="button" class="addButton">Reestablecer contraseña</button>
                    <button onclick="deleteEmployee()" type="button" class="deleteButton">Eliminar trabajador</button>
                    <a href="../../../sites/trabajadores.php">Volver atrás</a>
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
                    var form = document.getElementById("scheduleForm");
                    form.action = "userDelete.php";
                    form.submit();
                }
            });
        }

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
                    var form = document.getElementById("scheduleForm");
                    form.action = "resetPassword.php";
                    form.submit();
                }
            });
        }
        $(document).ready(function() {
            var categoria = $('#categoria');

            $('#departamento').change(function() {
                var departamento_id = $(this).val();
                if (departamento_id !== '') {
                    $.ajax({
                        data: {
                            departamento_id: departamento_id
                        },
                        dataType: 'html',
                        type: 'POST',
                        url: '../category/categoryGet.php'
                    }).done(function(data) {
                        categoria.html(data);
                        categoria.prop('disabled', false);
                    });
                } else {
                    categoria.val('');
                    categoria.prop('disabled', true);
                }
            });

            $('#saveChanges').click(function() {
                // Obtener valores de los campos del formulario
                var formData = {
                    dni: $('[name="dni"]').val(),
                    nombre: $('[name="nombre"]').val(),
                    apellido1: $('[name="apellido1"]').val(),
                    apellido2: $('[name="apellido2"]').val(),
                    IBAN: $('[name="IBAN"]').val(),
                    mail: $('[name="mail"]').val(),
                    n_departamento: $('[name="n_departamento"]').val(),
                    n_categoria: $('[name="n_categoria"]').val()
                };

                $.ajax({
                    url: 'userSave.php',
                    type: 'post',
                    data: formData,
                    success: function(response) {
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
                            setTimeout(function() {
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
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la solicitud AJAX',
                            text: 'Hubo un problema al enviar los datos. Por favor, inténtalo de nuevo.'
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>