<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar la clase PHPMailer
require 'vendor/autoload.php';

function sendUpdateSchedule($turnoP, $dni, $conexion)
{
    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    $correo = "cuandolibro@outlook.es";
    $password = "donbosco787";
    $nombre = "Administración Cuando Libro";
    $host = "smtp.office365.com";

    try {

        //? OBTENEMOS DATOS DEL EMPLEADO

        $query = "SELECT e.mail, e.nombre, tp.fecha, t.nombre, t.hora_entrada, t.hora_salida FROM empleados e
    INNER JOIN turnos_publicados tp ON e.dni = tp.dni
    INNER JOIN turnos t ON tp.id_turno = t.id_turno
    WHERE tp.id_turnoP = ? AND e.dni = ?";

        $stmt = $conexion->prepare($query);

        if (!$stmt) {
            throw new Exception($conexion->error);
        }

        $stmt->bind_param("is", $turnoP, $dni);

        if (!$stmt) {
            throw new Exception($conexion->error);
        }

        $stmt->execute();

        if (!$stmt) {
            throw new Exception($conexion->error);
        }

        $stmt->store_result();

        if (!$stmt) {
            throw new Exception($conexion->error);
        }

        if ($stmt->num_rows > 0) {

            //? INICIALIZAMOS VARIABLES

            $mailDestinatario = '';
            $nombreE = '';
            $fechaT = '';
            $nombreT = '';
            $horaEntradaT = '';
            $horaSalidaT = '';


            $stmt->bind_result($mailDestinatario, $nombreE, $fechaT, $nombreT, $horaEntradaT, $horaSalidaT);
            $stmt->fetch();

            $fechaTFormat = date("d/m/Y",strtotime($fechaT));
            $horaEntradaTFormat = date("H:i",strtotime($horaEntradaT));
            $horaSalidaTFormat = date("H:i",strtotime($horaSalidaT));

            $stmt->close();

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
            $mail->addAddress($mailDestinatario, $nombreE);

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
                    <h2 style='color: #41cf1d;'>¡Hola <b>{$nombreE}</b>!</h2>
                    <p style='margin-top: 10px;'>Te notificamos que el turno en la fecha <b>{$fechaTFormat} se te ha desasignado</b>. Para más información
                    puedes ponerte en contacto con el administrador.</p>
                </body>
                </html>
            ";

            $mail->CharSet = 'UTF-8';
            $mail->send();
            return true;

        } else {
            throw new Exception("No hay datos para ese empleado");
        }
    } catch (Exception $e) {
        return "❌ Error al enviar el correo: " . $e->getMessage() . "\n";
    }
}

?>