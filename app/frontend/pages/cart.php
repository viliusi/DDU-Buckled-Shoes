<div class="container" style="margin-top:30px">
  <h2>Cart</h2>

  <?php
  session_start();

  // Initialize cart if not already done
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  // Add product to cart
  if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $variation_id = $_POST['variation_id'];

    // Use a combination of the product ID and the variation ID as the key
    $key = $product_id . '-' . $variation_id;

    $_SESSION['cart'][$key] = array(
      'product_id' => $product_id,
      'variation_id' => $variation_id,
      'quantity' => 1
    );

    // Redirect back to the cart page
    header('Location: cart.php');
    exit;
  }

  // Remove product from cart
  if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    $variation_id = $_POST['variation_id'];

    // Use the same key to remove the item from the cart
    $key = $product_id . '-' . $variation_id;

    if (isset($_SESSION['cart'][$key])) {
      unset($_SESSION['cart'][$key]);
    }

    // Redirect back to the cart page
    header('Location: cart.php');
    exit;
  }
  // Increment quantity of product in cart
  if (isset($_POST['increment_quantity'])) {
    $product_id = $_POST['product_id'];
    $variation_id = $_POST['variation_id'];

    // Use the same key to access the item in the cart
    $key = $product_id . '-' . $variation_id;

    if (isset($_SESSION['cart'][$key])) {
      $current_stock = Product::getStockByVariationId($variation_id);
      if ($_SESSION['cart'][$key]['quantity'] < $current_stock) {
        $_SESSION['cart'][$key]['quantity'] += 1;
      }
    }

    // Redirect back to the cart page
    header('Location: cart.php');
    exit;
  }

  // Decrement quantity of product in cart
  if (isset($_POST['decrement_quantity'])) {
    $product_id = $_POST['product_id'];
    $variation_id = $_POST['variation_id'];

    // Use a combination of the product ID and the variation ID as the key
    $key = $product_id . '-' . $variation_id;

    if (isset($_SESSION['cart'][$key]) && $_SESSION['cart'][$key]['quantity'] > 1) {
      $_SESSION['cart'][$key]['quantity'] -= 1;
    } else if (isset($_SESSION['cart'][$key]) && $_SESSION['cart'][$key]['quantity'] == 1) {
      unset($_SESSION['cart'][$key]);
    }

    // Redirect back to the cart page
    header('Location: cart.php');
    exit;
  }

  // Clear cart
  if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
  }

  // Display the product in the cart
  $total_price = 0;
  if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $item) {
      $product_id = $item['product_id'];
      $variation_id = $item['variation_id'];
      $quantity = $item['quantity'];

      $product = Product::getProductById($product_id);
      $variation = Product::getVariationByVariationId($variation_id);

      // Add product price to total price
      $total_price += Product::getCurrentPrice($product->product_id) * $quantity;

      // Display product details
      echo "<h3>" . $product->name . "</h3>";
      echo "<p>" . $product->description . "</p>";
      echo "<p>Price: $" . Product::getCurrentPrice($product->product_id) . "</p>";
      echo "<p>Quantity: " . $quantity . "</p>";
      echo "<p>Variation: " .  $variation->name . "</p>";
  ?>
      <!-- Remove from Cart -->
      <form method="post" action="cart.php">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="hidden" name="variation_id" value="<?php echo $variation_id; ?>">
        <input type="submit" name="remove_from_cart" value="Remove from Cart">
      </form>

      <!-- Add More of the Same Product -->
      <form method="post" action="cart.php">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="hidden" name="variation_id" value="<?php echo $variation_id; ?>">
        <input type="submit" name="increment_quantity" value="+1">
      </form>

      <!-- Remove One of the Same Product -->
      <form method="post" action="cart.php">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="hidden" name="variation_id" value="<?php echo $variation_id; ?>">
        <input type="submit" name="decrement_quantity" value="-1">
      </form>
  <?php
    }

    $tax_cut = $total_price * 0.2;
    echo "<p>Total price: $" . $total_price . "<br>";
    echo "Tax cut: $$tax_cut</p>";


    // Button to clear cart
    echo "<form action='cart.php' method='post'>";
    echo "<input type='submit' name='clear_cart' value='Clear Cart'>";
    echo "</form>";

    // Button to checkout
    echo "<form action='checkout.php' method='post'>";
    echo "<input type='submit' name='checkout' value='Checkout'>";
    echo "</form>";
  } else {
    echo "<p>Your cart is empty.</p>";
  }
  ?>
</div>