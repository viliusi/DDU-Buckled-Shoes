<div class="container" style="margin-top:30px">
    <h2>Edit Product</h2>

    <br>
    <form method="post">
        <input type="submit" name="delete" id="test" value="Delete Product" /><br />
    </form>

    <?php

    function delete()
    {
        Product::delete($_GET['product_id']);
        Redirect::to('management-products.php');
    }
    if (array_key_exists('delete', $_POST)) {
        delete();
    }
    ?>

    <?php
    if (isset($_GET['product_id']))
        $product = Product::getProductById($_GET['product_id']);
    ?>

    <br>

    <h4>Current info:</h4>
    <li style="font-weight: bold">ID:</li>
    <?php echo $product->product_id ?>
    <li style="font-weight: bold">Name: </li>
    <?php echo $product->name ?>
    <li style="font-weight: bold">Description: </li>
    <?php echo $product->description ?>
    <li style="font-weight: bold">Original Price: </li>
    <?php echo Product::getOriginalPrice($product->product_id) ?>
    <li style="font-weight: bold">Discount_Price: </li>
    <?php echo Product::getCurrentPrice($product->product_id) ?>
    <li style="font-weight: bold">Category: </li>
    <?php echo $product->category ?>
    <li style="font-weight: bold">Images_Reference:></li>
    <?php echo $product->images_reference ?>

    <br>

    <?php
    $images = Product::getImagesByProductId($product->product_id);

    foreach ($images->results() as $image) {
        echo "<img src='" . $image->image_location . "' width='200' height='200'>";
    }
    ?>

    <br> <br>

    <h4>Update info:</h4>

    <form action="management-edit-products.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
        <div class="form-group">
            <label for="name">Name :</label> <br>
            <input type="text" name="name" id="name" value="<?php echo $product->name ?>">
        </div>
        <div class="form-group">
            <label for="description">Description :</label> <br>
            <input type="text" name="description" id="description" value="<?php echo $product->description ?>">
        </div>
        <div class="form-group">
            <label for="price">Original Price :</label> <br>
            <input type="text" name="price" id="price" value="<?php echo Product::getOriginalPrice($product->product_id) ?>">
        </div>
        <div class="form-group">
            <label for="category">Category :</label> <br>
            <input type="text" name="category" id="category" value="<?php echo $product->category ?>">
        </div>
        <div class="form-group">
            <label for="images_reference">Images_Reference :</label> <br>
            <input type="text" name="images_reference" id="images_reference" value="<?php echo $product->images_reference ?>">
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Update">
    </form>

    <br> <br>

    <h4>Variations:</h4>

    <?php
    $variations = Product::getProductVariationsById($product->product_id);

    // sort the variations by name
    usort($variations, function ($a, $b) {
        return $a->name <=> $b->name;
    });

    foreach ($variations as $variation) {
        echo "<li style='font-weight: bold'>Variation Name: </li>";
        echo $variation->name;
        echo "<form action='management-edit-products.php' method='post'>";
        echo "<input type='hidden' name='variation_id' value='" . $variation->variation_id . "'>";
        echo "<input type='hidden' name='product_id' value='" . $product->product_id . "'>";
        echo "<input type='submit' name='delete_variation' value='Delete Variation' />";
        echo "</form>";
        echo "<br>";
    }
    echo "<li style='font-weight: bold'>Add Variation: </li>";
    echo "<form action='management-edit-products.php' method='post'>";
    echo "<input type='hidden' name='product_id' value='" . $product->product_id . "'>";
    echo "<input type='text' name='variation_name' placeholder='Enter variation number' required>";
    echo "<input type='submit' name='add_variation' value='Add Variation' />";
    echo "</form>";

    function delete_variation()
    {
        if (!isset($_POST['variation_id'], $_POST['product_id'])) {
            // Handle error: required form fields are missing
            return;
        }

        Product::deleteVariation($_POST['variation_id']);
        Redirect::to('management-edit-products.php?product_id=' . $_POST['product_id']);
    }

    if (array_key_exists('delete_variation', $_POST)) {
        delete_variation();
    }

    function add_variation()
    {
        if (!isset($_POST['variation_name'], $_POST['product_id'])) {
            // Handle error: required form fields are missing
            return;
        }

        Product::addVariation($_POST['product_id'], $_POST['variation_name']);
        echo "<script type='text/javascript'>alert('Variation added successfully!');</script>";
        Redirect::to('management-edit-products.php?product_id=' . $_POST['product_id']);
    }

    if (array_key_exists('add_variation', $_POST)) {
        add_variation();
    }
    ?>
</div>