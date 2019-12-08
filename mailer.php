<?php

require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;

function build_email_template($name)
{
    $email_template_string = file_get_contents('Message.html', true);
    $email_template = sprintf($email_template_string, $name);
    $dompdf = new DOMPDF();  //if you use namespaces you may use new \DOMPDF()
    $dompdf->loadHtml($email_template);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $pdf = $dompdf->output();
    file_put_contents('Certificate.pdf', $pdf);
    return $pdf;
}
function configureDetails($name, $email)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPDebug =  2;
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'divyansh@bharatorigins.in';
    $mail->Password = 'Berhampur@1';
    $mail->addCustomHeader('Content-Type: multipart/mixed');
    $mail->setFrom('divyansh@bharatorigins.in', 'Divyansh');
    $mail->addReplyTo('divyansh@bharatorigins.in', 'Divyansh');
    $mail->addAddress($email, $name);
    $mail->Subject = 'Testing PHPMAILER';
    // $mail->msgHTML(file_get_contents('Message.html'), __DIR__);
    $mail->Body = "You have sucessfully completed the course!";
    $path = build_email_template($name);
    print_r($mail->createHeader());
    print_r($mail->getMailMIME());
    $mail->addAttachment("img/download.jpg");
    //$mail->addStringAttachment($_SERVER["DOCUMENT_ROOT"] . "/CertificatesGenerator/Certificate.pdf", "Certificate.pdf", $encoding = 'base64', $type = 'application/pdf');
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'The email message was sent.';
    }
}
