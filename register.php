<!DOCTYPE html>
<html>
<body>

<h2>Registration Form</h2>

<form action="register_process.php" method="post" onsubmit="return validateForm()">
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email" required><br>
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" required>
  <input type="submit" value="Submit">
</form> 

<script>
function validateForm() {
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  if (email == "" || password == "") {
    alert("Email and password must be filled out");
    return false;
  }
}
</script>

</body>
</html>