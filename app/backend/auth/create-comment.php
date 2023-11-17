<?php
require_once 'app/backend/core/Init.php';

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
if (!Input::get('post_id')) {
    Redirect::to('index.php');
}

$data = $user->data();
$channel_id = Input::get('channel_id');
$post_id = Input::get('post_id');


if (Input::exists()) {
    Comment::create(array(
        'user_id' => $data->user_id,
        'post_id' => $post_id,
        'content' => Input::get('content'),
        'created_at' => date('Y-m-d H:i:s')
    ));
    Redirect::to('comments.php?post_id=' . $post_id);
}
