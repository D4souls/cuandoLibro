<?php
function eliminar_acentos($cadena)
{

    //Reemplazamos la A y a
    $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena);

    //Reemplazamos la I y i
    $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena);

    //Reemplazamos la O y o
    $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena);

    //Reemplazamos la U y u
    $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena);

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('N', 'n', 'C', 'c'),
        $cadena
    );

    return $cadena;
}

function crearFoto($nombreCompleto, $dni)
{

    $palabras = explode(' ', $nombreCompleto);

    $texto = '';

    foreach ($palabras as $letra) {
        $texto .= strtoupper(substr($letra, 0, 1));
    }

    $ruta = "../userImages/img/" . strtoupper($dni) . ".png";
    $im = imagecreatetruecolor(600, 600);

    $colorFondo = imagecolorallocate($im, 65, 207, 29);
    $colorTexto = imagecolorallocate($im, 255, 255, 255);

    imagefill($im, 0, 0, $colorFondo);

    imagefilledrectangle($im, 0, 0, 600, 600, $colorFondo);

    $fuente = "../userAdd/fuentes/Quicksand-Medium.ttf";

    if (!file_exists($fuente)) {
        imagedestroy($im);
        return false;
    }

    $fontSize = 200;

    $bbox = imagettfbbox($fontSize, 0, $fuente, $texto);

    $x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2) - 20;
    $y = $bbox[1] + (imagesy($im) / 2) - ($bbox[5] / 2) - 5;

    imagettftext($im, $fontSize, 0, $x, $y, $colorTexto, $fuente, $texto);

    imagepng($im, $ruta);

    imagedestroy($im);

    return true;
}

// Descomenta la siguiente línea para probar la función
// $quitarAcentos = eliminar_acentos("José Antonio Ávila");
// crearFoto($quitarAcentos, "12774250G");
?>