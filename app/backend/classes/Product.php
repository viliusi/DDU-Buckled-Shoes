<?php

class Product
{
    public static function create($fields = array())
    {
        if (!Database::getInstance()->insert('products', $fields)) {
            throw new Exception("Unable to create the product.");
        }
    }

    public static function edit($fields = array(), $product_id)
    {
        if (!$product_id && $product_id != 0) {
            throw new Exception('Missing product ID');
        }

        $db = Database::getInstance();

        if (!$db->update('products', 'product_id', $product_id, $fields)) {
            throw new Exception('There was a problem updating the product.');
        }
    }

    public static function delete($product_id)
    {
        if (!$product_id && $product_id != 0) {
            throw new Exception('Missing product ID');
        }

        $db = Database::getInstance();

        if (!$db->delete('products', array('product_id', '=', $product_id))) {
            throw new Exception('There was a problem deleting the product.');
        }
    }

    public static function getAllProducts()
    {
        $products = Database::getInstance()->query("SELECT * FROM products ORDER BY product_id ASC");
        //return list of products
        return $products;
    }

    public static function getCategoryProducts($category)
    {
        $products = Database::getInstance()->get('products', array('category', '=', $category));
        //return list of products
        return $products;
    }


    public static function getProductById($product_id)
    {
        $products = Database::getInstance()->get('products', array('product_id', '=', $product_id));
        if ($products->count()) {
            return $products->first();
        }
    }

    public static function getImagesByProductId($product_id)
    {
        $product = self::getProductById($product_id);
    
        $images_reference = $product->images_reference;
        $images_array = array_map('intval', explode(";", $images_reference));
    
        if (!is_array($images_array)) {
            $images_array = [$images_array];
        }
    
        $images = Database::getInstance()->query("SELECT * FROM images WHERE image_id IN (" . implode(",", $images_array) . ") ORDER BY image_id ASC");
    
        return $images;
    }

    public static function getProductPriceById($product_id)
    {
        $product = self::getProductById($product_id);
        if ($product !== null) {
            return $product->price;
        }
    }

    // This file creates the products and gets all the products in a channel and the products by id.
}
