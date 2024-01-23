<?php
$products = Product::getAllProducts(); // Replace with your method to get all products
?>

<table>
    <tr>
        <th>Product</th>
        <th>Variation</th>
        <th>Original Price</th>
        <th>Discount (%)</th>
        <th>Current Price</th>
        <th>New Price</th>
        <th>Stock</th>
        <th>Add Stock</th>
    </tr>
    <?php foreach ($products->results() as $product) { ?>
        <?php $variations = Product::getProductVariationsById($product->product_id); ?>

        <?php usort($variations, function ($a, $b) {
            return $a->name <=> $b->name;
        }); ?>

        <?php foreach ($variations as $variation) { ?>
            <tr>
                <td>
                    <?php echo $product->name; ?>
                </td>
                <td>
                    <?php echo $variation->name; ?>
                </td>
                <?php $originalPrice = Product::getOriginalPrice($product->product_id); ?>
                <td>
                    <?php echo $originalPrice; ?>
                </td>
                <?php $discount = Product::getDiscount($product->product_id); ?>

                <td><input class="discount" type="number" name="discount" value="<?php echo $discount; ?>"></td>
                <td>
                    <?php echo $originalPrice * (1 - $discount / 100); ?>
                </td>
                <td class="price"></td>

                <script>
                    document.getElementsByClassName('discount')[<?php echo $index; ?>].addEventListener('input', function () {
                        var originalPrice = <?php echo $originalPrice; ?>;
                        var discount = this.value;
                        var price = originalPrice * ((100 - discount) / 100);
                        print(price);
                        document.getElementsByClassName('price')[<?php echo $index; ?>].textContent = price;
                    });
                </script>

                <td>
                    <?php echo $variation->stock; ?>
                </td>
                <td>
                    <form method="post" action="add_stock.php">
                        <input type="hidden" name="variation_id" value="<?php echo $variation->id; ?>">
                        <input type="number" name="add_stock" min="0">
                        <input type="submit" value="Add">
                    </form>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
</table>


</script>