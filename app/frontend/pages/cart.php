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
  // Debugging output
  echo "<pre>";
  var_dump($_SESSION['cart']);
  echo "</pre>";

  foreach ($_SESSION['cart'] as $product_id) {
    // Debugging output
    echo "<p>Product ID: $product_id</p>";

    $product = Product::getProductById((int)$product_id);

    // Check if product exists
    if ($product === null) {
      echo "<p>Product with ID $product_id not found.</p>";
      continue;
    }
    
    // Add product price to total price
    $total_price += $product->price;

    if (isset($_POST['add_more_product'])) {
      //then + another product to the total price and add one to quantity
      $total_price += $product->price;
      // Assuming you have a way to track quantity per product in your cart
      // $_SESSION['cart'][$product_id] += 1;
    }

    if (isset($_POST['remove_product'])) {
      if (isset($_SESSION['cart'][$product_id]) && $_SESSION['cart'][$product_id] > 0) {
        $_SESSION['cart'][$product_id] -= 1;
        $total_price -= $product->price;
      }
    }
  }


// Display the products in the cart
foreach ($_SESSION['cart'] as $product_id => $quantity) {
  $product = Product::getProductById($product_id);

  // Check if product exists
  if ($product === null) {
    echo "<p>Product with ID $product_id not found.</p>";
    continue;
  }

  // Display product details
  echo "<h3>" . $product->name . "</h3>";
  echo "<p>" . $product->description . "</p>";
  echo "<p>Price: $" . $product->price . "</p>";
  echo "<p>Quantity: ". $quantity ."</p>";
}

      // Button to remove product from cart
     echo "<form action='cart.php' method='post'>";
     echo "<input type='hidden' name='product_id' value='$product_id'>";
     echo "<input type='submit' name='remove_from_cart' value='Remove from Cart'>";
     echo "</form>";

      // Add more of the same product
      echo "<form action='cart.php' method='post'>";
      echo "<input type='hidden' name='product_id' value='$product_id'>";
      echo "<input type='submit' name='add_more_product' value='+1'>";
     echo "</form>";

      // Remove one of the same product
      echo "<form action='cart.php' method='post'>";
      echo "<input type='hidden' name='product_id' value='$product_id'>";
      echo "<input type='submit' name='remove_product' value='-1'>";
      echo "</form>";

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