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
            echo $review->rating . "/5 stars <br>";
            echo $review->text . "<br><br>";
        }
    } else {
        echo "No reviews found.";
    }

    ?>
    <br>
</div>