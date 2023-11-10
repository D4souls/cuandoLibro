<?php
include("../seguridad/conexion.php");
$id = isset($_GET['id_departamento']) ? $_GET['id_departamento'] : null;

$query_departamentos = "SELECT * FROM departamentos WHERE id_departamento = '$id'";
$resultado_departamentos = mysqli_query($conexion, $query_departamentos);

if ($resultado_departamentos->num_rows > 0) {
    $datos_departamentos = mysqli_fetch_assoc($resultado_departamentos);
?>

    <form action="departmentSave.php" method="get">
        <label for="id_departamento">ID</label>
        <input type="text" name="id_departamento" value="<?php echo $datos_departamentos['id_departamento']; ?>" readonly>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $datos_departamentos['nombre']; ?>">

        <label for="presupuesto">Presupuesto:</label>
        <input type="text" name="presupuesto" value="<?php echo $datos_departamentos['presupuesto']; ?>">

        <button type="submit">Guardar Cambios</button>
    </form>

    <!-- Botón para eliminar al departamento -->
    <form action="departmentDelete.php" method="post">
        <input type="hidden" name="id_departamento" value="<?php echo $datos_departamentos['id_departamento']; ?>">
        <button type="submit">Eliminar Departamento</button>
    </form>

<?php
} else {
    echo "No se encontraron datos para el departamento con ID: $id";
}

// Cerrar la conexión
$conexion->close();
?>
