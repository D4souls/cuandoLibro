<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar la clase PHPMailer
require 'vendor/autoload.php';

// Crear una instancia de PHPMailer
$mail = new PHPMailer(true);

$correo = "cuandolibro@outlook.es";
$password = "donbosco787";
$nombre = "Administración CL";

try {
    // Configurar el servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = $correo;
    $mail->Password = $password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configurar el remitente y destinatario
    $mail->setFrom($correo, $nombre);
    $mail->addAddress('sergioavilamacho12@gmail.com', 'Sergio Ávila Macho');

    // Configurar el asunto y cuerpo del mensaje
    $mail->Subject = 'Retraso detectado';
    $mail->Body = 'Hemos detectado un retraso en los últimos días.';

    // Enviar el correo
    $mail->send();
    echo 'Correo enviado correctamente';
} catch (Exception $e) {
    echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
}
?>
