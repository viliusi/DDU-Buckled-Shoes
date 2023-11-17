<?php

class Post
{

    public static function create($fields = array())
    {
        if (!Database::getInstance()->insert('posts', $fields)) {
            throw new Exception("Unable to create the post.");
        }
    }

    public static function getAllPosts()
    {
        $posts = Database::getInstance()->get('posts', array('post_id', '>', '0'));
        //return list of posts
        return $posts;
    }

    public static function getChannelPosts($channel_id)
    {
        $posts = Database::getInstance()->get('posts', array('channel_id', '=', $channel_id));
        //return list of posts
        return $posts;
    }


    public static function getPostById($post_id)
    {
        $post = Database::getInstance()->get('posts', array('post_id', '=', $post_id));
        if ($post->count()) {
            return $post->first();
        }
    }
}
