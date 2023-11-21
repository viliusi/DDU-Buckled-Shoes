<?php

class Product
{
    public static function create($fields = array())
    {
        if (!Database::getInstance()->insert('products', $fields)) {
            throw new Exception("Unable to create the product.");
        }
    }

    public static function edit($product_id, $name, $description, $price, $category)
    {
        $fields = array(
            'product_id' => $product_id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category' => $category
        );
        $where = array(
            'field' => 'product_id',
            'operator' => '=',
            'value' => $product_id
        );
        if (!Database::getInstance()->update('products', $fields, $where)) {
            throw new Exception("Unable to edit the product.");
        }
        
        Redirect::to('management-products.php');
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

    // This file creates the products and gets all the products in a channel and the products by id.
}
