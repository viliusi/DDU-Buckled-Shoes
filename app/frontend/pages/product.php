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

<div class="row reviews">
  <div class="col-sm-4">
    <h2>Reviews</h2>

    <?php if ($user->isLoggedIn()) { ?>
      <a href="add-review.php?product_id=<?php echo $product_id ?>" class="btn btn-primary">Post a review</a> <br>
    <?php } ?>

    <?php
$reviews = Review::getReviewsByProductId($product_id);
if ($reviews !== null && $reviews->count() > 0) {
    foreach ($reviews->results() as $review) {
    ?>
      <div class="review">
      <p><?php echo $review->rating ?>/5</p>
      <p><?php echo $review->text ?></p>
      <p><?php echo $review->time ?></p>
      <p><?php
          $user = User::getUserById($review->user_id);
          echo $user->username ?></p>
    </div>
    <?php
    }
} else {
    echo "<p>No reviews for this product yet.</p>";
}

    ?>
  </div>
</div>