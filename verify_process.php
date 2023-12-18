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
$code = $_POST['code'];

$sql = "SELECT * FROM users WHERE email='$email' AND two_factor_code='$code' AND two_factor_expires_at > NOW()";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "Verification successful";
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["email"] = $email;
    header("Location: index.php");
    exit;
  }
} else {
  echo "Invalid verification code or code has expired";
}
$conn->close();
?>