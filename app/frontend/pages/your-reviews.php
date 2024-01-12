<div class="container" style="margin-top:30px">
    <h2>Your Reviews</h2><br>
    <?php
    // Check if session is not started, then start the session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        echo "You must be logged in to view your reviews.";
        exit;
    }

    $user_id = $_SESSION['user'];
    $reviews = Review::getReviewsByUserId($user_id); // Retrieve all reviews for the user

    if ($reviews !== null && $reviews->count() > 0) {
        foreach ($reviews->results() as $review) {
            $product = Product::getProductById($review->product_id);
            echo "<h4>" . $product->name . "</h4>";
            echo $review->rating . "/5 Stars <br>";
            echo $review->text . "<br>";
            if ($user->data()->user_id == $review->user_id) {
                ?>
                <a href="manage-review.php?review_id=<?php echo $review->review_id ?>" class="btn btn-primary">Manage</a> <br><br>
                <?php
              }
        }
    } else {
        echo "No reviews found.";
    }

    ?>
    <br>
</div>