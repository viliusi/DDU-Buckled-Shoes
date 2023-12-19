<?php
$product_id = $_GET['product_id'];

$product = Product::getProductById($product_id);
?>

<div class="split" style="margin-top:30px">
  <h2><?php echo $product->name ?></h2>
  <div class="row">
    <div class="col-sm-4">
      <img src="<?php echo $product->image ?>" alt="<?php echo $product->name ?>" style="width:100%">
    </div>
    <div class="col-sm-8">
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
    echo "<img src='" . $image->image_location . "' width='200' height='200'>" . "<br>";
  }

  ?>

</div>