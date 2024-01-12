<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-6.9.1/src/Exception.php';
require 'PHPMailer-6.9.1/src/PHPMailer.php';
require 'PHPMailer-6.9.1/src/SMTP.php';

class Mail
{
    public static function send($to, $subject, $body, $altBody)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'websmtp.simply.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'christenbot@buckledshoes.store';

            $password = parse_ini_file('../mailPassword.ini');

            $mail->Password = $password['password'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('christenbot@buckledshoes.store', 'ChristenBot');
            $mail->addAddress($to);     // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $altBody;

            $mail->send();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}