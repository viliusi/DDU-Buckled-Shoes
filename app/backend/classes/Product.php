<?php

class Product
{
    public static function create($fields = array())
    {
        $db = Database::getInstance();

        // Save the price in a separate variable
        $price = $fields['price'];
        // Remove the price from the fields array
        unset($fields['price']);

        // Insert the product without the price
        if (!$db->insert('products', $fields)) {
            throw new Exception("Unable to insert the product.");
        }

        // Get the product ID of the product that was just inserted
        $products = Product::getAllProducts();

        $product = $products->last();

        var_dump($product);

        // Prepare the price fields
        $priceFields = array(
            'product_id' => $product->product_id,
            'price' => $price
        );

        // Insert the price into the 'prices' table
        if (!$db->insert('prices', $priceFields)) {
            throw new Exception("Unable to insert the price.");
        }
    }

    public static function edit($fields = array(), $product_id)
    {
        if (!$product_id && $product_id != 0) {
            throw new Exception('Missing product ID');
        }

        $db = Database::getInstance();

        // Save the price in a separate variable
        $price = $fields['price'];
        // Remove the price from the fields array
        unset($fields['price']);

        // Update the product without the price
        if (!$db->update('products', 'product_id', $product_id, $fields)) {
            throw new Exception('There was a problem updating the product.');
        }

        // Prepare the price fields
        $priceFields = array(
            'product_id' => $product_id,
            'price' => $price
        );

        // Check if a price already exists for the product
        $existingPrice = $db->get('prices', array('product_id', '=', $product_id));

        if ($existingPrice->count()) {
            // Update the price if it already exists
            if (!$db->update('prices', 'product_id', $product_id, $priceFields)) {
                throw new Exception('There was a problem updating the price.');
            }
        } else {
            // Insert the price if it doesn't exist
            if (!$db->insert('prices', $priceFields)) {
                throw new Exception('There was a problem inserting the price.');
            }
        }
    }

    public static function delete($product_id)
    {
        if (!$product_id && $product_id != 0) {
            throw new Exception('Missing product ID');
        }

        $db = Database::getInstance();

        // Delete the related records from the 'prices' table
        if (!$db->delete('prices', array('product_id', '=', $product_id))) {
            throw new Exception('There was a problem deleting the price.');
        }

        // Delete the product from the 'products' table
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

    public static function getStockByVariationId($variation_id)
    {
        $variation = Database::getInstance()->get('product_variations', array('variation_id', '=', $variation_id))->first();
        if ($variation !== null) {
            return $variation->stock;
        }
    }

    public static function getProductVariationsById($productId)
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM product_variations WHERE product_id = ?", [$productId]);
        return $db->results();  // Assuming there's a results method that returns _results
    }

    public static function getCurrentPrice($product_id)
    {
        $priceDB = Database::getInstance()->get('prices', array('product_id', '=', $product_id));
        if ($priceDB->count() > 0) {
            $firstPrice = $priceDB->results()[0];
            if ($firstPrice->discount > 0) {
                return $firstPrice->price * (100 - $firstPrice->discount) / 100;
            } else {
                return $firstPrice->price;
            }
        } else {
            // Handle the case when there is no price for the given product id
            // This could be returning a default price, throwing an exception, etc.
            // Here we return 0 as an example
            return 0;
        }
    }

    public static function getDiscount($product_id)
    {
        $priceDB = Database::getInstance()->get('prices', array('product_id', '=', $product_id))->first();
        if ($priceDB !== null) {
            return $priceDB->discount;
        } else {
            // Handle the case when there is no price for the given product id
            // This could be returning a default price, throwing an exception, etc.
            // Here we return 0 as an example
            return 0;
        }
    }

    public static function getOriginalPrice($product_id)
    {
        $priceDB = Database::getInstance()->get('prices', array('product_id', '=', $product_id))->first();
        if ($priceDB !== null) {
            return $priceDB->price;
        } else {
            // Handle the case when there is no price for the given product id
            // This could be returning a default price, throwing an exception, etc.
            // Here we return 0 as an example
            return 0;
        }
    }

    public static function getVariationsByProductId($product_id)
    {
        $productVariations = Database::getInstance()->get('product_variations', array('product_id', '=', $product_id), 'name', 'ASC');
        if ($productVariations->count() > 0) {
            return $productVariations;
        } else {
            return null;
        }
    }

    public static function deleteVariation($variation_id)
    {
        if (!$variation_id && $variation_id != 0) {
            throw new Exception('Missing variation ID');
        }

        $db = Database::getInstance();

        if (!$db->delete('product_variations', array('variation_id', '=', $variation_id))) {
            throw new Exception('There was a problem deleting the variation.');
        }
    }

    public static function addVariation($product_id, $variation_name)
    {
        if (!$product_id && $product_id != 0) {
            throw new Exception('Missing product ID');
        }

        $db = Database::getInstance();

        if (!$db->insert('product_variations', array('product_id' => $product_id, 'name' => $variation_name))) {
            throw new Exception('There was a problem adding the variation.');
        }
    }

    // This file creates the products and gets all the products in a channel and the products by id.
}
