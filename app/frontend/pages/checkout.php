<style>
  /* Container for the table */
  .table-container {
    max-height: 80vh;
    /* Set a maximum height for the container */
    overflow-y: auto;
    /* Enable vertical scrolling if content overflows */
  }

  /* Style the table */
  .table-scroll {
    width: 100%;
    /* Table should take 100% width of its container */
    border-collapse: collapse;
    /* Remove cell spacing and borders */
  }

  /* Style table headers and cells */
  .table-scroll th,
  .table-scroll td {
    padding: 8px;
    /* Add padding for better readability */
    text-align: left;
    /* Adjust text alignment as needed */
    border-bottom: 1px solid #ddd;
    /* Add a bottom border to cells */
  }

  .product {
    display: flex;
    flex-direction: row;
    align-items: center;
    border: 1px solid white;
    padding: 5px;
    margin-top: 10px;
    margin-bottom: 10px;
    margin-left: 30px;
    margin-right: 30px;
  }

  .imageAlignment {
    width: 20%;
  }

  .product-details {
    width: 60%;
    padding-left: 10px;
    padding-right: 10px;
  }

  .product-details h3 {
    font-size: 1.2em;
    /* Make title bigger on larger screens */
  }

  .product-price {
    width: 20%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .decrement-button,
  .increment-button {
    width: 30px;
    height: 30px;
    padding: 0;
    border: none;
    margin-right: 5px;
    font-size: 1.2em;
    text-align: center;
    line-height: 30px;
    vertical-align: middle;
    border-radius: 5px;
  }

  .remove-button {
    font-size: 1.2em;
    height: 30px;
    padding: 0 10px;
    border: none;
    line-height: 30px;
    vertical-align: middle;
    border-radius: 5px;
  }

  .product-price .old-price,
  .product-price .new-price {
    display: inline-block;
    /* Keep price on the same line on larger screens */
  }

  .new-price {
    font-size: 2em;
    font-weight: bold;
    /* Make the new price text bold */
  }

  .custom-hr {
    border-color: white;
    border-width: 2px;
  }

  @media (max-width: 599px) {
    .imageAlignment img {
      width: 80%;
    }

    .product-details,
    .product-price {
      font-size: 0.8em;
    }

    .product-details h3 {
      font-size: 0.9em;
    }

    .product-details hr {
      border-width: 1px;
      /* Make horizontal rule thinner on smaller screens */
    }

    .product-price .old-price,
    .product-price .new-price {
      display: block;
      /* Stack price on smaller screens */
    }

    .new-price {
      font-size: 1em;
      font-weight: bold;
      /* Make the new price text bold */
    }

    .custom-hr {
      border-width: 1px;
    }
  }

  .purchase-box {
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    color: black;
  }

  .purchase-box h1 {
    margin-bottom: 20px;
  }

  .slogan-box {
    max-height: 100%;
    padding: 10px;
    margin: 20px 0;
  }

  .slogan-box h2 {
    font-size: 1.5em;
    color: black;
  }

  .total-price {
    font-size: 1.5em;
    margin-bottom: 10px;
    font-weight: bold;
    /* Make the total price text bold */
    text-decoration: underline;
    /* Underline the total price text */
  }

  .tax-cut {
    font-size: 1.2em;
    margin-bottom: 20px;
  }

  .buttons-box {
    margin-bottom: 20px;
  }

  .checkout-button {
    font-size: 1.5em;
    padding: 10px 20px;
    margin-bottom: 10px;
    background-color: #F2C744;
    border-radius: 7.5px;
  }

  .clear-cart-button {
    font-size: 1.2em;
    padding: 5px 10px;
  }

  .small-text {
    position: absolute;
    bottom: 0;
    left: 0;
    font-size: 0.2em;
    color: black;
  }
</style>

<?php
session_start(); // Start the session at the beginning of your script




$products = $_SESSION['cart'];

// Display the product in the cart

if (!empty($_SESSION['cart'])) {
  if (!empty($_SESSION['user'])) {
    
    $user_id = $_SESSION['user'];
    $currentUser = User::getUserById($user_id); // Fetch the user details and store it in $currentUser
    ?>
    <div class="row">
      <div class="col-sm-8">
        <div class="table-container">
          <ul class="nav nav-pills flex-column">
            <?php
            $total_price = 0;

            foreach ($_SESSION['cart'] as $key => $item) {
              $product_id = $item['product_id'];
              $variation_id = $item['variation_id'];
              $quantity = $item['quantity'];

              $product = Product::getProductById($product_id);
              $variation = Product::getVariationByVariationId($variation_id);

              // Add product price to total price
              $total_price += Product::getCurrentPrice($product->product_id) * $quantity;

              // Start product div
              echo "<div class='product'>";

              // Display product image
              $images = Product::getImagesByProductId($product_id);
              foreach ($images->results() as $image) {
                echo "<div class='imageAlignment'>";
                echo "<img src='" . $image->image_location . "' style='height: auto; width: 100%; object-fit: contain;'>" . "<br>";
                echo "</div>";
              }

              // Start product details div
              echo "<div class='product-details'>";

              // Display product details
              echo "<h3>" . $quantity . " x " . $product->name . " - " . $variation->name . "</h3>";
              echo "<hr class='custom-hr'>";
              echo "<p>" . $product->description . "</p>";

              

              echo "</div>"; // End product details div
        
              // Start price div
              echo "<div class='product-price'>";

              // Display product price
              $price = Product::getCurrentPrice($product_id);
              $priceO = Product::getOriginalPrice($product_id);
              $discount = Product::getDiscount($product_id);

              if ($discount > 0) {
                echo "<span class='old-price' style='font-size: 0.8em; text-decoration: line-through; margin-right: 10px;'>$" . $priceO . "</span><br class='mobile-break'>";
                echo "<span class='new-price'>$" . $price . "</span>";
              } else {
                echo "<span class='new-price'>$" . $price . "</span>";
              }

              echo "</div>"; // End price div
        
              echo "</div>"; // End product div
            }
            ?>
          </ul>
        </div>
      </div>
      <div class="col-sm-4" style="background-color: #D9D9D9; padding-bottom: 15px; padding-top: 15px;">
        <div class="purchase-box">
          <h1>Confirm Order</h1>
          <div class="slogan-box">
            <h2>All our products are made of the finest Taiwanese Children by Taiwanese Children <br>
              In the case of a defective product returns are always possible*</h2>
          </div>
          <?php
          $tax_cut = $total_price * 0.2;
          echo "<p class='total-price'>Total: $" . $total_price . "</p>";
          echo "<p class='tax-cut'>Tax: $$tax_cut</p>";
          ?>

          <div class="buttons-box">

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
              <input class='checkout-button' type="submit" value="Buy">
            </form>

          </div>
        </div>
        <div class="small-text">
          <p>*(Until 3 minutes after arrival as we’ll no longer support your product by then)</p>
        </div>
      </div>
    </div>
    <?php
  } else {
    echo "<h3 style='margin: auto;
    margin-top: 20vh;
    margin-bottom: 20vh;
    width: 50%;
    padding: 10px;
    text-align: center;'>You need to be logged in to order.</h3>";
  }
} else {
  echo "<h3 style='margin: auto;
  margin-top: 20vh;
  margin-bottom: 20vh;
  width: 50%;
  padding: 10px;
  text-align: center;'>Your cart is empty.</h3>";
}

?>
</div>