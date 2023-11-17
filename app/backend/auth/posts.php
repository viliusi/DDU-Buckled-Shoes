<?php
require_once 'app/backend/core/Init.php';

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::get('post_id')) {
    $post_id = Input::get('post_id');
    $post = Post::getPostById($post_id);
    $comments = Comment::getAllComments($post_id);
    $channel_id = $post->channel_id;
}

if (Input::get('channel_id')) {
    $channel_id = Input::get('channel_id');
    $channel = Channel::getChannel($channel_id);
    $posts = Post::getChannelPosts($channel_id);
}


$data = $user->data();

$channel = Channel::getChannel($channel_id);
$posts = Post::getChannelPosts($channel_id);

if (Input::get('submit')) {

    Post::create($post);
    Redirect::to('channel.php?id=' . $channel_id);
}
