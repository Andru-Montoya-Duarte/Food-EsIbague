<?php
// Incluir el archivo de autoloading de Composer
require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'anphimon21@outlook.com';
	$mail->Password = 'pocholin12';
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;

    $mail->setFrom('anphimon21@outlook.com', 'Andru Montoya - Foodies Leguends');
    $mail->addAddress('anphimon21@gmail.com');

    $mail->Subject = 'Correo de prueba';
    $mail->Body = 'Este es el cuerpo del mensaje.';

    $mail->send();
    echo 'El mensaje ha sido enviado';
} catch (Exception $e) {
    echo 'Error al enviar el mensaje: ' . $mail->ErrorInfo;
}





?>
