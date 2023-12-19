<div class="container" style="margin-top:30px">
    <h2>Edit Image</h2>

    <br>
    <form method="post">
        <input type="submit" name="delete" id="test" value="Delete Image" /><br />
    </form>

    <?php

    function delete()
    {
        Image::delete($_GET['image_id']);
        Redirect::to('management-images.php');
    }
    if (array_key_exists('delete', $_POST)) {
        delete();
    }
    ?>

    <?php
    if (isset($_GET['image_id']))
        $image = Image::getImageById($_GET['image_id']);
    ?>

    <br>
    
    <h4>Current info:</h4>
    <li style="font-weight: bold">ID:</li>
    <?php echo $image->image_id ?>
    <li style="font-weight: bold">Name: </li>
    <?php echo $image->name ?>
    <li style="font-weight: bold">Image_Location: </li>
    <?php echo $image->image_location ?>

    <br>

    <?php

    echo "<img src='" . $image->image_location . "' width='200' height='200'>";

    ?>

    <br> <br>

    <h4>Update info:</h4>

    <form action="management-edit-images.php" method="post">
        <input type="hidden" name="image_id" value="<?php echo $image->image_id ?>">
        <div class="form-group">
            <label for="name">Name :</label> <br>
            <input type="text" name="name" id="name" value="<?php echo $image->name ?>">
        </div>
        <div class="form-group">
            <label for="image_location">Image_Location :</label> <br>
            <input type="text" name="image_location" id="image_location" value="<?php echo $image->image_location ?>">
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Update">
    </form>
</div>