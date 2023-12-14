<div class="container" style="margin-top:30px">
  <h2>Cart</h2>

<?php
session_start();

// Add product to cart
if (isset($_POST['add_to_cart'])) {
  $product_id = $_POST['product_id'];
  if (!isset($_SESSION['cart']) || !in_array($product_id, $_SESSION['cart'])) {
    $_SESSION['cart'][] = $product_id;
  }
}

// Remove product from cart
if (isset($_POST['remove_from_cart'])) {
  $product_id = $_POST['product_id'];
  if (($key = array_search($product_id, $_SESSION['cart'])) !== false) {
    unset($_SESSION['cart'][$key]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
  }
}

// Clear the cart
if (isset($_POST['clear_cart'])) {
  unset($_SESSION['cart']);
}

// Total price
$total_price = 0;

// Display the products in the cart
if (!empty($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $product_id) {
    $product = Product::getProductById($product_id);
    
    // Display product details
    echo "<h3>" . $product->name . "</h3>";
    echo "<p>" . $product->description . "</p>";
    echo "<p>Price: $" . $product->price . "</p>";
    
    // Button to remove product from cart
    echo "<form action='cart.php' method='post'>";
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "<input type='submit' name='remove_from_cart' value='Remove from Cart'>";
    echo "</form>";
    
    // Add product price to total price
    $total_price += $product->price;
  }

  echo "<p>Total price: $$total_price</p>";

  $tax_cut = $total_price * 0.2;
  echo "<p>Tax cut: $$tax_cut</p>";

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