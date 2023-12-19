<div class="container" style="margin-top:30px">
<h2>Order Management</h2>
  
  <?php 
  $orders = Order::getAllOrders();
  if ($orders->count()) {
    echo $orders->count() . " products found.";
    echo "<table style='width:100%; border: 1px solid'>";
    echo "<tr>";
    echo "<th>Order_id</th>";
    echo "<th>Products</th>";
    echo "<th>Price</th>";
    echo "<th>Details</th>";
    echo "</tr>";
    foreach ($orders->results() as $order) {
      // build a table with the results, printing the variables "name", "price", "category" and "description"
      echo "<tr>";
      echo "<td>" . $order->order_id . "</td>";
      echo "<td>" . $order->products . "</td>";
      echo "<td>" . $order->price . "</td>";
      echo "<td><a href='management-order-details.php?order_id=" . $order->order_id . "'>Details</a></td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "No products found.";
  }

  ?>
</div>