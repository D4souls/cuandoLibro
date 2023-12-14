<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar la clase PHPMailer
require 'vendor/autoload.php';

function sendWelcome($data)
{
    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    $correo = "cuandolibro@outlook.es";
    $password = "donbosco787";
    $nombre = "Administración Cuando Libro";
    $host = "smtp.office365.com";

    $nombreCompleto = $data["nombre"] . " " . $data["apellido1"] . " " . $data["apellido2"];
    $mailDestinatario = $data["mail"];
    $userWeb = strtoupper(substr($data['nombre'], 0, 1)). "." . $data['apellido1'];

    try {
        // Configurar el servidor SMTP
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $correo;
        $mail->Password = $password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        if(!$mail->smtpConnect()){
            return "❌ Error al conectar con el servidor SMTP: " . $mail->ErrorInfo . "\n";
        }

        // Configurar el remitente y destinatario
        $mail->setFrom($correo, $nombre);
        $mail->addAddress($mailDestinatario, $nombreCompleto);

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
                <p>Te damos la bienvenida a la empresa. Este será el correo electrónico por el cual
                se enviarán todas las notificaciones. Te proporcionamos tus credenciales para que puedas acceder al sistema:</p>
                <ul>
                    <li><b>Usuario: {$userWeb}</b></li>
                    <li><b>Contraseña: </b>{$data['dni']}</li>
                </ul>
                <h3>Recuerda</h3>
                <p>Cuando inicies sesión por pimera vez haz click en tu tarjeta de información personal y cambia la contraseña para evitar <i>hackeos</i>.</p>
                <p></p>
            </body>
        </html>
        ";

        $mail->CharSet = 'UTF-8';
        $mail->send();
        return "📩 Correo enviado correctamente\n";
    } catch (Exception $e) {
        return "❌ Error al enviar el correo: " . $e->getMessage()."\n";
    }
}

?>