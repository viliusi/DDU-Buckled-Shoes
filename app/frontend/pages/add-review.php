<div class="container" style="padding-top: 5%; padding-bottom: 5%;">
    <h2>Post Review</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="rating">Rating :</label>
            <select class="form-control" id="rating" name="rating">
                <option value="">Select rating</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="form-group">
            <label for="text">Review :</label>
            <input type="text" class="form-control" id="text" placeholder="Enter review" name="text">
        </div>
        <input type="hidden" name="user_id" value="<?php echo $user->data()->user_id ?>">
        <input type="hidden" name="product_id" value="<?php echo $_GET['product_id'] ?>">
        <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Post Review">
    </form>
</div>