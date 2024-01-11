<?php
require_once 'app/backend/core/Init.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate   = new Validation();

        $validation = $validate->check($_POST, array(
            'username'  => array(
                'required'  => true,
            ),

            'email'    => array(
                'required'  => true,
            ),

            'password'  => array(
                'required'  => true
            )
        ));

        if ($validation->passed()) {
            $remember   = (Input::get('remember') === 'on') ? true : false;
            $verified   = $user->checkVerificationByUsername(Input::get('username'));
            $login      = $user->login(Input::get('username'), Input::get('password'), $remember);
            if ($login && $verified) {
                Session::flash('login-success', 'You have successfully logged in!');
                Redirect::to('index.php');
            } elseif ($login && !$verified) {
                echo '<div class="alert alert-danger"><strong></strong>Your account is not verified yet. Please check your email for the verification link.</div>';
            } else {
                echo '<div class="alert alert-danger"><strong></strong>Incorrect Credentials! Please try again...</div>';
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo '<div class="alert alert-danger"><strong></strong>' . cleaner($error) . '</div>';
            }
        }
    }
}
