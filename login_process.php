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
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        // Generate a new two-factor code and send it to the user
        $code = rand(100000, 999999);
        $sql = "UPDATE users SET two_factor_code='$code', two_factor_expires_at=DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
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
    } else {
        echo "Invalid password";
    }
  }
} else {
  echo "No user found with this email";
}
$conn->close();
?>