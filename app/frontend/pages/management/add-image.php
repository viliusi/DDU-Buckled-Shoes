<div class="container" style="margin-top:30px">
    <h2>Add Image</h2>

    <h4>Image info:</h4>

    <form action="management-add-images.php" method="post">
        <div class="form-group">
            <label for="name">Name :</label> <br>
            <input type="text" name="name" id="name" value="">
        </div>
        <div class="form-group">
            <label for="image_location">Image Location :</label> <br>
            <input type="text" name="image_location" id="image_location" value="">
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Add">
</div>