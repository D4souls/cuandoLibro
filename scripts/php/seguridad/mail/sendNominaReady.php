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
        <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8' />
                <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                <meta name='theme-color' content='#695CFE' />
            </head>
            <body style='font-family: 'QuickSand', background-color: #E4E9F7; color: #707070; sans-serif; margin: 0; padding: 20px;'>
                <h2 style='color: #41cf1d;'>¡Hola <b>{$data['nombre']}</b>!</h2>
                <p style='margin-top: 10px;'>Ya está disponible la nómina del {$fechaActual}. Accede a tu <a href='localhost' style='color: #41cf1d; text-decoration: none; border-bottom: 1px solid #41cf1d;'>portal personal</a> para poder descargarla.</p>
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