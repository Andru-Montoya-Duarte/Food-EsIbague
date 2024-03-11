<?php
// Incluir el archivo de autoloading de Composer
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'anphimon21@gmail.com'; // Reemplaza con tu dirección de correo
    $mail->Password   = 'pocholin12'; // Reemplaza con tu contraseña
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    // Destinatario y asunto
    $mail->setFrom('anphimon21@gmail.com', 'Andru Montoya Duarte');
    $mail->addAddress('amontoya@dsierra.com', 'Andru Montoya Duarte');
    $mail->Subject = 'Correo de prueba';

    // Contenido del correo
    $mail->Body = 'Este es el contenido del correo';

    // Enviar el correo
    $mail->send();
    echo 'Correo enviado correctamente';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>
