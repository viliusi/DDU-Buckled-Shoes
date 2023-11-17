<?php
session_start();
//session_destroy();

$products = [
    ['id' => 1, 'name' => 'Vare A', 'price' => 10.99],
    ['id' => 2, 'name' => 'Vare B', 'price' => 15.49],
    ['id' => 3, 'name' => 'Vare C', 'price' => 5.79]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']) && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product = getProductById($product_id, $products);

    if ($product !== null) {
        addToCart($product_id, $product);
    } else {
        echo "Produktet med ID $product_id findes ikke.";
    }
}

function getProductById($id, $productArray)
{
    foreach ($productArray as $product) {
        if ($product['id'] == $id) { // Use loose comparison here
            return $product;
        }
    }
    return null;
}

function addToCart($product_id, $product)
{
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = [
            'product' => $product,
            'quantity' => 0
        ];
    }
    $_SESSION['cart'][$product_id]['quantity']++;
}

function displayCart()
{
    echo "<h2>Indkøbskurv</h2>";

    if (!empty($_SESSION['cart'])) {
        echo "<ul>";
        $total = 0;

        foreach ($_SESSION['cart'] as $cart_item) {
            $product = $cart_item['product'];
            $quantity = $cart_item['quantity'];
            $subtotal = $product['price'] * $quantity;
        
            echo "<li>{$product['name']} - {$product['price']} DKK x {$quantity} = {$subtotal} DKK</li>";
            $total += $subtotal;
        }
        

        echo "</ul>";
        echo "<p><strong>Total: {$total} DKK</strong></p>";
    } else {
        echo "<p>Indkøbskurven er tom.</p>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Webshop med Sessions</title>
</head>

<body>
    <h1>Velkommen til en webshop</h1>

    <?php displayCart(); ?>

    <h2>Produkter</h2>
    <ul>
        <?php foreach ($products as $product) : ?>
            <li>
            <?php echo "{$product['name']} - {$product['price']} DKK"; ?>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <input type="submit" name="add_to_cart" value="Tilføj til kurv">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>