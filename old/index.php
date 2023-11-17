<!DOCTYPE html>
<html>

<head>
    <title>Membership and Rentals</title>
</head>

<body>
    <h1>Membership and Rentals</h1>

    <?php
    // Database configuration
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'movie_rental_system';

    // Create a connection
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    // Close the connection
    $conn->close();
    ?>

</body>

</html>