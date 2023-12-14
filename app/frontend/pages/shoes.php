<?php
$products = Database::getInstance()->query("SELECT * FROM products WHERE Category = 'shoe'")->results();
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
        <h2>Shoes</h2>
        <ul style="list-style-type: none; display: flex; flex-wrap: wrap;">
            <?php foreach ($products as $product): ?>
            <li style="margin: 10px; padding: 10px; border: 1px solid #000;">
                <a href="product.php?product_id=<?= $product['product_id']; ?>">
                    <?php echo "{$product['name']} - $" . "{$product['price']}"; ?>
                </a>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                </form>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>