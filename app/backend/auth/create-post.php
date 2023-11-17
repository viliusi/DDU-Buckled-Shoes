<?php
require_once 'app/backend/core/Init.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'title' => array(
                'required' => true,
                'min' => 2,
                'max' => 25
            ),

            'content' => array(
                'required' => true,
                'min' => 2,
                'max' => 255,
            ),
        ));

        if ($validate->passed()) {
            try {
                Post::create(array(
                    'title'  => Input::get('title'),
                    'content'  => Input::get('content'),
                    'user_id'      => $user->data()->user_id,
                    'channel_id'    => Input::get('channel_id'),
                ));

                Session::flash('create-post-success', 'Thanks for posting.');
                Redirect::to('posts.php?channel_id=' . Input::get('channel_id'));
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
