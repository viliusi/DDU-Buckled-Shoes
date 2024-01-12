<div class="container" style="margin-top:30px">

  <h2>Lorem ipsum</h2>

  <?php
  $products = Database::getInstance()->query("SELECT * FROM products WHERE Category = 'shoe'")->results();
  $productImages = array();

  if ($products) {
    foreach ($products as $product) {
      $product = get_object_vars($product);
      $images = Product::getImagesByProductId($product['product_id']);
      if (!empty($images->results())) {
        $randomImage = $images->results()[array_rand($images->results())];
        $productImages[] = $randomImage->image_location;
      }
    }
  }
  ?>
  <div id="slideshowContainer" class="slider">
    <div id="slideshow">
        <a id="slideshowLink" href="#">
            <img id="slideshowImage" src="<?php echo isset($productImages[0]) ? $productImages[0] : ''; ?>" alt="Slideshow Image">
        </a>
        <button id="prevButton">‹</button>
        <button id="nextButton">›</button>
    </div>
</div>

  <script>
    var images = <?php echo json_encode($productImages); ?>;
var productIds = <?php echo json_encode(array_column($products, 'product_id')); ?>;
var currentImageIndex = 0;
var slideshowInterval;

function changeImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    document.getElementById('slideshowImage').src = images[currentImageIndex];
}

document.getElementById('prevButton').addEventListener('click', function() {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    document.getElementById('slideshowImage').src = images[currentImageIndex];
});

document.getElementById('nextButton').addEventListener('click', function() {
    changeImage();
});

document.getElementById('slideshowLink').addEventListener('click', function(event) {
    event.preventDefault(); // Cancel the default action
    window.location.href = 'product.php?product_id=' + productIds[currentImageIndex]; // Navigate to the correct product page
});

    slideshowInterval = setInterval(changeImage, 2000);

    document.getElementById('slideshowContainer').addEventListener('mouseover', function() {
      clearInterval(slideshowInterval); // Pause the slideshow
    });

    document.getElementById('slideshowContainer').addEventListener('mouseout', function() {
      slideshowInterval = setInterval(changeImage, 2000); // Resume the slideshow
    });
  </script>
</div>