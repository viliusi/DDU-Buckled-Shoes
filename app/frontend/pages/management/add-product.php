<div class="container" style="margin-top:30px">
    <h2>Add Product</h2>

    <h4>Product info:</h4>

    <form action="management-add-products.php" method="post">
        <div class="form-group">
            <label for="name">Name :</label> <br>
            <input type="text" name="name" id="name" value="">
        </div>
        <div class="form-group">
            <label for="description">Description :</label> <br>
            <input type="text" name="description" id="description" value="">
        </div>
        <div class="form-group">
            <label for="price">Price :</label> <br>
            <input type="text" name="price" id="price" value="">
        </div>
        <div class="form-group">
            <label for="category">Category :</label> <br>
            <input type="text" name="category" id="category" value="">
        </div>
        <div class="form-group">
            <label for="images_reference">Images_Reference :</label> <br>
            <input type="text" name="images_reference" id="images_reference" value="">
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Add">
</div>