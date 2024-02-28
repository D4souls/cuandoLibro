<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar la clase PHPMailer
require 'vendor/autoload.php';

function sendMail($data)
{
    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    $correo = "";
    $password = "";
    $nombre = "Administración Cuando Libro";
    $host = "";

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
        <!DOCTYPE html>
            <html>
            <head></head>
            <body style='font-family: 'QuickSand', sans-serif; margin: 0; padding: 20px;'>
                <h2>Hola <b>{$nombreCompleto}</b>!</h2>
                <p>Hemos detectado una anomalía en el turno del día <b>{$fechaTurno}</b></p>
                <table style='border-collapse: collapse; width: 100%; margin-top: 10px;'>
                    <tr style='background-color: #41cf1d; color: #FFF;'>
                        <th style='padding: 10px; text-align: left;'>Hora de turno</th>
                        <th style='padding: 10px; text-align: left;'>Fecha fichaje</th>
                        <th style='padding: 10px; text-align: left;'>Diferencia de tiempo</th>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'>{$hora_entradaTrabajador}</td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>{$hora_entradaReal}</td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>{$diferenciaTiempo->format('%H:%I:%S')}</td>
                    </tr>
                </table>
            </body>
            </html>

        ";

        // Enviar el correo
        $mail->CharSet = 'UTF-8';
        $mail->send();
        return "📩 Correo enviado correctamente\n";
    } catch (Exception $e) {
        return "❌ Error al enviar el correo: " . $e->getMessage()."\n";
    }
}

?>
