<div class="container" style="padding-top: 5%; padding-bottom: 5%;">
    <h2>Update Review</h2>
    <form action="" method="post">
        <div class="form-group">
            <?php
            $rating = Review::getReviewById($_GET['review_id'])->rating;
            ?>

            <label for="rating">Rating :</label>
            <select class="form-control" id="rating" name="rating">
                <option value="">Select rating</option>
                <option value="1" <?php if ($rating == 1)
                    echo 'selected'; ?>>1</option>
                <option value="2" <?php if ($rating == 2)
                    echo 'selected'; ?>>2</option>
                <option value="3" <?php if ($rating == 3)
                    echo 'selected'; ?>>3</option>
                <option value="4" <?php if ($rating == 4)
                    echo 'selected'; ?>>4</option>
                <option value="5" <?php if ($rating == 5)
                    echo 'selected'; ?>>5</option>
            </select>
        </div>
        <div class="form-group">
            <label for="text">Review :</label>
            <input type="text" class="form-control" id="text" placeholder="Enter review" name="text" value="<?php
            $review = Review::getReviewById($_GET['review_id']);

            echo $review->text;
            ?>">
        </div>
        <input type="hidden" name="user_id" value="<?php echo $review->user_id ?>">
        <input type="hidden" name="review_id" value="<?php echo $review->review_id ?>">
        <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Update Review">
    </form>
    <form method="post">
        <input type="submit" name="delete" id="test" value="Delete Review" /><br />
    </form>

    <?php

    function delete()
    {
        $product_id = Review::getReviewById($_GET['review_id'])->product_id;
        Review::delete($_GET['review_id']);
        Redirect::to('product.php?product_id=' . $product_id);
    }
    if (array_key_exists('delete', $_POST)) {
        delete();
    }
    ?>
</div>