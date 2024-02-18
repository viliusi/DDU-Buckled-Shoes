<style>
  /* General Styles */
  .table-container {
    max-height: 80vh;
    overflow-y: auto;
  }

  .table-scroll {
    width: 100%;
    border-collapse: collapse;
  }

  .table-scroll th,
  .table-scroll td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  /* Product Styles */
  .product {
    display: flex;
    align-items: center;
    border: 1px solid white;
    padding: 5px;
    margin: 10px 30px;
  }

  .imageAlignment {
    width: 20%;
  }

  .product-details {
    width: 60%;
    padding: 0 0px;
  }

  .product-price {
    width: 20%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Button Styles */
  .decrement-button,
  .increment-button,
  .remove-button {
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
    width: 70px;
  }

  /* Price Styles */
  .product-price .old-price,
  .product-price .new-price {
    display: inline-block;
  }

  .new-price {
    font-size: 2em;
    font-weight: bold;
  }

  /* Custom Horizontal Rule */
  .custom-hr {
    border-color: white;
    border-width: 2px;
  }

  /* Responsive Styles */
  @media (max-width: 599px) {
    .imageAlignment img {
      width: 80%;
    }

    .product-details,
    .product-price {
      font-size: 0.8em;
    }

    .product-details hr {
      border-width: 1px;
    }

    .table-container {
      max-height: none;
    }

    .product-price .old-price,
    .product-price .new-price {
      display: block;
    }

    .product {
      margin: 5px 5px;
    }

    .new-price {
      font-size: 1em;
    }

    .custom-hr {
      border-width: 1px;
    }
  }

  /* Purchase Box Styles */
  .purchase-box {
    text-align: center;
    display: flex;
    flex-direction: column;
    height: 100%;
    color: black;
  }

  .purchase-box h1 {
    font-size: 2em;
    margin-bottom: 0px;
  }

  .slogan-box {
    max-height: 100%;
    padding: 25px;
    margin: 0px 0;
    font-weight: lighter;
  }

  .total-price {
    font-size: 1.5em;
    margin-bottom: 10px;
    font-weight: bold;
    text-decoration: underline;
  }

  .tax-cut {
    font-size: 1.2em;
    margin-bottom: 20px;
  }

  .checkout-button {
    font-size: 1.5em;
    margin-bottom: 10px;
    background-color: #F2C744;
    border-radius: 7.5px;
  }

</style>

<?php
$product_id = $_GET['product_id'];

$product = Product::getProductById($product_id);
?>

<body>

  <div class="row">
    <div class="col-sm-6" style="padding:0px">
      <?php
      $images = Product::getImagesByProductId($product_id);
      foreach ($images->results() as $image) {
        ?>
        <?php
        echo "<img src='" . $image->image_location . "' width='100%' height='100%'>" . "<br>";
        ?>
        <?php
      }
      ?>
    </div>
    <div class="col-sm-6" style="background-color: #D9D9D9; padding-bottom: 15px; padding-top: 15px;">
      <div class="purchase-box">
        <h1>
          <?php echo $product->name ?>
        </h1>

        <div class="slogan-box">
          <h4 style="color:black;">
            <?php echo $product->description ?>
          </h4>
        </div>

        <?php
        $price = Product::getCurrentPrice($product_id);
        $priceO = Product::getOriginalPrice($product_id);
        $discount = Product::getDiscount($product_id);
        ?>

        <?php
        $variations = Product::getProductVariationsById($product_id);

        usort($variations, function ($a, $b) {
          return $a->name <=> $b->name;
        });

        $textBasedNames = array_filter($variations, function ($variation) {
          return !is_numeric($variation->name);
        });

        if (count($textBasedNames) > 0) {
          echo '<select id="productVariations">';
          echo '<option value="">Select a variation</option>';

          foreach ($textBasedNames as $variation) {
            echo '<option value="' . $variation->variation_id . '">' . $variation->name . '</option>';
          }

          echo '</select>';
        }

        echo '<div class="box-container">';

        $numericNames = array_filter($variations, function ($variation) {
          return is_numeric($variation->name);
        });

        foreach ($numericNames as $variation) {
          $floatValue = floatval($variation->name);
          echo '<div class="box" data-value="' . $variation->variation_id . '">' . $floatValue . '</div>';
        }

        echo '</div>';
        ?>
        <p id="stock"></p>
        <script>
          document.addEventListener('DOMContentLoaded', (event) => {
            var addToCartButton = document.querySelector('input[name="add_to_cart"]');
            addToCartButton.disabled = true; // Disable the "Add to Cart" button initially

            var boxes = document.querySelectorAll('.box');

            boxes.forEach(function (box) {
              box.addEventListener('click', function () {
                // Remove the 'selected' class from all boxes
                boxes.forEach(function (otherBox) {
                  otherBox.classList.remove('selected');
                });

                // Add the 'selected' class to the clicked box
                this.classList.add('selected');

                var value = this.getAttribute('data-value');
                handleSelect(value);
              });
            });

            document.getElementById('productVariations').addEventListener('change', function () {
              handleSelect(this.value);
            });
          });

          function handleSelect(value) {
            var addToCartButton = document.querySelector('input[name="add_to_cart"]');
            if (value === "") {
              document.getElementById('stock').textContent = "";
              addToCartButton.disabled = true; // Disable the "Add to Cart" button
              return;
            }

            document.getElementById('selectedVariation').value = value;

            fetch('get-stock.php?variation_id=' + value)
              .then(response => response.text())
              .then(data => {
                var stockText = "Stock: " + data;
                document.getElementById('stock').textContent = stockText;

                // If the stock is 0, disable the "Add to Cart" button. Otherwise, enable it.
                addToCartButton.disabled = (data == 0);
              })
              .catch(error => console.error('Error:', error));
          }
        </script>

        <?php
        $tax_cut = Product::getCurrentPrice($product_id) * 0.2;
        if ($discount > 0) {
          echo "<span class='old-price' style='font-size: 0.8em; text-decoration: line-through;'>$" . $priceO . "</span>";
          echo "<span class='new-price' style='font-weight:'>$" . $price . "</span>";
        } else {
          echo "<span class='new-price'>$" . $price . "</span>";
        }
        ?>

        <div class="buttons-box">
          <form method="post" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
            <input type="hidden" id="selectedVariation" name="variation_id">
            <input type="hidden" name="quantity" value="1">
            <input class="checkout-button" type="submit" name="add_to_cart" value="Add to Cart">
          </form>
        </div>
      </div>
    </div>
  </div>

  </div>
  <div class="row reviews">
    <div class="col-sm-4">
      <h2 class="reviewsHeader">Reviews</h2>

      <?php if ($user->isLoggedIn()) { ?>
        <a href="add-review.php?product_id=<?php echo $product_id ?>" class="btn btn-primary">Post a review</a> <br>
      <?php } ?>

      <?php
      $reviews = Review::getReviewsByProductId($product_id);
      if ($reviews !== null && $reviews->count() > 0) {
        foreach ($reviews->results() as $review) {
          ?>
          <div class="review">
            <p>
              <?php echo $review->rating ?>/5
            </p>
            <p>
              <?php echo $review->text ?>
            </p>
            <p>
              <?php echo $review->time ?>
            </p>
            <p>
              <?php
              $comment_user = User::getUserById($review->user_id);
              echo $comment_user->username ?>
            </p>
            <?php

            if ($user->isLoggedIn()) {
              if ($user->data()->user_id == $review->user_id) {
                ?>
                <a href="manage-review.php?review_id=<?php echo $review->review_id ?>" class="btn btn-primary">Manage</a>
                <?php
              }
            }

            ?>
          </div>
          <?php
        }
      } else {
        echo "<h3 class='NoReviews'>No reviews for this product yet.</h3>";
      }

      ?>
    </div>
  </div>
  </div>