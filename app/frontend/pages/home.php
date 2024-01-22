<div class="container" style="margin-top:30px; text-align: center;">

  <h2>Welcome</h2>

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
        <div style="display: flex; align-items: center; justify-content: flex-end; position: relative;">
          <img id="slideshowImage" src="<?php echo isset($productImages[0]) ? $productImages[0] : ''; ?>" alt="Slideshow Image" style="width: 100%; border-left: 5px solid yellow; border-bottom: 5px solid yellow;">
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
      <div id="imageButtons">
        <?php foreach ($productImages as $index => $image) : ?>
          <button class="imageButton" data-index="<?php echo $index; ?>"><?php echo $index + 1; ?></button>
        <?php endforeach; ?>
      </div>
      <button id="prevButton" style="position: absolute; top: 50%; transform: translateY(-50%); font-size: 20px; background: none; border: none; color: #fff; cursor: pointer; left: 10px;">‹</button>
      <button id="nextButton" style="position: absolute; top: 50%; transform: translateY(-50%); font-size: 20px; background: none; border: none; color: #fff; cursor: pointer; right: 10px;">›</button>
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
      updateShoeInfo(currentImageIndex);
    }

    function updateShoeInfo(index) {
      document.querySelector('.shoe-name').textContent = '<?php echo isset($products[$index]->product_name) ? addslashes($products[$index]->product_name) : ''; ?>';
      const shoeBars = document.querySelectorAll('.shoe-bar');
      shoeBars.forEach((bar, i) => {
        bar.style.backgroundColor = i === index ? 'yellow' : 'transparent';
      });
    }

    document.getElementById('prevButton').addEventListener('click', function() {
      currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
      document.getElementById('slideshowImage').src = images[currentImageIndex];
      updateShoeInfo(currentImageIndex);
    });

    document.getElementById('nextButton').addEventListener('click', function() {
      changeImage();
    });

    document.getElementById('slideshowLink').addEventListener('click', function(event) {
      event.preventDefault();
      const currentProductId = productIds[currentImageIndex];
      window.location.href = 'product.php?product_id=' + currentProductId;
    });

    slideshowInterval = setInterval(changeImage, 2000);

    document.getElementById('slideshowContainer').addEventListener('mouseover', function() {
      clearInterval(slideshowInterval); // Pause the slideshow
    });

    document.getElementById('slideshowContainer').addEventListener('mouseout', function() {
      slideshowInterval = setInterval(changeImage, 2000); // Resume the slideshow
    });

    document.querySelectorAll('.imageButton').forEach(button => {
      button.addEventListener('click', function() {
        currentImageIndex = parseInt(this.dataset.index);
        document.getElementById('slideshowImage').src = images[currentImageIndex];
        updateShoeInfo(currentImageIndex);
      });
    });
  </script>

</div>
<div>
  <h2>Accessories</h2>
  </div>