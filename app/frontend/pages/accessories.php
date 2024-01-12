<?php
$products = Database::getInstance()->query("SELECT * FROM products WHERE Category = 'accessory'")->results();
if ($products) {
    foreach ($products as $key => $product) {
        $products[$key] = get_object_vars($product);
    }
}
?>
<!DOCTYPE html>
<html>

<body>
    <div class="container" style="margin-top:30px">
        <h2>Accessories</h2>
        <ul style="list-style-type: none; display: flex; flex-wrap: wrap;">
            <?php foreach ($products as $product) : ?>
                <li style="margin: 10px; padding: 10px;">
                    <a href="product.php?product_id=<?= $product['product_id']; ?>" style="text-decoration: none; color: inherit;">
                        <div class="outerBorderW" style="position: relative;">
                            <?php echo "{$product['name']} - $" . "{$product['price']}"; ?>
                            <form method="post">
                                <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                            </form>
                            <?php
                            $images = Product::getImagesByProductId($product['product_id']);
                            if (!empty($images->results())) {
                                $image = $images->results()[0];
                            ?>
                                <img class="product-image" src='<?= $image->image_location ?>' width='200px' height='200px'>
                                <div class="pricetag">
                                    <?= "$" . "{$product['price']}" ?>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="pricetag">
                                <?php echo "$" . "{$product['price']}"; ?>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>