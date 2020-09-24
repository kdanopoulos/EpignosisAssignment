<?php
session_start();
echo '<h2>Hello '.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>';
?>

<!DOCTYPE html>
<html class="index">
<link rel="stylesheet" type="text/css" href="style.css">
<body>
  <h1>Previous Applications</h1>
  <form class='normal' action="includes/submit_request_inc.php" method="post">
    <button type="submit" name="submit-request">Submit Request</button>
  </form>

<?php
require 'includes/dbh_inc.php';
$sql = "SELECT * FROM application WHERE application_code IN (SELECT application_code FROM submits WHERE user_id=? ORDER BY date_submitted DESC)";
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
  $dateStart = strtotime($row['vacation_start']);
  $dateEnd = strtotime($row['vacation_end']);
  $days = ($dateEnd-$dateStart)/(60*60*24);
  echo '<div class="column" style="background-color:#eee;">
        <h2>Application At Date : '.$row['date_submitted'].'</h2>
        <h3>vacation start: '.$row['vacation_start'].'|     vacation end: '.$row['vacation_end'].'|     total days: '.$days.'|
            status: '.$row['status'].'</h3>
        </div>';
}
?>

</body>
</html>
