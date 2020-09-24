<?php
session_start();
echo '<h2>Hello Admin  '.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>';
?>

<!DOCTYPE html>
<html class="subbf">
<link rel="stylesheet" type="text/css" href="style.css">
<body>
  <h1>List of Users</h1>
  <form class="normal" action="includes/go_to_create_inc.php" method="post">
    <button type="submit" name="go-to-create-user">Create User</button>
  </form>

<?php
require 'includes/dbh_inc.php';
$sql = "SELECT * FROM admin WHERE user_id!=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
     header("Location: ../index.php?DatabaseFatalErrorConnection");
     exit();
   }
// get results from database
mysqli_stmt_bind_param($stmt,"i",$_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$stmt = mysqli_stmt_get_result($stmt);
while($row = mysqli_fetch_assoc($stmt)){
  echo '<form action="updateUser.php" method="post">
        <button type="submit" value="a'.$row['user_id'].'" name="link"><div class="column" style="background-color:#bbb;">
        <h2>User type : Admin </h2>
        <h3>First Name: '.$row['first_name'].' | Last Name: '.$row['last_name'].' | Email: '.$row['e_mail'].'</h3>
        </div></button>
        </form>
        <br>';
}
$sql = "SELECT * FROM employee";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
     header("Location: ../index.php?DatabaseFatalErrorConnection");
     exit();
   }
// get results from database
mysqli_stmt_execute($stmt);
$stmt = mysqli_stmt_get_result($stmt);
while($row = mysqli_fetch_assoc($stmt)){
  echo '<form action="updateUser.php" method="post">
        <button type="submit" value="e'.$row['user_id'].'" name="link"><div class="column" style="background-color:#bbb;">
        <h2>User type : Employee </h2>
        <h3>First Name: '.$row['first_name'].' | Last Name: '.$row['last_name'].' | Email: '.$row['e_mail'].'</h3>
        </div></button>
        </form>
        <br>';
}
?>

</body>
</html>
