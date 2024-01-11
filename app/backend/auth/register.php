<?php
require_once 'app/backend/core/Init.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-6.9.1/src/Exception.php';
require 'PHPMailer-6.9.1/src/PHPMailer.php';
require 'PHPMailer-6.9.1/src/SMTP.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(

            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),

            'email' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
                'unique' => 'users'
            ),

            'password' => array(
                'required' => true,
                'min' => 6
            ),

            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            )
        ));

        if ($validate->passed()) {
            try {
                $user->create(array(
                    'username'  => Input::get('username'),
                    'email'     => Input::get('email'),
                    'password'  => Password::hash(Input::get('password')),
                ));

                $user_id = $user->getUserIdByUsername(Input::get('username'));
                $user->createVerificationCode($user_id);

                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       = 'websmtp.simply.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'christenbot@buckledshoes.store';
                    $mail->Password   = 'zqg@tak2fpy1QEA.vjz';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;

                    //Recipients
                    $mail->setFrom('christenbot@buckledshoes.store', 'Mailer');
                    $mail->addAddress(Input::get('email'));     // Add a recipient

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Verification Mail';
                    $mail->Body    = 'Please click on the link below to verify your account.<br><a href="http://buckledshoes.store/verification.php?user_id=' . $user->getUserIdByUsername(Input::get('username')) . '&verification_code=' . $user->getVerificationCode($user_id) . '">Verify</a>';
                    $mail->AltBody = 'Please click on the link below to verify your account.<br><a href="http://buckledshoes.store/verification.php?user_id=' . $user->getUserIdByUsername(Input::get('username')) . '&verification_code=' . $user->getVerificationCode($user_id) . '">Verify</a>';

                    $mail->send();
                } catch (Exception $e) {
                    die($e->getMessage());
                }

                Session::flash('register-success', 'Thanks for registering! Now you just need to verify with your mail.');
                Redirect::to('index.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validate->errors() as $error) {
                echo '<div class="alert alert-danger"><strong></strong>' . cleaner($error) . '</div>';
            }
        }
    }
}
