<?php

class Order
{
    public static function create($fields = array())
    {
        if (!Database::getInstance()->insert('orders', $fields)) {
            throw new Exception("Unable to create the order.");
        }
    }

    public static function edit($fields = array(), $order_id)
    {
        if (!$order_id && $order_id != 0) {
            throw new Exception('Missing order ID');
        }

        $db = Database::getInstance();

        if (!$db->update('orders', 'order_id', $order_id, $fields)) {
            throw new Exception('There was a problem updating the order.');
        }
    }

    public static function delete($order_id)
    {
        if (!$order_id && $order_id != 0) {
            throw new Exception('Missing order ID');
        }

        $db = Database::getInstance();

        if (!$db->delete('orders', array('order_id', '=', $order_id))) {
            throw new Exception('There was a problem deleting the order.');
        }
    }

    public static function getAllOrders()
    {
        $orders = Database::getInstance()->query("SELECT * FROM orders ORDER BY order_id ASC");
        //return list of orders
        return $orders;
    }

    public static function getCategoryOrders($category)
    {
        $orders = Database::getInstance()->get('orders', array('category', '=', $category));
        //return list of orders
        return $orders;
    }


    public static function getOrderById($order_id)
    {
        $orders = Database::getInstance()->get('orders', array('order_id', '=', $order_id));
        if ($orders->count()) {
            return $orders->first();
        }
    }

    public static function getImagesByOrderId($order_id)
    {
        $order = self::getOrderById($order_id);
    
        $images_reference = $order->images_reference;
        $images_array = array_map('intval', explode(";", $images_reference));
    
        if (!is_array($images_array)) {
            $images_array = [$images_array];
        }
    
        $images = Database::getInstance()->query("SELECT * FROM images WHERE image_id IN (" . implode(",", $images_array) . ") ORDER BY image_id ASC");
    
        return $images;
    }

    // This file creates the orders and gets all the orders in a channel and the orders by id.
}
