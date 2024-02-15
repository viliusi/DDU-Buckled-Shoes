<div class="container" style="margin-top:30px">
    <h2>Are you sure you want to switch users admin state?</h2>
    <br>

    <?php
    if (isset($_GET['user_id']))
        $user = User::getUserById($_GET['user_id']);
    ?>

    <h4>Current info:</h4>
    <li style="font-weight: bold">ID:</li>
    <?php echo $user->user_id ?>
    <li style="font-weight: bold">Is admin?: </li>
    <?php echo $user->is_admin ?>
    <li style="font-weight: bold">Is verified?: </li>
    <?php echo User::isVerified($user->user_id) ?>
    <li style="font-weight: bold">Username: </li>
    <?php echo $user->username ?>
    <li style="font-weight: bold">Email: </li>
    <?php echo $user->email ?>

    <br><br>

    <form action="management-admin-user.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user->user_id ?>">
        <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Switch admin state">
</div>