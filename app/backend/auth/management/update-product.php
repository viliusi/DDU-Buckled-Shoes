<?php
require_once 'app/backend/core/Init.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 20
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
        ));

        if ($validate->passed()) {
            try {
                Product::edit(array(
                    'name' => Input::get('name'),
                    'description' => Input::get('description'),
                    'price' => Input::get('price'),
                    'category' => Input::get('category'),
                ), Input::get('product_id'));

                Session::flash('create-post-success', 'Thanks for producting.');
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