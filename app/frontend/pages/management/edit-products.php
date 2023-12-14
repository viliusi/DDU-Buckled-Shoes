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
    <li style="font-weight: bold">Price: </li>
    <?php echo $product->price ?>
    <li style="font-weight: bold">Category: </li>
    <?php echo $product->category ?>

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
            <label for="price">Price :</label> <br>
            <input type="text" name="price" id="price" value="<?php echo $product->price ?>">
        </div>
        <div class="form-group">
            <label for="category">Category :</label> <br>
            <input type="text" name="category" id="category" value="<?php echo $product->category ?>">
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Update">
</div>