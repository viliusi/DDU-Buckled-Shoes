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
                    $mail->setFrom('christenbot@buckledshoes.store', 'ChristenBot');
                    $mail->addAddress(Input::get('email'));     // Add a recipient

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Verify your account for Buckled Shoes';
                    $mail->Body = '
<html>
<head>
    <style>
        body {font-family: Arial, sans-serif;}
        .container {width: 80%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;}
        .button {background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;}
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Buckled Shoes Store!</h2>
        <p>Please click on the button below to verify your account. If you do not wish to keep this account for whatever reason, then you can choose to delete the account through the link.</p>
        <a href="http://buckledshoes.store/verification.php?user_id=' . $user->getUserIdByUsername(Input::get('username')) . '&verification_code=' . $user->getVerificationCode($user_id) . '" class="button">Verify</a>
    </div>
</body>
</html>';
                    $mail->AltBody = 'Welcome to Buckled Shoes Store!

Please click on the button below to verify your account. If you do not wish to keep this account for whatever reason, then you can choose to delete the account through the link: http://buckledshoes.store/verification.php?user_id=' . $user->getUserIdByUsername(Input::get('username')) . '&verification_code=' . $user->getVerificationCode($user_id) . '';

                    $mail->send();
                } catch (Exception $e) {
                    die($e->getMessage());
                }

                Session::flash('register-success', 'Thanks for registering! Now you just need to verify with your mail. Please check your mail for the verification link. After verifying you can ');
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
