<?php
require_once 'app/backend/core/Init.php';
require_once 'app/backend/classes/Product.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'user_id' => array(
                'required' => true,
                'min' => 1,
                'max' => 25
            ),
        ));

        if ($validate->passed()) {
            try {
                User::switchAdminState(Input::get('user_id'));

                Session::flash('create-post-success', 'Thanks for admining.');
                Redirect::to('management-users.php');
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