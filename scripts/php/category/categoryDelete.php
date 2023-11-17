<?php
include("../seguridad/conexion.php");

$departamento_id = $_GET["id_departamento"];
$categoria_id = $_GET["id_categoria"];

$query_delete = "DELETE FROM categorias WHERE id_categoria = " . "'" . $categoria_id . "'";

$stm = $conexion->prepare($query_delete);
$stm->execute();
$stm->close();

echo "<h3>[-] Categoria eliminada correctamente</h3>";
echo "<a href='../../../sites/categorias.php?id_departamento=$departamento_id'>Volver atrás</a>";
?>