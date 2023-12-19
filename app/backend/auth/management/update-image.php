<?php
require_once 'app/backend/core/Init.php';
require_once 'app/backend/classes/Image.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 25
            ),

            'image_location' => array(
                'required' => true,
                'min' => 2,
                'max' => 255,
            ),
        ));

        if ($validate->passed()) {
            try {
                Image::edit(array(
                    'name' => Input::get('name'),
                    'image_location' => Input::get('image_location'),
                ), Input::get('image_id'));

                Session::flash('create-post-success', 'Thanks for imageing.');
                Redirect::to('management-images.php');
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