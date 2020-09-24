<?php
if(isset($_POST['submit-application'])){
  session_start();
  require 'dbh_inc.php';
  $dateS = $_POST['dateS'];
  $dateE = $_POST['dateE'];
  $text = $_POST['txt'];
  $curDate = date("Y-m-d");
  //$curDate = $_POST['today'];


  // We create a new application
  $sql = "INSERT INTO application(date_submitted,vacation_start,vacation_end,status) VALUES(?,?,?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
    header("Location: ../submissionForm.php?error=sql");
    exit();
  }
  $pending = "pending";
  mysqli_stmt_bind_param($stmt,"ssss",$curDate,$dateS,$dateE,$pending);
  mysqli_stmt_execute($stmt);
  $curId = $_SESSION['user_id'];


  // We find the app code from the app we just created
  $sql = "SELECT application_code FROM application WHERE date_submitted=? AND vacation_start=? AND vacation_end=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
      header("Location: ../submissionForm.php?error=sql_at_get_app_code");
      exit();
  }
  mysqli_stmt_bind_param($stmt,"sss",$curDate,$dateS,$dateE);
  mysqli_stmt_execute($stmt);
  $stmt = mysqli_stmt_get_result($stmt);
  if(!$row = mysqli_fetch_assoc($stmt)){
    header("Location: ../submissionForm.php?error=sql");
    exit();
  }
  $appCode = $row['application_code'];


  // We create a new submit with app code and id of employee
  $sql = "INSERT INTO submits(user_id,application_code) VALUES(?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
        header("Location: ../submissionForm.php?error=sql_couldnt_insert_submits");
        exit();
  }
  mysqli_stmt_bind_param($stmt,"ii",$curId,$appCode);
  mysqli_stmt_execute($stmt);


  // we find the supervisor from the database
  $sql = "SELECT e_mail FROM admin WHERE user_id IN (SELECT id_of_admin FROM supervise WHERE id_of_employee=?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
        header("Location: ../submissionForm.php?error=sql");
        exit();
  }
  mysqli_stmt_bind_param($stmt,"i",$curId);
  mysqli_stmt_execute($stmt);
  $stmt = mysqli_stmt_get_result($stmt);
  if(!$row=mysqli_fetch_assoc($stmt)){
        header("Location: ../submissionForm.php?error=sql");
        exit();
  }
  $mailto = $row['e_mail'];
  $fName = $_SESSION['fname'];
  $lName = $_SESSION['lname'];
  $subject = "Vacation Application by ".$fName." ".$lName;
  $mlText = "Dear supervisor, employee ".$fName." ".$lName." requested for some time off, starting on
  ".$dateS." and ending on ".$dateE.", stating the reason:\n".$text."\n
  Click on one of the below links to approve or reject the application:\n
  <a href='localhost/EpignosisProject/response.php?appCode=".$appCode."&empId=".$curId."&response=approved'>approve link</a> -
  <a href='localhost/EpignosisProject/response.php?appCode=".$appCode."&empId=".$curId."&response=rejected'>reject link</a>";
  mail($mailto,$subject,$mlText);
  header("Location: ../employee.php?application_submitted");
  exit();

  header("Location: ../submissionForm.php?error=sql");
  exit();





}else{
  header("Location: ../submissionForm.php");
  exit();
}
