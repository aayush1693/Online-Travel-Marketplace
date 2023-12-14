<?php
$servername = "localhost";
$username = "travel_user";
$password = "password";
$dbname = "tra@ext:GitHub.copilot-chatvel_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>