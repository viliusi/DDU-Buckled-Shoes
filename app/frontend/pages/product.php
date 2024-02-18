<?php
$product_id = $_GET['product_id'];

$product = Product::getProductById($product_id);
?>

<body>
  <div class="desktop-content">
    <div class="split">
      <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="productDesc">
          <h2Black class="pName">
            <?php echo $product->name ?>
          </h2Black>
          <p class="pDesc">
            <?php echo $product->description ?>
          </p>

          <?php
          $price = Product::getCurrentPrice($product_id);
          $priceO = Product::getOriginalPrice($product_id);
          $discount = Product::getDiscount($product_id);

          if ($discount > 0) {
            echo "<span class='old-price' style='font-size: 0.8em; text-decoration: line-through;'>$" . $priceO . "</span>";
            echo "<span class='new-price' style='font-weight:'>$" . $price . "</span>";
          } else {
            echo "<span class='new-price'>$" . $price . "</span>";
          }
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

              boxes.forEach(function(box) {
                box.addEventListener('click', function() {
                  // Remove the 'selected' class from all boxes
                  boxes.forEach(function(otherBox) {
                    otherBox.classList.remove('selected');
                  });

                  // Add the 'selected' class to the clicked box
                  this.classList.add('selected');

                  var value = this.getAttribute('data-value');
                  handleSelect(value);
                });
              });

              document.getElementById('productVariations').addEventListener('change', function() {
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

          <form method="post" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
            <input type="hidden" id="selectedVariation" name="variation_id">
            <input type="hidden" name="quantity" value="1">
            <input type="submit" name="add_to_cart" value="Add to Cart">
          </form>
        </div>
      </div>

      <?php

      $images = Product::getImagesByProductId($product_id);
      foreach ($images->results() as $image) {
      ?>
        <div class="imageAlignment">
          <?php
          echo "<img src='" . $image->image_location . "' width='100%' height='100%'>" . "<br>";
          ?>
        </div>
      <?php
      }

      ?>

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

  <!-- Mobile content -->
  <div class="mobile-content">
    <?php
    $images = Product::getImagesByProductId($product_id);
    foreach ($images->results() as $image) {
    ?>
      <div class="imageAlignment">
        <?php
        echo "<img src='" . $image->image_location . "' width='100%' height='100%'>" . "<br>";
        ?>
      </div>


      <div class="product-and-reviews-container">
        <div class="productDescContainer" style="padding: 20px; border: 1px solid #ccc; margin-bottom: 20px;">
          <div class="productDesc" style="padding-bottom: 20px;">

            <!-- Container for product details -->
            <div class="productDetailsContainer" style="padding: 20px;">
              <h2Black class="pName">
                <?php echo $product->name ?>
              </h2Black>
              <p class="pDesc">
                <?php echo $product->description ?>
              </p>

              <?php
              $price = Product::getCurrentPrice($product_id);
              $priceO = Product::getOriginalPrice($product_id);
              $discount = Product::getDiscount($product_id);

              if ($discount > 0) {
                echo "<span class='old-price' style='font-size: 0.8em; text-decoration: line-through;'>$" . $priceO . "</span>";
                echo "<span class='new-price' style='font-weight:'>$" . $price . "</span>";
              } else {
                echo "<span class='new-price'>$" . $price . "</span>";
              }
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
                  addToCartButton.disabled = true;

                  var boxes = document.querySelectorAll('.box');

                  boxes.forEach(function(box) {
                    box.addEventListener('click', function() {
                      boxes.forEach(function(otherBox) {
                        otherBox.classList.remove('selected');
                      });

                      this.classList.add('selected');

                      var value = this.getAttribute('data-value');
                      handleSelect(value);
                    });
                  });

                  document.getElementById('productVariations').addEventListener('change', function() {
                    handleSelect(this.value);
                  });
                });

                function handleSelect(value) {
                  var addToCartButton = document.querySelector('input[name="add_to_cart"]');
                  if (value === "") {
                    document.getElementById('stock').textContent = "";
                    addToCartButton.disabled = true;
                    return;
                  }

                  document.getElementById('selectedVariation').value = value;

                  fetch('get-stock.php?variation_id=' + value)
                    .then(response => response.text())
                    .then(data => {
                      var stockText = "Stock: " + data;
                      document.getElementById('stock').textContent = stockText;

                      addToCartButton.disabled = (data == 0);
                    })
                    .catch(error => console.error('Error:', error));
                }
              </script>
            </div>

            <!-- Rest of the content within productDesc -->

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
    <?php
    }
    ?>
  </div>




  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (window.innerWidth <= 767) {
        var mobileContainer = document.createElement('div');
        mobileContainer.className = 'mobile-container';

        // Code to modify HTML structure for mobile

        // Remove existing elements for large screens
        var desktopContent = document.querySelector('.desktop-content');
        if (desktopContent) {
          desktopContent.remove();
        }

        // Append mobile container to the body
        document.body.appendChild(mobileContainer);
      } else {
        // Code to handle large screens

        // Remove existing elements for mobile screens
        var mobileContent = document.querySelector('.mobile-content');
        if (mobileContent) {
          mobileContent.remove();
        }
      }
    });
  </script>
  <!-- Script for adding padding to the top of the image, assuming that they're always perfect squares -->
  <!--<script>
    function updatePadding() {
      var productDescs = document.querySelectorAll('.mobile-content .product-and-reviews-container .productDesc');

      productDescs.forEach(function(productDesc) {
        var screenWidth = window.innerWidth;
        var paddingTop = (screenWidth - 35) + 'px';

        productDesc.style.paddingTop = paddingTop;
      });
    } 

    document.addEventListener('DOMContentLoaded', updatePadding);

    window.addEventListener('resize', updatePadding);
  </script>-->