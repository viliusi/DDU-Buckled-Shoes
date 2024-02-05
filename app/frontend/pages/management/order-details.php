<div class="container" style="margin-top:30px">
    <h2>Order Details</h2>

    <?php
    if (isset($_GET['order_id']))
        $order = Order::getOrderById($_GET['order_id']);
    ?>

    <br>

    <h4>Current Info:</h4>
    <li style="font-weight: bold">ID:</li>
    <?php echo $order->order_id ?>
    <li style="font-weight: bold">Products: </li>
    <?php echo $order->products ?>
    <li style="font-weight: bold">User ID: </li>
    <?php echo $order->user_id ?>
    <li style="font-weight: bold">Username: </li>
    <?php $user = User::getUserById($order->user_id);
    echo $user->username ?>
    <li style="font-weight: bold">Time: </li>
    <?php echo $order->time ?>

    <br> <br>

    <h4>Product Info:</h4>

    <?php

    $total = 0;

    $products = rtrim($order->products, ";");

    $products = explode(";", $products);

    echo "<table style='width:100%; border: 1px solid'>";
    echo "<tr>";
    echo "<th>Quantity</th>";
    echo "<th>Variation Name</th>";
    echo "<th>Price</th>";
    echo "<th>Discount</th>";
    echo "<th>Product Name</th>";
    echo "<th>Subtotal</th>";
    echo "</tr>";
    foreach ($products as $product) {
        $product = explode(",", $product);
        $quantity = $product[0];
        $variation_name = $product[1];
        $price = $product[2];
        $discount = $product[3];
        $product_name = $product[4];
    
        echo "<tr>";
        echo "<td>" . $quantity . "</td>";
        echo "<td>" . $variation_name . "</td>";
        echo "<td>" . $price . "</td>";
        echo "<td>" . $discount . "</td>";
        echo "<td>" . $product_name . "</td>";
        $subtotal = ($price - $discount) * $quantity;
        $total += $subtotal;
        echo "<td>" . $subtotal . "</td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<th colspan='5'> Total </th>";
    echo "<th>" . $total . "</th>";
    echo "</tr>";
    echo "</table>";
    ?>
    <br> <br>
</div>