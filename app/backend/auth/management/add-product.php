<?php
require_once 'app/backend/core/Init.php';
require_once 'app/backend/classes/Product.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 25
            ),

            'description' => array(
                'required' => true,
                'min' => 2,
                'max' => 255,
            ),

            'price' => array(
                'required' => true,
                'min' => 1,
                'max' => 10,
            ),

            'category' => array(
                'required' => true,
                'min' => 2,
                'max' => 10,
            ),

            'images_reference' => array(
                'required' => true,
                'min' => 1,
                'max' => 128,
            ),
        ));

        if ($validate->passed()) {
            try {
                Product::create(array(
                    'name' => Input::get('name'),
                    'description' => Input::get('description'),
                    'price' => Input::get('price'),
                    'category' => Input::get('category'),
                    'images_reference' => Input::get('images_reference'),
                ));

                Session::flash('create-post-success', 'Thanks for adding product.');
                Redirect::to('management-products.php');
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