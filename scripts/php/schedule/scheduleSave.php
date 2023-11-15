<?php 
include("../seguridad/conexion.php");
if ($conexion->connect_error){
    die("[!] Error en la conexión: ". $conexion->connect_error);
} else {
    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        $horario = $_POST['horario'];
        $categoria = $_POST['n_categoria'];
        $departamento = $_POST['n_departamento'];
        $fecha = $_POST['fecha'];
        $cantidad = $_POST['cantidad'];

        $contador = 0;

        while($contador < $cantidad){
            $query = "INSERT INTO turnos_publicados(categoria, departamento, fecha, id_turno) VALUES(?, ?, ?, ?)";
            $resultado = $conexion->prepare($query);
            $resultado->bind_param("iisi", $categoria, $departamento, $fecha, $horario);
            $resultado->execute();
            $contador++;
        }
        echo "<h2>Turnos publicados correctamente!</h2>\n<a href='../../../sites/horarios.php'>Volver atrás</a>";
        $conexion->close();
    } else {
        echo "[!] DATOS NO ENVIADOS CORRECTAMENTE";
    }
}
?>