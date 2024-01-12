<div class="container" style="margin-top:30px">
  <h2>Reviews</h2>

  <?php 
  $reviews = Review::getAllReviews();
  if ($reviews->count()) {
    echo $reviews->count() . " reviews found.";
    echo "<table style='width:100%; border: 1px solid'>";
    echo "<tr>";
    echo "<th>Review_id</th>";
    echo "<th>Product_id</th>";
    echo "<th>Rating</th>";
    echo "<th>Username</th>";
    echo "<th>Text</th>";
    echo "<th>Timestamp</th>";
    echo "</tr>";
    foreach ($reviews->results() as $review) {
      // build a table with the results, printing the variables "name", "price", "category" and "description"
      echo "<tr>";
      echo "<td>" . $review->review_id . "</td>";
      echo "<td>" . $review->product_id . "</td>";
      echo "<td>" . $review->rating . "</td>";
      echo "<td>" . User::getUserById($review->user_id)->username . "</td>";
      echo "<td>" . $review->text . "</td>";
      echo "<td>" . $review->time . "</td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "No products found.";
  }
  ?>

</div>