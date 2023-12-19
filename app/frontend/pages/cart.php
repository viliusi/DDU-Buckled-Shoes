<div class="container" style="margin-top:30px">
  <h2>Cart</h2>

  <?php
  session_start();

  // Initialize cart if not already done
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

 // Add product to cart, increase or decrease quantity
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1; // Default to 1 if 'quantity' is not set

    // Check if the product already exists in the cart
    $product_exists_in_cart = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            // If the product exists, increase or decrease its quantity
            $item['quantity'] += $quantity;
            $product_exists_in_cart = true;
            // If quantity is 0 or less, remove the product from the cart
            if ($item['quantity'] <= 0) {
                unset($_SESSION['cart'][$key]);
            }
            break;
        }
    }

  // If the product doesn't exist in the cart, add it
  if (!$product_exists_in_cart && $quantity > 0) {
      $_SESSION['cart'][] = ['product_id' => $product_id, 'quantity' => $quantity];
  }

  // If quantity is 0 or less, remove the product from the cart
  if ($quantity <= 0) {
      foreach ($_SESSION['cart'] as $key => $item) {
          if ($item['product_id'] == $product_id) {
              unset($_SESSION['cart'][$key]);
              break;
          }
      }
  }

  // Redirect back to the cart page
  header('Location: cart.php');
  exit;
}

  // Clear cart
  if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
  }

  // Remove product from cart
  if (isset($_POST['remove_from_cart'])) {
    if (isset($_POST['remove_from_cart'])) {
      $product_id = $_POST['product_id'];
      foreach ($_SESSION['cart'] as $key => $item) {
          if ($item['product_id'] == $product_id) {
              unset($_SESSION['cart'][$key]);
              break;
          }
      }
  }
  }

  // Display the product in the cart
  $total_price = 0;
  if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];

    $product = Product::getProductById($product_id);
    // Add product price to total price
    $total_price += $product->price * $quantity;

    // Display product details
    echo "<h3>" . $product->name . "</h3>";
    echo "<p>" . $product->description . "</p>";
    echo "<p>Price: $" . $product->price . "</p>";
    echo "<p>Quantity: " . $quantity . "</p>";

    // Button to remove product from cart
    echo "<form action='cart.php' method='post'>";
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "<input type='submit' name='remove_from_cart' value='Remove from Cart'>";
    echo "</form>";


    // Add more of the same product
    echo "<form action='cart.php' method='post'>";
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "<input type='hidden' name='quantity' value='1'>";
    echo "<input type='submit' name='add_to_cart' value='+1'>";
    echo "</form>";

    // Remove one of the same product
    echo "<form action='cart.php' method='post'>";
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "<input type='hidden' name='quantity' value='-1'>";
    echo "<input type='submit' name='add_to_cart' value='-1'>";
    echo "</form>";


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