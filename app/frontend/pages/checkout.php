<div class="container" style="margin-top:30px">
  <h2>Buy</h2>
  <?php
  session_start(); // Start the session at the beginning of your script

  // Check if the 'user' key exists in the session
  if (!isset($_SESSION['user'])) {
    echo "User ID is not set in the session.";
    exit;
  }

  $user_id = $_SESSION['user'];
  $currentUser = User::getUserById($user_id); // Fetch the user details and store it in $currentUser

  // Check if the 'cart' key exists in the session and it is not empty
  if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit;
  }

  $products = $_SESSION['cart'];

  // Show the cart items
  $total_price = 0;
  foreach ($products as $item) {
    $product_id = $item['product_id'];
    $variation_id = $item['variation_id'];
    $quantity = $item['quantity'];
    $price = Product::getOriginalPrice($product_id);
    $discount = Product::getDiscount($product_id);

    // Fetch product_name from the database
    $product_name = Product::getProductName($product_id);

    // Fetch variation_name from the database
    $variation_name = Product::getVariationName($variation_id);

    echo "<h3>" . $product_name . "</h3>";
    echo "<p>Price: $" . $price . "</p>";
    echo "<p>Discount: " . $discount . "%</p>";
    echo "<p>Quantity: " . $quantity . "</p>";
    echo "<p>Variation: " . $variation_name . "</p>";
    $total_price += $price * $quantity;
  }
  echo "<p>Total price: $$total_price</p>";
  $tax_cut = $total_price * 0.2;
  echo "<p>Tax cut: $$tax_cut</p>";

  // Buy button
  ?>
  <form action="orders.php" method="post">
    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id ?>">

    <?php
    $products = "";
    $stock_control = "";
    foreach ($_SESSION['cart'] as $item) {
      $product_id = $item['product_id'];
      $variation_id = $item['variation_id'];
      $quantity = $item['quantity'];
      $price = Product::getOriginalPrice($product_id);
      $discount = Product::getDiscount($product_id);

      // Fetch product_name from the database
      $product_name = Product::getProductName($product_id);

      // Fetch variation_name from the database
      $variation_name = Product::getVariationName($variation_id);

      $products .= $quantity . "," . $variation_name . "," . $price . "," . $discount . "," . $product_name . ";";
      $stock_control .= $quantity . "," . $variation_id . ";";
    }
    ?>
    <input type="hidden" id="products" name="products" value="<?php echo $products ?>">
    <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
    <input type="hidden" name="stock_control" value="<?php echo $stock_control ?>">
    <input type="submit" value="Buy">
  </form>
</div>