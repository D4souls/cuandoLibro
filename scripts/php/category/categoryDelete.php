<?php
include("../seguridad/conexion.php");

$categoria_id = $_POST["id_categoria"];
$departamento_id = $_POST["id_departamento"];

$query_delete = "DELETE FROM categorias WHERE id_categoria = " . "'" . $categoria_id . "'";

$stm = $conexion->prepare($query_delete);
$stm->execute();
$stm->close();

echo "<h3>[-] Categoria eliminada correctamente</h3>";
echo "<a href='../departmentEdit/departmentEdit.php?id_departamento=$departamento_id'>Volver atrás</a>";
?>