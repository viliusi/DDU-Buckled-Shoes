<?php
require_once 'app/backend/core/Init.php';
require_once 'app/backend/classes/Order.php';

echo var_dump($_POST);

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'user_id' => array(
                'required' => true,
                'min' => 1,
                'max' => 25
            ),

            'products' => array(
                'required' => true,
                'min' => 2,
                'max' => 255,
            ),
        ));

        if ($validate->passed()) {
            echo "passed";
            try {
                Order::create(array(
                    'user_id' => Input::get('user_id'),
                    'products' => Input::get('products'),
                ));

                Session::flash('create-post-success', 'Thanks for ordering.');
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