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

// Check if the time property exists before trying to echo it

echo "<br><br>Order Date: " . $order->time . "<br>";

// Initialize total order price
$totalOrderPrice = 0;

// Check if the products property exists and is a string before trying to parse it
if (isset($order->products) && is_string($order->products)) {
    // Parse the products string into an array of product IDs and quantities
    $products = explode(';', trim($order->products, ';'));
    foreach ($products as $product) {
        list($product_id, $quantity) = explode(',', $product);

        // Fetch the price for the product from the database
        $productPrice = Product::getProductPriceById($product_id);

        // Calculate the total price for this product and add it to the total order price
        $totalOrderPrice += $productPrice * $quantity;

        echo "Product ID: " . $quantity . "<br>";
        echo "Product Quantity: " . $product_id . "<br>";
        echo "Product Price: " . $productPrice . "<br>" . "<br>";
    }
}

echo "Total Order Price: " . $totalOrderPrice . "<br>";
?>
