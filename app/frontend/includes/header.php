<!DOCTYPE html>
<html lang="en">

<head>
  <title><?php appName(); ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>


  <!-- Custom Assets 

  <link rel="stylesheet" href="<?php //echo FRONTEND_ASSET . 'css/profile.css'; ?>">
-->
  <style>
    .fakeimg {
      height: 200px;
      background: #aaa;
    }
  </style>
</head>

<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>My First <?php appName(); ?></h1>
  <p>Resize this responsive page to see the effect!</p>
  <?php if ($user->isLoggedIn()) : ?>
    <h3 align="right">Hello, <?php echo $user->data()->name; ?></h3>
  <?php endif; ?>
</div>
