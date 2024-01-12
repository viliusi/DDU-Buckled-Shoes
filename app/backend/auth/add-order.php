<?php
require_once 'app/backend/core/Init.php';
require_once 'app/backend/classes/Order.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {

        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'user_id' => array(
                'required' => true,
                'min' => 1,
                'max' => 64,
            ),

            'products' => array(
                'required' => true,
                'min' => 1,
                'max' => 255,
            ),
        ));

        if ($validate->passed()) {
            echo "passed";
            try {
                Order::create(array(
                    'user_id' => Input::get('user_id'), // Use the user ID from the session
                    'products' => Input::get('products'), // Use the products from the cart
                ));

                unset($_SESSION['cart']); 

                Session::flash('create-post-success', 'Thanks for ordering.');
                Redirect::to('index.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
}