<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar la clase PHPMailer
require 'vendor/autoload.php';

function sendMail($data)
{
    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    $correo = "cuandolibro@outlook.es";
    $password = "donbosco787";
    $nombre = "Administración Cuando Libro";
    $host = "smtp.office365.com";

    $nombreCompleto = $data["nombre"] . " " . $data["apellido1"] . " " . $data["apellido2"];
    $mailDestinatario = $data["mail"];
    $fechaSinFormato = strtotime($data["fechaTurno"]);
    $fechaTurno = date("d/m/Y", $fechaSinFormato);
    $hora_entradaReal = $data["hora_entradaReal"];
    $hora_entradaTrabajador = $data["hora_entradaTrabajador"];
    $diferenciaTiempo = $data["diferenciaTiempo"];

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
        <html>
            <head></head>
            <body>
                <h2>Hola <b>{$nombreCompleto}</b>!</h2>
                <p>Hemos detectado una anomalía en el turno del día <b>{$fechaTurno}</b></p>
                <table>
                    <tr>
                        <th>Hora de turno</th>
                        <th>Fecha fichaje</th>
                        <th>Diferencia de tiempo</th>
                    </tr
                    <tr>
                        <td>{$hora_entradaTrabajador}</td>
                        <td>{$hora_entradaReal}</td>
                        <td>{$diferenciaTiempo->format('%H:%I:%S')}</td>
                    </tr>
                </table>
            </body>
        </html>
        ";

        // Enviar el correo
        $mail->send();
        return "📩 Correo enviado correctamente\n";
    } catch (Exception $e) {
        return "❌ Error al enviar el correo: " . $e->getMessage()."\n";
    }
}

?>