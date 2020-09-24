<?php

if(isset($_POST['create-submit'])){
  require 'dbh_inc.php';

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $pass = $_POST['passw'];
  $confPass = $_POST['conpassw'];
  $userType = $_POST['option'];

  $bool = checkForSameEmail($conn,$email);
  if($bool == -1){
    header("Location: ../createUser.php?error=sql");
    exit();
  }else if($bool==1){
    header("Location: ../createUser.php?error=usedEmail");
    alert("The email you have used is already taken");
    exit();
  }else{
    if($userType == "admin"){ //create admin
      insertNewAdmin($conn,$fname,$lname,$email,$pass);
    }else{ // create employee
      insertNewEmployee($conn,$fname,$lname,$email,$pass);
    }
  }
}else{ // unauthorized access
  header("Location: ../createUser.php");
  exit();
}



Function checkForSameEmail($conn,$eml){
  $sql = "SELECT e_mail FROM admin WHERE e_mail=? UNION SELECT e_mail FROM employee WHERE e_mail=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
    return -1;
  }else{
    mysqli_stmt_bind_param($stmt,"ss",$eml,$eml);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $rows = mysqli_stmt_num_rows($stmt);
    if($rows>0){ // already used email!!!
      return 1;
    }else{
      return 0;
    }
  }
}
Function insertNewEmployee($conn,$fname,$lname,$email,$pass){
  $sql = "INSERT INTO employee(first_name,last_name,passwrd,e_mail) VALUES(?,?,?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
    header("Location: ../createUser.php?error=sql");
    exit();
  }else{
    $passEncrepted = password_hash($pass,PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"ssss",$fname,$lname,$passEncrepted,$email);
    mysqli_stmt_execute($stmt);
    header("Location: ../admin.php?UserCreated!");
    exit();
  }
}
Function insertNewAdmin($conn,$fname,$lname,$email,$pass){
  $sql = "INSERT INTO admin(first_name,last_name,passwrd,e_mail) VALUES(?,?,?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
    header("Location: ../createUser.php?error=sql");
    exit();
  }else{
    $passEncrepted = password_hash($pass,PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"ssss",$fname,$lname,$passEncrepted,$email);
    mysqli_stmt_execute($stmt);
    header("Location: ../admin.php?UserCreated!");
    exit();
  }
}
