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

    $products = explode(";", $order->products);

    //echo $products->count() . " products found.";
    echo "<table style='width:100%; border: 1px solid'>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Name</th>";
    echo "<th>Price</th>";
    echo "<th>Quantity</th>";
    echo "</tr>";
    foreach ($products as $product) {
        $product = explode(",", $product);
        $product_id = $product[1];
        $quantity = $product[0];

        $product = Product::getProductById($product_id);

        // build a table with the results, printing the variables "name", "price", "category" and "description"
        echo "<tr>";
        echo "<td>" . $product->product_id . "</td>";
        echo "<td>" . $product->name . "</td>";
        echo "<td>" . $product->price . "</td>";
        echo "<td>" . $quantity . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <br> <br>

    <h4>Price Breakdown:</h4>

    <?php

    $total = 0;

    $products = explode(";", $order->products);

    echo "<table style='width:100%; border: 1px solid'>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Price</th>";
    echo "<th>Quantity</th>";
    echo "<th>Subtotal</th>";
    echo "</tr>";
    foreach ($products as $product) {
        $product = explode(",", $product);
        $product_id = $product[1];
        $quantity = $product[0];

        $product = Product::getProductById($product_id);

        // build a table with the results, printing the variables "name", "price", "category" and "description"
        echo "<tr>";
        echo "<td>" . $product->name . "</td>";
        echo "<td>" . $product->price . "</td>";
        echo "<td>" . $quantity . "</td>";
        $subtotal = $product->price * $quantity;
        $total += $subtotal;
        echo "<td>" . $subtotal . "</td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<th> Total </th>";
    echo "<th> </th>";
    echo "<th> </th>";
    echo "<th>" . $total . "</th>";
    echo "</tr>";
    echo "</table>";

    ?>
</div>