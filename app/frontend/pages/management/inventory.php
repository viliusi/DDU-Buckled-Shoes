<?php
$products = Product::getAllProducts(); // Replace with your method to get all products
?>

<table>
    <tr>
        <th>Product</th>
        <th>Variation</th>
        <th>Original Price</th>
        <th>Discount (%)</th>
        <th>New Price</th>
        <th>Stock</th>
        <th>Add Stock</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <?php $variations = Product::getVariationsByProductId($product->product_id); ?>
        <?php foreach ($variations as $variation): ?>
            <tr>
                <td><?php echo $product->name; ?></td>
                <td><?php echo $variation->name; ?></td>
                <td><?php echo $variation->originalPrice; ?></td>
                <td><?php echo $variation->discount; ?></td>
                <td><?php echo $variation->originalPrice * (1 - $variation->discount / 100); ?></td>
                <td><?php echo $variation->stock; ?></td>
                <td>
                    <form method="post" action="add_stock.php">
                        <input type="hidden" name="variation_id" value="<?php echo $variation->id; ?>">
                        <input type="number" name="add_stock" min="0">
                        <input type="submit" value="Add">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>