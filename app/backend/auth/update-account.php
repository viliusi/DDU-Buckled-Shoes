<?php

require_once 'app/backend/classes/Mail.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20
            ),

            'email' => array(
                'optional' => true,
                'min' => 2,
                'max' => 64
            ),

            'current_password' => array(
                'required' => true,
                'min' => 6,
                'verify' => 'password'
            ),

            'new_password' => array(
                'optional' => true,
                'min' => 6,
                'bind' => 'confirm_new_password'
            ),

            'confirm_new_password' => array(
                'optional' => true,
                'min' => 6,
                'match' => 'new_password',
                'bind' => 'new_password',
            ),
        ));

        if ($validation->passed()) {
            try {
                $user->update(array(
                    'username' => Input::get('username'),
                ));

                if (Input::get('email') != $user->data()->email) {
                    $user->update(array(
                        'email' => Input::get('email')
                    ));

                    User::makeUnverified($user->data()->user_id);

                    $user_id = $user->data()->user_id;

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
        <h2>You have updated your email on Buckled Shoes Store!</h2>
        <p>Please click on the button below to verify your new email address. If you do not wish to keep this account for whatever reason, then you can choose to delete the account through the link.</p>
        <a href="http://buckledshoes.store/verification.php?user_id=' . $user->getUserIdByUsername(Input::get('username')) . '&verification_code=' . $user->getVerificationCode($user_id) . '" class="button">Verify</a>
    </div>
</body>
</html>';

                    $altBody = 'You have updated your email on Buckled Shoes Store!

Please verify your new email address by clicking on the following link: http://buckledshoes.store/verification.php?user_id=' . $user->getUserIdByUsername(Input::get('username')) . '&verification_code=' . $user->getVerificationCode($user_id) . '

If you do not wish to keep this account for whatever reason, you can delete the account by visiting the following link: http://buckledshoes.store/delete_account.php?user_id=' . $user->getUserIdByUsername(Input::get('username'));


                    Mail::send(Input::get('email'), $subject, $body, $altBody);
                }

                if (Input::get('new_password') != null) {
                    if ($validation->optional()) {
                        $user->update(array(
                            'password' => Password::hash(Input::get('new_password'))
                        ));
                    }
                }

                Redirect::to('logout.php');

                Session::flash('update-success', 'Profile successfully updated!');
                Redirect::to('index.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            echo '<div class="alert alert-danger"><strong></strong>' . cleaner($validation->error()) . '</div>';
        }
    }
}
