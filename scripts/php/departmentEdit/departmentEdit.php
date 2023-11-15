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
        <input type="text" name="presupuesto" value="<?php echo $datos_departamentos['presupuesto'] . "€"; ?>">

        <button type="submit">Guardar Cambios</button>
    </form>

    <!-- Botón para eliminar al departamento -->
    <form action="departmentDelete.php" method="post">
        <input type="hidden" name="id_departamento" value="<?php echo $datos_departamentos['id_departamento']; ?>">
        <button type="submit">Eliminar Departamento</button>
    </form>

    <h3>Categorías del departamento de
        <?php echo $datos_departamentos['nombre'] ?>
    </h3>


    <table>
        <tr>
            <th>Nombre</th>
            <th>Sueldo normal</th>
            <th>Sueldo Plus</th>
        </tr>
        <tr>
            <?php
            $query_categorias = "SELECT * FROM categorias WHERE id_departamento = $id";
            $resulatado_categorias = mysqli_query($conexion, $query_categorias);
            while ($datos_categoria = mysqli_fetch_assoc($resulatado_categorias)) {
                echo "<tr>";
                echo "<td>
                        <form method='post'>
                            <input type='hidden' name='id_categoria' value='" . $datos_categoria['id_categoria'] . "'>
                            <input type='hidden' name='id_departamento' value='" . $datos_departamentos['id_departamento'] . "'>
                            <input type='text' name='nombre' value='" . $datos_categoria['nombre'] . "'>
                            <input type='text' name='sueldo_normal' value='" . $datos_categoria['sueldo_normal'] . "'>
                            <input type='text' name='sueldo_plus' value='" . $datos_categoria['sueldo_plus'] . "'>
                            <button type='submit' formaction='../category/categoryDelete.php'>Eliminar</button>
                            <button type='submit' formaction='../category/categorySave.php'>Guardar</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tr>
    </table>

    <form method="post" action="../category/categoryAdd.php">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="text" name="nombre" placeholder="Nombre">
        <input type="number" name="sueldo_normal" placeholder="Sueldo Normal">
        <input type="number" name="sueldo_plus" placeholder="Sueldo Plus">
        <button>Crear categoría</button>
    </form>
<?php
} else {
    echo "No se encontraron datos para el departamento con ID: $id";
}


// Cerrar la conexión
$conexion->close();
?>

<a href="../../../sites/departamentos.php">Volver atrás</a>ª