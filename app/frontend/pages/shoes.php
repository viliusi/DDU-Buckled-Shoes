<?php
if (isset($_GET['id'])) {
    // Display the product with the ID that is set in the URL
    $product = Database::getInstance()->query("SELECT * FROM products WHERE id = {$_GET['id']}")->results();
} else {
    // Display all products
    $product = Database::getInstance()->query("SELECT * FROM products")->results();
}
?>
<!DOCTYPE html>
<html>
<body>
    <div class="container" style="margin-top:30px">
        <h2>Product</h2>
        <ul style="list-style-type: none; display: flex; flex-wrap: wrap;">
            <li style="margin: 10px; padding: 10px; border: 1px solid #000;">
                <?php echo "{$product[0]['name']} - {$product[0]['price']} DKK"; ?>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?= $product[0]['id']; ?>">
                    <input type="submit" name="add_to_cart" value="Add to cart">
                </form>
            </li>
        </ul>
    </div>
</body>
</html>