<!DOCTYPE html>
<html>
<body>

<h2>Verification Form</h2>

<form action="verify_process.php" method="post" onsubmit="return validateForm()">
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email" required><br>
  <label for="code">Verification Code:</label><br>
  <input type="text" id="code" name="code" required>
  <input type="submit" value="Submit">
</form> 

<script>
function validateForm() {
  var email = document.getElementById("email").value;
  var code = document.getElementById("code").value;
  if (email == "" || code == "") {
    alert("Email and verification code must be filled out");
    return false;
  }
}
</script>

</body>
</html>