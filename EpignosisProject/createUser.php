
<!DOCTYPE html>
<html class="subbf">
<head><title>User Creation Form</title></head>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
  <h1>Create a User</h1>
  <form class="sub" action="includes/create_user_inc.php" method="post">
    <p>First Name</p>
    <input type="text" name="fname" placeholder="Enter First Name">
    <p>Last Name</p>
    <input type="text" name="lname" placeholder="Enter Last Name">
    <p>Email</p>
    <input type="text" name="email" placeholder="Enter Email">
    <p>Password</p>
    <input type="password" name="passw" placeholder="Enter Password">
    <p>Confirm Password</p>
    <input type="password" name="conpassw" placeholder="Re-enter Password">
    <select name="option"><option value="employee">Employee</option>
      <option value="admin">Admin</option>
    </select>
    <br><br>
    <button type="submit" name="create-submit">Create User</button>
  </form>
</body>

</html>
