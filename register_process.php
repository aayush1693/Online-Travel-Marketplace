<?php
$servername = "localhost";
$username = "newuser";
$password = "newpassword";
$dbname = "mydatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Generate a random code for two-step verification
$code = rand(100000, 999999);

$sql = "INSERT INTO users (email, password, two_factor_code, two_factor_expires_at)
VALUES ('$email', '$password', '$code', DATE_ADD(NOW(), INTERVAL 10 MINUTE))";

if ($conn->query($sql) === TRUE) {
  // Send the code to the user's email address
  $to = $email;
  $subject = "Your verification code";
  $message = "Your verification code is $code. This code will expire in 10 minutes.";
  $headers = "From: parajuli.aayush@outlook.com";

  mail($to, $subject, $message, $headers);

  echo "A verification code has been sent to your email address.";
  header("Location: verify.php");
  exit;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>