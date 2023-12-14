<div class="container" style="margin-top:30px">
  <h2>Users</h2>

  <?php
  $users = User::getAllUsers();
  if ($users->count()) {
    echo $users->count() . " users found.";
    echo "<table style='width:100%; border: 1px solid'>";
    echo "<tr>";
    echo "<th>User ID</th>";
    echo "<th>Is admin?</th>";
    echo "<th>Username</th>";
    echo "<th>Joined</th>";
    echo "<th>Last updated</th>";
    echo "<th>Switch admin state</th>";
    echo "</tr>";
    foreach ($users->results() as $user) {
      // build a table with the results, printing the variables "name", "price", "category" and "description"
      echo "<tr>";
      echo "<td>" . $user->user_id . "</td>";
      echo "<td>" . $user->is_admin . "</td>";
      echo "<td>" . $user->username . "</td>";
      echo "<td>" . $user->joined . "</td>";
      echo "<td>" . $user->last_updated . "</td>";
      echo "<td>" . "<form method=\"post\">
      <input type=\"hidden\" name=\"user_id\" value=\"<?php echo $user->user_id ?>\">
      <input type=\"submit\" name=\"switch state\" id=\"test\" value=\"switch state\" />
      <br /></form>"
        . "</td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "No users found.";
  }

  function switchState($user_id)
  {
    User::switchAdminState($user_id);
    Redirect::to('management-users.php');
  }
  if (array_key_exists('switch state', $_POST)) {
    switchState($_POST['user_id']);
  }

  ?>
</div>