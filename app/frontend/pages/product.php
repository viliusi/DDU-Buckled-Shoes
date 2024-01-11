<?php
$product_id = $_GET['product_id'];

$product = Product::getProductById($product_id);
?>

<div class="split">
  <div class="row">
    <div class="col-sm-4">
    </div>
    <div class="productDesc">
      <h2Black><?php echo $product->name ?></h2Black>
      <p><?php echo $product->description ?></p>
      <p>$<?php echo $product->price ?></p>
      <form action="cart.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
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