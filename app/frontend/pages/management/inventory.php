<?php
$products = Product::getAllProducts(); // Replace with your method to get all products
?>

<form action="management-update-inventory.php" method="post">
    <?php foreach ($products->results() as $product) { ?>
        <h2><?php echo $product->name; ?></h2>
        <p>Original Price: <?php $originalPrice = Product::getOriginalPrice($product->product_id);
                            echo $originalPrice; ?></p>
        <p>Discount: <input class="discount" type="number" name="discount[<?php echo $product->product_id; ?>]" value="<?php $discount = Product::getDiscount($product->product_id);
                                                                                                                        echo $discount; ?>"></p>
        <p>Current Price: <span class="price"><?php echo $originalPrice * (1 - $discount / 100); ?></span></p>
        <table>
            <tr>
                <th>Variation</th>
                <th>Add Stock</th>
            </tr>
            <?php $variations = Product::getProductVariationsById($product->product_id); ?>
            <?php foreach ($variations as $variation) { ?>
                <tr class="product-row">
                    <td>
                        <?php echo $variation->name; ?>
                    </td>
                    <td>
                        <input type="number" name="add_stock[<?php echo $variation->variation_id; ?>]" min="0" value="<?php echo $variation->stock; ?>">
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
    <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Update Inventory">
</form>

<script>
    var discounts = document.getElementsByClassName('discount');
    var prices = document.getElementsByClassName('price');
    for (var i = 0; i < discounts.length; i++) {
        discounts[i].addEventListener('input', function() {
            var originalPriceText = this.parentElement.previousElementSibling.textContent;
            var originalPrice = parseFloat(originalPriceText.replace('Original Price: ', ''));
            var discount = this.value;
            var price = originalPrice * ((100 - discount) / 100);
            this.parentElement.nextElementSibling.textContent = 'Current Price: ' + price.toFixed(2);
        });
    }
</script>