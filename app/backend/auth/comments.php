<?php
require_once 'app/backend/core/Init.php';

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
if (!Input::get('post_id')) {
    Redirect::to('index.php');
}

$post_id = Input::get('post_id');
$post = Post::getPostById($post_id);
$comments = Comment::getAllComments($post_id);

