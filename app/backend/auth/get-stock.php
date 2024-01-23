<?php
if (isset($_GET['variation_id'])) {
    $variation_id = $_GET['variation_id'];
    $stock = Product::getStockByVariationId($variation_id);

    echo $stock;
} else {
    http_response_code(400);
    echo 'No variation_id provided';
}