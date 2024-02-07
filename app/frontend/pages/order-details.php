</style>
<div class="container" style="margin-top:30px">
    <h2>Order Details</h2>

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

    echo "<style>";
    echo ".product-box {";
    echo "border: 1px solid #fff;";
    echo "padding: 10px;";
    echo "margin-bottom: 10px;";
    echo "}";

    echo ".product-box h3 {";
    echo "margin: 0;";
    echo "padding-bottom: 10px;";
    echo "border-bottom: 1px solid #fff;";
    echo "}";

    echo ".product-box p {";
    echo "margin: 5px 0;";
    echo "}";
    echo "</style>";

    if (isset($order->products) && is_string($order->products)) {
        $products = explode(';', trim($order->products, ';'));

        foreach ($products as $product_info) {
            $product = explode(",", $product_info);
            $quantity = $product[0];
            $variation_name = $product[1];
            $price = $product[2];
            $discount = $product[3];
            $product_name = $product[4];

            $price_at_purchase = $price * (100 - $discount) / 100;

            $totalOrderPrice += $price_at_purchase * $quantity;

            echo "<div class='product-box'>";
            echo "<h3>" . $product_name . "</h3>";
            echo "<p><strong>Variation:</strong> " . $variation_name . "</p>";
            echo "<p><strong>Quantity:</strong> " . $quantity . "</p>";
            if ($discount > 0) {
                echo "<p><strong>Price:</strong> <s>" . $price . "</s> " . $price_at_purchase . " (Discount: " . $discount . "%)</p>";
            } else {
                echo "<p><strong>Price:</strong> " . $price . "</p>";
            }
            echo "<p><strong>Subtotal:</strong> " . $price_at_purchase * $quantity . "</p>";
            echo "</div>";
        }

        echo "<div class='total-box'>";
        echo "<h3>Total: " . $totalOrderPrice . "</h3>";
        echo "</div>";
    }

    ?>
    <br> <br>
</div>