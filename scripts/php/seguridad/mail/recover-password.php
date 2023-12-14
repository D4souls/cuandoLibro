<?php
function sendMail($data)
{
    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    $correo = "cuandolibro@outlook.es";
    $password = "donbosco787";
    $nombre = "Administración Cuando Libro";
    $host = "smtp.office365.com";

    $mailDestinatario = $data["mail"];

    include_once("../conexion.php");

    function randomNumber($conexion){
        $codigo = mt_rand(100000, 999999);

        $query = "INSERT INTO codigosrecuperacion (codigo) VALUES codigo = ?";

        $stmt = $conexion->prepare($query);

        $stmt->bind_param("i", $codigo);

        $stmt->execute();
        
        return $codigo;


    }

    $codigo = randomNumber($conexion);

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
        $mail->addAddress($mailDestinatario, $nombreCompleto);

        // Configurar el asunto y cuerpo del mensaje
        $mail->isHTML(true);
        $mail->Subject = '🔔 Nueva notificación';
        $mail->Body = "
        <!DOCTYPE html>
            <html>
            <head></head>
            <body style='font-family: 'QuickSand', sans-serif; margin: 0; padding: 20px;'>
                <p>Tu codigo de seguridad: {$codigo}</p>
            </body>
            </html>

        ";

        // Enviar el correo
        $mail->CharSet = 'UTF-8';
        $mail->send();
        return "📩 Correo enviado correctamente\n";
    } catch (Exception $e) {
        return "❌ Error al enviar el correo: " . $e->getMessage() . "\n";
    }
}

if (isset($_REQUEST["mail"]) && $_REQUEST["mail"] !== null) {
    $mail = $_REQUEST["mail"];



} else {
    throw new Exception("Mail no envíado: " . $conexion->error);
}

?>