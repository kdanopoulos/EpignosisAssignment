<?php

if(isset($_POST['login-submit'])){
  require 'dbh_inc.php';

  $username = $_POST['usernm'];
  $password = $_POST['passwrd'];
  checkForUsername($conn,$username,$password);
}


Function checkForUsername($conn,$user,$pass){
  $sql = "SELECT user_id,first_name,last_name,passwrd FROM employee WHERE e_mail=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
    header("Location: ../index.php?DatabaseFatalErrorConnection");
    exit();
  }
  mysqli_stmt_bind_param($stmt,"s",$user);
  mysqli_stmt_execute($stmt);
  $stmt = mysqli_stmt_get_result($stmt);
  if($row = mysqli_fetch_assoc($stmt)){ // username found
    if(password_verify($pass,$row['passwrd'])){
      session_start();
      $_SESSION['fname'] = $row['first_name'];
      $_SESSION['lname'] = $row['last_name'];
      $_SESSION['user_id'] = $row['user_id'];
      header("Location: ../employee.php");
      exit();
    }
    header("Location: ../index.php?error=WrongInformation");
    exit();
  }else{ // username not found
    checkForAdminUser($conn,$user,$pass);
  }
}



Function checkForAdminUser($conn,$user,$pass){
  $sql = "SELECT user_id,first_name,last_name,passwrd FROM admin WHERE e_mail=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
    header("Location: ../index.php?DatabaseFatalErrorConnection");
    exit();
  }
  mysqli_stmt_bind_param($stmt,"s",$user);
  mysqli_stmt_execute($stmt);
  $stmt = mysqli_stmt_get_result($stmt);
  if($row = mysqli_fetch_assoc($stmt)){ // username found
    if(password_verify($pass,$row['passwrd'])){
      session_start();
      $_SESSION['fname'] = $row['first_name'];
      $_SESSION['lname'] = $row['last_name'];
      $_SESSION['user_id'] = $row['user_id'];
      header("Location: ../admin.php");
      exit();
    }
    header("Location: ../index.php?error=WrongInformation");
    exit();
  }else{
    header("Location: ../index.php?error=WrongInformation");
    exit();
  }
}
