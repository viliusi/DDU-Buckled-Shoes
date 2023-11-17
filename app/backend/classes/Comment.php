<?php

class Comment
{
    public static function create($fields = array())
    {
        if (!Database::getInstance()->insert('comments', $fields)) {
            throw new Exception("Unable to create the comment.");
        }
    }

    public static function getAllComments($post_id)
    {
        $comments = Database::getInstance()->query("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.user_id WHERE post_id = ?", array($post_id));
        //return list of comments
        return $comments;
    }
}
