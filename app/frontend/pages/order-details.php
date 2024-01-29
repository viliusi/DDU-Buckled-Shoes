</style>
<?php
// Check if the order_id is set in the URL
if (!isset($_GET['order_id'])) {
    die('No order ID provided');
}

$order_id = $_GET['order_id'];

// Fetch the order from the database
$order = Order::getOrderById($order_id);

if ($order === null) {
    die('Order not found');
}

echo "<h4>Order Date: " . $order->time . "</h4><br><br>";

$totalOrderPrice = 0;

if (isset($order->products) && is_string($order->products)) {
    $products = explode(';', trim($order->products, ';'));

    foreach ($products as $product_info) { 
        list($quantity, $id) = explode(',', $product_info); 

        $price_for_the_product = Product::getCurrentPrice($id);

        $totalOrderPrice += $price_for_the_product * $quantity;

        // Fetch the product details from the database
        $product = Product::getProductById($id); 
        $variation = Product::getVariationByVariationId($variation_id);

        echo "Product Name: " . $product->name . "<br>"; 
        echo "Product Description: " . $product->description . "<br>";
        echo "Product Quantity: " . $quantity . "<br>";
        echo "Product Variation: " . $variation->name . "<br>";
        echo "Product Price: " . "$" . $price_for_the_product . "<br>";
        // Fetch the images for the product
        $images = Product::getImagesByProductId($id);
        foreach ($images->results() as $image) {
            echo "<div class='imageAlignment'>";
            echo "<img src='" . $image->image_location . "' width='30%' height='30%'><br>";
            echo "</div>" . "<br>" . "<br>";
        }
    }
}

echo "<h4>Total Order Price: " . "$" . $totalOrderPrice . "</h4><br>";
?>