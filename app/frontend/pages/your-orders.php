<div class="container" style="margin-top:30px">
    <h2>Your orders</h2><br>
    <h4>Product Info:</h4>
    <?php
    // Check if session is not started, then start the session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        echo "You must be logged in to view your orders.";
        exit;
    }

    $user_id = $_SESSION['user'];
    $orders = Order::getOrdersByUserId($user_id); // Retrieve all orders for the user

    if ($orders !== null) {
        foreach ($orders as $order) {
            echo "<div style='border: 1px solid; margin-bottom: 10px; padding: 10px;'>"; // Start of order div
            $products = explode(";", $order->products);

            echo "<table style='width:100%'>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Variation Name</th>";
            echo "<th>Price</th>";
            echo "<th>Discount</th>";
            echo "<th>Quantity</th>";
            echo "<th>Subtotal</th>";
            echo "</tr>";

            $total = 0;

            foreach ($products as $product) {
                $product = explode(",", $product);

                if (count($product) != 5) {
                    continue;
                }

                $quantity = $product[0];
                $variationName = $product[1];
                $price = $product[2];
                $discount = $product[3];
                $productName = $product[4];

                $subtotal = ($price - $discount) * $quantity;
                $total += $subtotal;

                echo "<tr>";
                echo "<td>{$productName}</td>";
                echo "<td>{$variationName}</td>";
                echo "<td>{$price}</td>";
                echo "<td>{$discount}</td>";
                echo "<td>{$quantity}</td>";
                echo "<td>{$subtotal}</td>";
                echo "</tr>";
            }

            echo "<tr>";
            echo "<td colspan='6'>Total</td>";
            echo "<td>{$total}</td>";
            echo "</tr>";
            echo "</table>";
            echo "<a href='order-details.php?order_id={$order->order_id}' class='btn btn-info'>Details</a>";
            echo "<br><br>";
            echo "</div>"; // End of order div
        }
    } else {
        echo "No orders found.";
    }

    ?>
    <br>
</div>