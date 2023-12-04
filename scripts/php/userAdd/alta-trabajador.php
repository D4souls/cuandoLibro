<?php
include_once('../seguridad/seguridad.php');
include_once('../seguridad/conexion.php');
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

  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <link rel="icon" href="../../../img/logo-alt.png">
  <title>CL | Agregar trabajador</title>
</head>

<body>
  <nav class='sidebar close'>
    <header>
      <div class='image-text'>
        <span class='image'>
          <img src='../../../img/cuandoLibro-logo.png' alt='logoClaro' />
        </span>

        <div class='text header-text'>
          <span class='name'>CuandoLibro</span>
          <span class='profession'>IAW & DB</span>
        </div>
      </div>
      <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class='menu-bar'>
      <div class='menu'>


        <ul class='menu-links'>
          <li class='nav-links'>
            <a href='../../../sites/dashboard.php'>
              <i class='bx bx-home-alt-2 icon'></i>
              <span class='text nav-text'>Dashboard</span>
            </a>
          </li>
          <li class='nav-links'>
            <a href='../../../sites/horarios.php'>
              <i class='bx bx-calendar-alt icon'></i>
              <span class='text nav-text'>Horarios</span>
            </a>
          </li>
          <li class='nav-links'>
            <a href='../../../sites/trabajadores.php'>
              <i class='bx bx-user icon'></i>
              <span class='text nav-text'>Trabajadores</span>
            </a>
          </li>
          <li class='nav-links'>
            <a href='../../../sites/departamentos.php'>
              <i class='bx bx-briefcase-alt-2 icon'></i>
              <span class='text nav-text'>Departamentos</span>
            </a>
          </li>
          <li class='nav-links'>
            <a href='../../../sites/avisos.php'>
              <i class='bx bx-error icon'></i>
              <span class='text nav-text'>Avisos</span>
            </a>
          </li>
        </ul>
      </div>
      <div class='bottom-content'>
        <li class=''>
          <a href='../seguridad/cerrarSesion.php'>
            <i class='bx bx-log-out icon'></i>
            <span class='text nav-text'>Cerrar sesión</span>
          </a>
        </li>

      </div>
    </div>
  </nav>
  <!-- Secciones ocultas -->
  <section class="homeTitle" id="userAdd">
    <div class="contenedor-formulario">
      <form method="POST" class="form">
        <h2 class="text">Agregar usuario</h2>
        <label>DNI:
          <input type="text" placeholder="DNI..." name="dni">
        </label>
        <label>Nombre:
          <input type="text" placeholder="Nombre..." name="nombre">
        </label>
        <label>Apellido 1:
          <input type="text" placeholder="Apellido 1..." name="apellido1">
        </label>
        <label>Apellido 2:
          <input type="text" placeholder="Apellido 2..." name="apellido2">
        </label>
        <label>IBAN:
          <input type="text" placeholder="IBAN..." name="iban" class="extendido">
        </label>
        <label>Correo electrónico:
          <input type="text" placeholder="email..." name="mail">
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
        <button type="button" class="saveButton" id="createUser">Guardar cambios</button>
        <a href="../../../sites/trabajadores.php">Volver atrás</a>
      </form>
    </div>
  </section>

  <script src="../../js/dashboard.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    $(document).ready(function () {
      var categoria = $('#categoria');

      $('#departamento').change(function () {
        var departamento_id = $(this).val();
        if (departamento_id !== '') {
          $.ajax({
            data: { departamento_id: departamento_id },
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

      $('#createUser').click(function () {
        var formData = {
          dni: $('[name="dni"]').val().toUpperCase(),
          nombre: $('[name="nombre"]').val(),
          apellido1: $('[name="apellido1"]').val(),
          apellido2: $('[name="apellido2"]').val(),
          iban: $('[name="iban"]').val().toUpperCase().trim().replace(/\s/g, ''),
          mail: $('[name="mail"]').val(),
          n_departamento: $('[name="n_departamento"]').val(),
          n_categoria: $('[name="n_categoria"]').val(),
        };

        //! DEFINIMOS LOS FILTROS QUE DEBEN TENER DNI & MAIL
        const dniRegex = /^\d{8}[a-zA-Z]$/;
        const emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

        //! COMPROBAMOS IBAN

        function validarIBAN(iban) {
          iban = iban.replace(/\s+/g, '').toUpperCase();

          // Verificar longitud del IBAN
          if (iban.length < 15) {
            return false; // Longitud mínima incorrecta
          }

          // Mover los primeros cuatro caracteres al final
          iban = iban.substring(4) + iban.substring(0, 4);

          // Convertir letras a números
          var letraNumeros = '';
          for (var i = 0; i < iban.length; i++) {
            var charCode = iban.charCodeAt(i);
            if (charCode >= 65 && charCode <= 90) {
              letraNumeros += (charCode - 55).toString();
            } else {
              letraNumeros += iban.charAt(i);
            }
          }

          // Verificar si es divisible por 97
          return parseInt(letraNumeros) % 97 === 1;
        }

        if (formData.dni === '' || formData.nombre === '' || formData.apellido1 === '' || formData.apellido2 === '' || formData.n_departamento === '' || formData.n_categoria === '' || formData.iban === '' || formData.mail === '') {
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
          if (dniRegex.test(formData.dni)) { //! COMPROBAMOS FORMATO DNI
            if (emailRegex.test(formData.mail)) { //! COMPROBAMOS MAIL
              $.ajax({
                url: 'userAdd.php',
                type: 'post',
                data: formData,
                success: function (response) {
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
                      window.location.href = "../../../sites/trabajadores.php";
                    }, 3000)
                    //! SI NO HACE NADA DEVUELVE ERROR
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

            } else {
              Swal.fire({
                title: "Correo electrónico no válido",
                icon: "error",
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
              });
            }
          } else {
            Swal.fire({
              title: "DNI no válido",
              icon: "error",
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
            });
          }

        }
      });
    });
  </script>
</body>

</html>