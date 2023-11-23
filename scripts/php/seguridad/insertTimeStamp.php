<?php
// include("./seguridad.php");
$archivo = __DIR__ . "/logs/archivo.txt";

// Datos de los empleados
$dni = '72210584Z';
$dateTime = date("Y-m-d H:i:s");
$separator = ";";

$contenido = $dni . $separator . $dateTime . "\n";

if ($archivo && file_exists($archivo)) {
    $recurso = fopen($archivo, "a+");

    if ($recurso) {
        fwrite($recurso, $contenido);
        print("[+] Datos insertados correctamente\n");
        fclose($recurso);
    } else {
        print("[!] Error al abrir el archivo");
    }
} else {
    print("[!] El archivo no existe o la ruta es incorrecta");
}

print($contenido);

?>