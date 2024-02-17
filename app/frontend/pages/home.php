<?php
$products = Database::getInstance()->query("SELECT * FROM products WHERE Category = 'shoe'")->results();
$productImages = array();
$productIds = array(); // New array for product IDs
$productNames = array(); // New array for product names

if ($products) {
  foreach ($products as $product) {
    $product = get_object_vars($product);
    $productNames[] = html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8');  // Store the product name and decode HTML entities so emojis work
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
    <div id="slideshowWrapper">
      <div id="slideshow">
        <a id="slideshowLink" href="#">
          <div style="display: flex; align-items: center; justify-content: flex-end; position: relative;">
            <img id="slideshowImage" src="<?php echo isset($productImages[0]) ? $productImages[0] : ''; ?>" alt="Slideshow Image">
          </div>
        </a>
        <div class="menu-bar" style="display: flex; justify-content: space-between; margin-top: 10px;">
          <?php
          foreach ($products as $index => $product) {
            echo '<div class="shoe-bar" data-index="' . $index . '" style="flex: 1; height: 5px; background-color: transparent; border: 2px solid transparent; border-radius: 10px; margin: 0 5px; transition: background-color 0.3s;"></div>';
          }
          ?>
        </div>
      </div>
      <div id="productName" class="product-name"></div>
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
let productNames = <?php echo json_encode($productNames, JSON_UNESCAPED_UNICODE); ?>;
const images = <?php echo json_encode($productImages); ?>;
const buttons = document.querySelectorAll('.imageButton');

let slideshowInterval; // Define slideshowInterval

function startSlideshow() {
  if (!slideshowInterval) {
    slideshowInterval = setInterval(changeImage, 3000); // Start the slideshow
  }
}

function stopSlideshow() {
  if (slideshowInterval) {
    clearInterval(slideshowInterval); // Stop the slideshow
    slideshowInterval = null;
  }
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
  document.getElementById('productName').textContent = productNames[currentImageIndex];
  updateActiveButton();
}

buttons.forEach((button, index) => {
  button.addEventListener('click', () => {
    currentImageIndex = index;
    document.getElementById('slideshowImage').src = images[currentImageIndex];
    document.getElementById('productName').textContent = productNames[currentImageIndex];
    updateActiveButton();
  });
});

document.getElementById('prevButton').addEventListener('click', function() {
  currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
  document.getElementById('slideshowImage').src = images[currentImageIndex];
  document.getElementById('productName').textContent = productNames[currentImageIndex];
  updateActiveButton();
});

document.getElementById('nextButton').addEventListener('click', changeImage);

document.getElementById('slideshowContainer').addEventListener('mouseover', stopSlideshow);

document.getElementById('slideshowContainer').addEventListener('mouseout', startSlideshow);

document.getElementById('slideshowLink').addEventListener('click', function(event) {
  event.preventDefault();
  const currentProductId = productIds[currentImageIndex];
  window.location.href = 'product.php?product_id=' + currentProductId;
});

window.onload = function() {
  updateActiveButton();
  startSlideshow(); // Start the slideshow when the page loads
  document.getElementById('productName').textContent = productNames[currentImageIndex];
};
</script>

</html>