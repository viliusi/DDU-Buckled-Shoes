<div class="container" style="margin-top:30px">
  <h2>Buy</h2>
<?php
    //Show the cart items
    $cart = $_SESSION['cart'];
    $total_price = 0;
    foreach ($cart as $product_id) {
        $product = Product::getProductById($product_id);
        echo "<h3>" . $product->name . "</h3>";
        echo "<p>" . $product->description . "</p>";
        echo "<p>Price: $" . $product->price . "</p>";
        $total_price += $product->price;
    }
    echo "<p>Total price: $$total_price</p>";
    $tax_cut = $total_price * 0.2;
    echo "<p>Tax cut: $$tax_cut</p>";


    //Buy button
    echo "<form action='buy.php' method='post'>";
    echo "<input type='submit' name='checkout' value='Buy'>";
    echo "</form>";
?>
</div>