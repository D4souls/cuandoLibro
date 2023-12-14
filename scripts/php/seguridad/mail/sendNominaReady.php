<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar la clase PHPMailer
require 'vendor/autoload.php';

function sendNominaReady($data)
{
    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    $correo = "cuandolibro@outlook.es";
    $password = "donbosco787";
    $nombre = "Administración Cuando Libro";
    $host = "smtp.office365.com";

    $mailDestinatario = $data["mail"];
    $empleadoNombre = $data['nombre'] . ' ' . $data['apellidos'];
    $fechaActual = date('m-Y');

    try {
        // Configurar el servidor SMTP
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $correo;
        $mail->Password = $password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        if (!$mail->smtpConnect()) {
            return "❌ Error al conectar con el servidor SMTP: " . $mail->ErrorInfo . "\n";
        }

        // Configurar el remitente y destinatario
        $mail->setFrom($correo, $nombre);
        $mail->addAddress($mailDestinatario, $empleadoNombre);

        // Configurar el asunto y cuerpo del mensaje
        $mail->isHTML(true);
        $mail->Subject = '🔔 Nueva notificación';
        $mail->Body = "
        <html lang='es'>
            <head>
            <meta charset='UTF-8' />
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            <meta name='theme-color' content='#695CFE' />
            </head>
            <body>
                <h2>¡Hola <b>{$data['nombre']}</b>!</h2>
                <p>Ya está disponible la nomina de {$fechaActual}. Accede a tu <a href='localhost'>portal personal</a> para poderla descargar.</p>
            </body>
        </html>
        ";

        $mail->CharSet = 'UTF-8';
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "❌ Error al enviar el correo: " . $e->getMessage() . "\n";
    }
}

?>