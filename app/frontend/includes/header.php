<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="app\frontend\assets\css\bootstrap.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_ASSET . 'css/profile.css'; ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

  <title>
    <?php
    $currentFile = basename($_SERVER['PHP_SELF']);
    $pageName = str_replace(".php", "", $currentFile);
    $pageName = str_replace(array('-', '_'), ' ', $pageName);
    $pageName = ucwords($pageName);

    // Check if the current page is the index page
    if ($pageName == 'Index') {
        $pageName = 'Home';
    }

    // Check if the current page is a product page
    if ($pageName == 'Product') {
        $product_id = $_GET['product_id'];
        $product = Product::getProductById($product_id);
        $pageName = $product->name;
    }

    echo $pageName;
    ?>
  </title>

  <link rel="icon" href="app\frontend\assets\img\Buckled_shoes-logos_white(1) 2.png">

  <link rel="stylesheet" href="<?php echo FRONTEND_ASSET . 'css/profile.css'; ?>">


</head>