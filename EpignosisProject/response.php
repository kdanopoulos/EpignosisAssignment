<html>
<link rel="stylesheet" type="text/css" href="style.css">
<?php
require 'includes/dbh_inc.php';
$app_code = $_GET['appCode'];
// We change the status of the application
$sql = "UPDATE application SET status=? WHERE application_code=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
  echo '<h2>Connection Failed!</h2>';
  exit();
}
$response = $_GET['response'];
mysqli_stmt_bind_param($stmt,"si",$response,$app_code);
mysqli_stmt_execute($stmt);
$id = $_GET['empId'];
// We find the email of the employee
$sql = "SELECT e_mail FROM employee WHERE user_id=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
  echo '<h2>Connection Failed!</h2>';
  exit();
}
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$stmt = mysqli_stmt_get_result($stmt);
if(!$row=mysqli_fetch_assoc($stmt)){
  echo '<h2>Connection Failed!</h2>';
  exit();
}
$mail = $row['e_mail'];
// We find the submission date of the application_code
$sql = "SELECT date_submitted FROM application WHERE application_code=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
  echo '<h2>Connection Failed!</h2>';
  exit();
}
mysqli_stmt_bind_param($stmt,"i",$app_code);
mysqli_stmt_execute($stmt);
$stmt = mysqli_stmt_get_result($stmt);
if(!$row=mysqli_fetch_assoc($stmt)){
  echo '<h2>Connection Failed!</h2>';
  exit();
}
$subDate = $row['date_submitted'];
$text = "Dear employee, your supervisor has ".$response." your application submitted on ".$subDate;
$subject = "Application's Response";
mail($mail,$subject,$text);
?>
</html>
