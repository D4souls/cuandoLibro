<?php
include("../seguridad/conexion.php");

if ($conexion->connect_error) {
    die("[!] Conexión fallida: " . $conexion->connect_error);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"];
        $sueldo_normal = $_POST["sueldo_normal"];
        $sueldo_plus = $_POST["sueldo_plus"];
        $departamento_id = $_POST["id"];

        $query_category = "SELECT nombre FROM categorias WHERE nombre = ? AND id_departamento = ?";
        $resultado_comprobacion = $conexion->prepare($query_category);
        $resultado_comprobacion->bind_param("si", $nombre, $departamento_id);
        $resultado_comprobacion->execute();

        if ($resultado_comprobacion->fetch()) {
            print("<h3>[!] Error: Ya hay una categoria igual</h3>\n<a href='../departmentEdit/departmentEdit.php?id_departamento=$departamento_id'>Cerrar ventana</a>");
        } else {
            $query_insert = "INSERT INTO categorias (id_departamento, nombre, sueldo_normal, sueldo_plus) VALUES (?, ?, ?, ?)";
            $resultado_insert = $conexion->prepare($query_insert);
            $resultado_insert->bind_param("isii", $departamento_id, $nombre, $sueldo_normal, $sueldo_plus);

            if ($resultado_insert->execute()) {
                echo "<h3>[+] Categoría creada correctamente!</h3>\n<a href='../departmentEdit/departmentEdit.php?id_departamento=$departamento_id'>Cerrar ventana</a>";
                exit();
            }
        }
    }
}


?>