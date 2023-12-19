<?php

class Image
{
    public static function create($fields = array())
    {
        if (!Database::getInstance()->insert('images', $fields)) {
            throw new Exception("Unable to create the image.");
        }
    }

    public static function edit($fields = array(), $image_id)
    {
        if (!$image_id && $image_id != 0) {
            throw new Exception('Missing image ID');
        }
    
        $db = Database::getInstance();
    
        if (!$db->update('images', 'image_id', $image_id, $fields)) {
            throw new Exception('There was a problem updating the image.');
        }
    }

    public static function delete($image_id)
    {
        if (!$image_id && $image_id != 0) {
            throw new Exception('Missing image ID');
        }
    
        $db = Database::getInstance();
    
        if (!$db->delete('images', array('image_id', '=', $image_id))) {
            throw new Exception('There was a problem deleting the image.');
        }
    }

    public static function getAllImages()
    {
        $images = Database::getInstance()->query("SELECT * FROM images ORDER BY image_id ASC");
        //return list of images
        return $images;
    }

    public static function getImageById($image_id)
    {
        $images = Database::getInstance()->get('images', array('image_id', '=', $image_id));
        if ($images->count()) {
            return $images->first();
        }
    }

    // This file creates the images and gets all the images in a channel and the images by id.
}
