<?php
$products = Database::getInstance()->query("SELECT * FROM products WHERE Category = 'shoe'")->results();
$productImages = array();
$productIds = array(); // New array for product IDs

if ($products) {
  foreach ($products as $product) {
    $product = get_object_vars($product);
    $productNames = $product['name']; // Change 'product_name' to 'name'
    $images = Product::getImagesByProductId($product['product_id']);
    if (!empty($images->results())) {
      $randomImage = $images->results()[array_rand($images->results())];
      $productImages[] = $randomImage->image_location;
      $productIds[] = $product['product_id']; // Store the product ID
    }
  }
}
?>

<script>
  productIds = <?php echo json_encode($productIds); ?>;
</script>

<div id="slideshowContainer" class="slider">
  <div id="slideshowAndButtons">
    <div id="slideshow">
      <a id="slideshowLink" href="#">
        <div style="display: flex; align-items: center; justify-content: flex-end; position: relative;">
          <img id="slideshowImage" src="<?php echo isset($productImages[0]) ? $productImages[0] : ''; ?>" alt="Slideshow Image">
          <div id="productName"></div>
          <div class="shoe-name" style="color: #fff; text-align: right; position: absolute; top: 50%; transform: translateY(-50%); margin-right: 10px;"><?php echo isset($products[0]->product_name) ? addslashes($products[0]->product_name) : ''; ?></div>
        </div>
      </a>
      <div class="menu-bar" style="display: flex; justify-content: space-between; margin-top: 10px;">
        <?php
        foreach ($products as $index => $product) {
          echo '<div class="shoe-bar" data-index="' . $index . '" style="flex: 1; height: 5px; background-color: transparent; border: 2px solid transparent; border-radius: 10px; margin: 0 5px; transition: background-color 0.3s;"></div>';
        }
        ?>
      </div>
      <button id="prevButton" style="position: absolute; top: 50%; transform: translateY(-50%); font-size: 20px; color: #fff; cursor: pointer; left: 10px; z-index: 1000;">‹</button>
      <button id="nextButton" style="position: absolute; top: 50%; transform: translateY(-50%); font-size: 20px; color: #fff; cursor: pointer; right: 10px; z-index: 1000;">›</button>
    </div>
    <div id="imageButtons">
      <?php foreach ($productImages as $index => $image) : ?>
        <button class="imageButton" data-index="<?php echo $index; ?>"></button>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
  let currentImageIndex = 0;
  productIds = <?php echo json_encode($productIds); ?>;
  let productNames = <?php echo json_encode($productNames); ?>;
  const images = <?php echo json_encode($productImages); ?>;
  const buttons = document.querySelectorAll('.imageButton');

  let slideshowInterval; // Define slideshowInterval

  function startSlideshow() {
    slideshowInterval = setInterval(changeImage, 3000); // Start the slideshow
  }

  function stopSlideshow() {
    clearInterval(slideshowInterval); // Stop the slideshow
  }

  function updateActiveButton() {
    buttons.forEach((button, index) => {
      if (index === currentImageIndex) {
        button.classList.add('active');
      } else {
        button.classList.remove('active');
      }
    });
  }

  function changeImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    document.getElementById('slideshowImage').src = images[currentImageIndex];
    document.getElementById('productName').textContent = productNames[currentImageIndex]; // Add this line
    updateActiveButton();
  }

  buttons.forEach((button, index) => {
    button.addEventListener('click', () => {
      currentImageIndex = index;
      document.getElementById('slideshowImage').src = images[currentImageIndex];
      updateActiveButton();
    });
  });

  document.getElementById('prevButton').addEventListener('click', function() {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    document.getElementById('slideshowImage').src = images[currentImageIndex];
    document.getElementById('productName').textContent = productNames[currentImageIndex]; // Add this line
    updateActiveButton();
  });

  document.getElementById('nextButton').addEventListener('click', changeImage);

  setInterval(changeImage, 2000);

  document.getElementById('slideshowContainer').addEventListener('mouseover', function() {
    clearInterval(slideshowInterval); // Pause the slideshow
  });

  document.getElementById('slideshowContainer').addEventListener('mouseout', function() {
    slideshowInterval = setInterval(changeImage, 2000); // Resume the slideshow
  });

  document.getElementById('slideshowLink').addEventListener('click', function(event) {
    event.preventDefault();
    const currentProductId = productIds[currentImageIndex];
    window.location.href = 'product.php?product_id=' + currentProductId;
  });

  window.onload = updateActiveButton;
</script>

</html>