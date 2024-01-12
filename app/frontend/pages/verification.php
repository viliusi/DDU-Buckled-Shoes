<div class="container" style="padding-top: 5%; padding-bottom: 5%;">
    <h2>Verify registration</h2>

    <?php $user_id = $_GET['user_id'];
    $verification_code = $_GET['verification_code'];
    $userForVerification = User::getUserById($user_id); ?>

    <p>This is the registration page, if the details below match what you expected and you want an account on the site, then please press the "Verify account now" button.</p>

    <p>Username: <?php echo $userForVerification->username ?></p>
    <p>Email: <?php echo $userForVerification->email ?></p>

    <form action="verification.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
        <input type="hidden" name="verification_code" value="<?php echo $verification_code ?>">
        <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Verify account now">
    </form>

    <p>If the details above are not what you expected, then please press the "Cancel registration" button.</p>
    
</div>