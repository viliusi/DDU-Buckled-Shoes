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
    $quantity = $item['quantity'];
    $product = Product::getProductById($product_id);
    echo "<h3>" . $product->name . "</h3>";
    echo "<p>" . $product->description . "</p>";
    echo "<p>Price: $" . Product::getCurrentPrice($product->product_id) . "</p>";
    echo "<p>Quantity: " . $quantity . "</p>";
    $total_price += Product::getCurrentPrice($product->product_id) * $quantity;
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
    foreach ($_SESSION['cart'] as $item) {
      $product_id = $item['product_id'];
      $quantity = $item['quantity'];
      $products .= $quantity . "," . $product_id . ";";
    }
    ?>
    <input type="hidden" id="products" name="products" value="<?php echo $products ?>">
    <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Buy">
  </form>
</div>