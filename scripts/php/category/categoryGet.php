<?php
include("../seguridad/conexion.php");

$departamento_id = filter_input(INPUT_POST, 'departamento_id');

if($departamento_id != ''){
    $sql = "SELECT * FROM categorias WHERE id_departamento = ".$departamento_id;
    $query = mysqli_query($conexion, $sql);
    $filas = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $conexion->close();
}
?>

<option value="">- Selecciona una categoria -</option>
<?php foreach($filas as $op): ?>
    <option value="<?= $op['id_categoria']?>"><?= $op['nombre']?></option> 
<?php endforeach; ?>
