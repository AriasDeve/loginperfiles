<?php
//Load Composer's autoloader
require '../vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'castillagfelix14@gmail.com';                     //SMTP username
    $mail->Password   = 'dnintiskyjtgwcek';
    $mail->CharSet    = 'UTF-8';                                 //Codificación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('castillagfelix14@gmail.com', 'Área de sistemas');
    $mail->addAddress('1337304@senati.pe', 'Geraldine Castilla');     //Destino
    $mail->addAddress('1337304@senati.pe');               //Destino
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Archivos adjuntos
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   $mail->addAttachment('./alonso.pdf', 'Adjunto.pdf');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Prueba de mensaje 4'; //Asunto
    $mail->Body    = 'Atención Gracias por <strong>Suscribirte</strong>'; //Soporta HTML
    $mail->AltBody = 'Atención Gracias por suscribsites'; //No soporta HMLT

    $mail->send();
    echo json_encode(["status" => true]);
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo json_encode(["status" => false]);
}