<?php
require_once 'app/backend/core/Init.php';
require_once 'app/backend/classes/Review.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'rating' => array(
                'required' => true,
                'min' => 1,
                'max' => 2
            ),

            'text' => array(
                'required' => true,
                'min' => 2,
                'max' => 255,
            ),

            'user_id' => array(
                'required' => true,
                'min' => 1,
                'max' => 10,
            ),

            'product_id' => array(
                'required' => true,
                'min' => 1,
                'max' => 10,
            ),
        ));

        if ($validate->passed()) {
            try {
                Review::create(array(
                    'rating' => Input::get('rating'),
                    'text' => Input::get('text'),
                    'user_id' => Input::get('user_id'),
                    'product_id' => Input::get('product_id'),
                ));

                Session::flash('create-post-success', 'Thanks for adding a review.');
                Redirect::to('product.php?product_id=' . Input::get('product_id'));
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