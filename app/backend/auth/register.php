<?php
require_once 'app/backend/core/Init.php';

require_once 'app/backend/classes/Mail.php';

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

                $subject = 'Verify your account for Buckled Shoes';

                $body = '
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
                    $altBody = 'Welcome to Buckled Shoes Store!

Please click on the button below to verify your account. If you do not wish to keep this account for whatever reason, then you can choose to delete the account through the link: http://buckledshoes.store/verification.php?user_id=' . $user->getUserIdByUsername(Input::get('username')) . '&verification_code=' . $user->getVerificationCode($user_id) . '';


                Mail::send(Input::get('email'), $subject, $body, $altBody);

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
