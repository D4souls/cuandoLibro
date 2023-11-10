<?php
include('../seguridad/seguridad.php');
#Generador de IBAN
$numeroPaises = array(1, 2, 3, 4);
$indiceAleatorio = array_rand($numeroPaises); # Devuelve una posición aleatoria del array
$numeroAleatorio = $numeroPaises[$indiceAleatorio]; # Devuelve el valor del array en la posición generada aleatoriamente

function generadorIBAN($i)
{
    switch ($i) {
        case 1:
            $iban = "ES" . mt_rand(1000, 9999) . mt_rand(1000, 9999) . mt_rand(10000000000000, 99999999999999);
            return $iban;
            break;
        case 2: // Andorra
            $iban = "AD" . mt_rand(1000, 9999) . mt_rand(1000, 9999) . mt_rand(10000000000000, 99999999999999);
            return $iban;
            break;
        case 3: // Portugal
            $iban = "PT2" . mt_rand(1000, 9999) . mt_rand(1000, 9999) . mt_rand(10000000000, 99999999999) . mt_rand(10, 99) . mt_rand(0, 9);
            return $iban;
            break;
        case 4: // Francia
            $iban = "FR" . mt_rand(10000, 99999) . mt_rand(10000, 99999) . mt_rand(10000000000, 99999999999) . mt_rand(10, 99) . mt_rand(10, 99);
            return $iban;
            break;
        default:
            return "Número de país no válido";
    }
}

generadorIBAN($numeroAleatorio);

#return "\n$indiceAleatorio" . "\n$numeroAleatorio";