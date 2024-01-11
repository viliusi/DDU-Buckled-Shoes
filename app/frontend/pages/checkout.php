<div class="container" style="margin-top:30px">
  <h2>Buy</h2>
  <?php

  
  // Check if the user is logged in and the cart is not empty
  if (!isset($_SESSION['user']) || !isset($_SESSION['cart'])) {
    echo "You must be logged in and have items in your cart to checkout.";
    exit;
  }
  if (isset($_SESSION['user_id']) || isset($_SESSION['cart']))
    // Show the cart items
    $cart = $_SESSION['cart'];
  $total_price = 0;
  foreach ($cart as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $product = Product::getProductById($product_id);
    echo "<h3>" . $product->name . "</h3>";
    echo "<p>" . $product->description . "</p>";
    echo "<p>Price: $" . $product->price . "</p>";
    echo "<p>Quantity: " . $quantity . "</p>";
    $total_price += $product->price * $quantity;
  }
  echo "<p>Total price: $$total_price</p>";
  $tax_cut = $total_price * 0.2;
  echo "<p>Tax cut: $$tax_cut</p>";

  $user_id = $_SESSION['user_id'];
  $user = User::getUserById($user_id);

  // Buy button
  ?>
  <form action="orders.php" method="post">
    <input type="hidden" name="user_id" value="<?php echo $user->user_id ?>">

    <?php
    $products = "";
    foreach ($cart as $item) {
      $product_id = $item['product_id'];
      $quantity = $item['quantity'];
      $products .= $product_id . "," . $quantity . ";";
    }
    ?>
    <input type="hidden" name="products" value="<?php echo $products ?>">
    <input type="submit" value="Buy">
  </form>
</div>