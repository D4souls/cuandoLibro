<?php
include("../seguridad/conexion.php");
    ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<form action="scheduleSave.php" method="post">
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
    <label>
        Fecha:
        <input type="date" name="fecha">
    </label>
    <label>
        Cantidad de registros?
        <input type="number" name="cantidad" id="cantidad">
    </label>
    <button>Crear turnos</button>
</form>

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
    });
</script>