<div class="container" style="padding-top: 5%; padding-bottom: 5%;">
    <h2>Create comment Form</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="5" id="content" name="content"></textarea>
            <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
            <input type="submit" class="btn-register" value="Create a comment">
    </form>
</div>