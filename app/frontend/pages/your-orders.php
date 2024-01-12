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
            $products = explode(";", $order->products);

            echo "<table style='width:100%; border: 1px solid'>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "<th>Subtotal</th>";
            echo "</tr>";

            $total = 0;

            foreach ($products as $product) {
                $product = explode(",", $product);

                if (count($product) != 2) {
                    continue;
                }

                $product_id = $product[1];
                $quantity = $product[0];

                $product = Product::getProductById($product_id);

                if ($product !== null) {
                    echo "<tr>";
                    echo "<td>" . $product->name . "</td>";
                    echo "<td>" . $product->price . "</td>";
                    echo "<td>" . $quantity . "</td>";
                    $subtotal = $product->price * $quantity;
                    $total += $subtotal;
                    echo "<td>" . $subtotal . "</td>";
                    echo "</tr>";
                }
            }

            echo "<tr>";
            echo "<td colspan='4'><a href='order-details.php?order_id=" . $order->order_id . "'><button>Details</button></a></td>";
            echo "<td>Total: " . $total . "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<br>";
        }
    } else {
        echo "No orders found.";
    }

    ?>
    <br>
</div>