<?php
// Check if the order_id is set in the URL
if (!isset($_GET['order_id'])) {
    die('No order ID provided');
}

$order_id = $_GET['order_id'];

// Fetch the order from the database
$order = Order::getOrderById($order_id);

var_dump($order);

if ($order === null) {
    die('Order not found');
}

echo "Order ID: " . $order->order_id . "<br>";

if (isset($order->order_date)) {
    echo "Order Date: " . $order->order_date . "<br>";
}

if (isset($order->total)) {
    echo "Order Total: " . $order->total . "<br>";
}

// Check if the products property exists and is an array before trying to iterate over it
if (isset($order->products) && is_array($order->products)) {
    foreach ($order->products as $product) {
        echo "Product ID: " . $product->product_id . "<br>";
        echo "Product Name: " . $product->name . "<br>";
        echo "Product Price: " . $product->price . "<br>";
    }
}
?>