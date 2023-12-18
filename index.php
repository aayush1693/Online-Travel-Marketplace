<?php
// Start the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Get the user's email from the session
$email = $_SESSION["email"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome to our website!</h1>
    <p>Your email: <?php echo $email; ?></p>
</body>
</html>