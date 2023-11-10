<?php
include("../seguridad/conexion.php");
$dni_empleado = $_GET['dni'];

$query_empleado = "SELECT e.dni, e.nombre, e.apellido1, e.apellido2, e.IBAN, n_departamento, n_categoria, c.nombre AS 'nombreCategoria', d.nombre AS 'nombreDepartamento' FROM empleados e INNER JOIN categorias c ON c.id_categoria = e.n_categoria INNER JOIN departamentos d ON d.id_departamento = e.n_departamento WHERE dni = '$dni_empleado'";
$resultado_empleado = mysqli_query($conexion, $query_empleado);

if ($resultado_empleado && $resultado_empleado->num_rows > 0) {
    $datos_empleado = mysqli_fetch_assoc($resultado_empleado);
?>

    <form action="userSave.php" method="get">
        <label for="dni">DNI:</label>
        <input type="text" name="dni" value="<?php echo $datos_empleado['dni']; ?>" readonly>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $datos_empleado['nombre']; ?>">

        <label for="apellido1">Apellido 1:</label>
        <input type="text" name="apellido1" value="<?php echo $datos_empleado['apellido1']; ?>">

        <label for="apellido2">Apellido 2:</label>
        <input type="text" name="apellido2" value="<?php echo $datos_empleado['apellido2']; ?>">

        <label for="IBAN">IBAN:</label>
        <input type="text" name="IBAN" value="<?php echo $datos_empleado['IBAN']; ?>">

        <select name="n_departamento">
            <option value="">- Seleccione un departamento -</option>
            <?php
            // Fetch all departments
            $query_departamentos = "SELECT * FROM departamentos";
            $resultado_departamentos = mysqli_query($conexion, $query_departamentos);

            // Display departments
            while ($departamento = mysqli_fetch_assoc($resultado_departamentos)) {
                $selected = ($departamento['id_departamento'] == $datos_empleado['n_departamento']) ? 'selected' : '';
                echo "<option value='{$departamento['id_departamento']}' $selected>{$departamento['nombre']}</option>";
            }
            ?>
        </select>

        <select name="n_categoria">
            <option value="">- Seleccione una categoría -</option>
            <?php
            // Fetch all categories
            $query_categorias = "SELECT * FROM categorias";
            $resultado_categorias = mysqli_query($conexion, $query_categorias);

            // Display categories
            while ($categoria = mysqli_fetch_assoc($resultado_categorias)) {
                $selected = ($categoria['id_categoria'] == $datos_empleado['n_categoria']) ? 'selected' : '';
                echo "<option value='{$categoria['id_categoria']}' $selected>{$categoria['nombre']}</option>";
            }
            ?>
        </select>

        <button type="submit">Guardar Cambios</button>
    </form>

    <!-- Botón para eliminar al trabajador -->
    <form action="userDelete.php" method="post">
        <input type="hidden" name="dni" value="<?php echo $datos_empleado['dni']; ?>">
        <button type="submit">Eliminar Trabajador</button>
    </form>

<?php
} else {
    echo "No se encontraron datos para el trabajador con DNI: $dni_empleado";
}

// Cerrar la conexión
$conexion->close();
?>