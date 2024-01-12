<?php

class Review
{
    public static function create($fields = array())
    {
        if (!Database::getInstance()->insert('reviews', $fields)) {
            throw new Exception("Unable to create the review.");
        }
    }

    public static function edit($fields = array(), $review_id)
    {
        if (!$review_id && $review_id != 0) {
            throw new Exception('Missing review ID');
        }

        $db = Database::getInstance();

        if (!$db->update('reviews', 'review_id', $review_id, $fields)) {
            throw new Exception('There was a problem updating the review.');
        }
    }

    public static function delete($review_id)
    {
        if (!$review_id && $review_id != 0) {
            throw new Exception('Missing review ID');
        }

        $db = Database::getInstance();

        if (!$db->delete('reviews', array('review_id', '=', $review_id))) {
            throw new Exception('There was a problem deleting the review.');
        }
    }

    public static function getAllReviews()
    {
        $reviews = Database::getInstance()->query("SELECT * FROM reviews ORDER BY review_id ASC");
        //return list of reviews
        return $reviews;
    }

    public static function getCategoryReviews($category)
    {
        $reviews = Database::getInstance()->get('reviews', array('category', '=', $category));
        //return list of reviews
        return $reviews;
    }


    public static function getReviewById($review_id)
    {
        $reviews = Database::getInstance()->get('reviews', array('review_id', '=', $review_id));
        if ($reviews->count()) {
            return $reviews->first();
        }
    }

    public static function getReviewsByProductId($product_id)
    {
        $reviews = Database::getInstance()->get('reviews', array('product_id', '=', $product_id));
        if ($reviews->count()) {
            return $reviews;
        }
    }

    public static function getReviewsByUserId($user_id)
    {
        $reviews = Database::getInstance()->get('reviews', array('user_id', '=', $user_id));
        if ($reviews->count()) {
            return $reviews;
        }
    }

    // This file creates the reviews and gets all the reviews in a channel and the reviews by id.
}
