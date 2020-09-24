<?php
session_start();
?>
<!DOCTYPE html>
<html class="index">
<head><title>Login Form</title></head>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
<form class="loginbox" action="includes/login_inc.php" method="post">
  <h1>Sign in here</h1>
  <p>Username</p>
  <input type="text" name="usernm" placeholder="Enter your e-mail">
  <p>Password</p>
  <input type="password" name="passwrd" placeholder="Enter your password">
  <button type="submit" name="login-submit">Login</button>
</form>
</body>

</html>
