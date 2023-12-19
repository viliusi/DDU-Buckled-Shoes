<div class="container" style="margin-top:30px">
  <h2>Product Management</h2>
  <br>
  <button><a href="management-add-products.php">Add</a></button> 
  <br> <br>
  <?php 
  $products = Product::getAllProducts();
  if ($products->count()) {
    echo $products->count() . " products found.";
    echo "<table style='width:100%; border: 1px solid'>";
    echo "<tr>";
    echo "<th>Product ID</th>";
    echo "<th>Name</th>";
    echo "<th>Price</th>";
    echo "<th>Category</th>";
    echo "<th>Description</th>";
    echo "<th>Images_Reference</th>";
    echo "<th>Edit</th>";
    echo "</tr>";
    foreach ($products->results() as $product) {
      // build a table with the results, printing the variables "name", "price", "category" and "description"
      echo "<tr>";
      echo "<td>" . $product->product_id . "</td>";
      echo "<td>" . $product->name . "</td>";
      echo "<td>" . $product->price . "</td>";
      echo "<td>" . $product->category . "</td>";
      echo "<td>" . $product->description . "</td>";
      echo "<td>" . $product->images_reference . "</td>";
      echo "<td><a href='management-edit-products.php?product_id=" . $product->product_id . "'>Edit</a></td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "No products found.";
  }


  ?>

</div>