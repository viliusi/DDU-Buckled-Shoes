<?php
require_once 'app/backend/core/Init.php';
require_once 'app/backend/classes/User.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'user_id' => array(
                'required' => true,
                'min' => 1,
                'max' => 25
            ),

            'verification_code' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            )
        ));

        $verification = User::checkVerification(Input::get('user_id'), Input::get('verification_code'));

        if ($validate->passed() && $verification) {
            try {
                User::makeVerified(Input::get('user_id'));

                Session::flash('create-post-success', 'Thanks for verifying your account.');
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
?>