<?php
session_start();
require 'dbh_inc.php';
if(isset($_POST['update-user'])){
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $pass = $_POST['passw'];
  $confPass = $_POST['conpassw'];
  $userType = $_POST['option'];

  //UPDATE `admin` SET `last_name` = 'fdfdf' WHERE `admin`.`user_id` = 1
  if($userType!=$_SESSION['change_user_type']){ //we want to change the type of user
          if($userType=="admin"){
            deleteSuperviseOfAdmin($conn,$_SESSION['change_user_id']);
            //delete admin and transf to employee (check if pass is empty)
            deleteAdminAndTransf($conn,$fname,$lname,$email,$_SESSION['change_user_id'],$pass);
          }else{
            deleteAllApplicationsAndSubmitsAndSupervise($conn,$_SESSION['change_user_id']);
            //delete employee and transf to admin (check if pass is empty)
            deleteEmployeeAndTransf($conn,$fname,$lname,$email,$_SESSION['change_user_id'],$pass);
          }
  }else{ // the user type is the same
          if($userType=="admin"){
            updateAdmin($conn,$fname,$lname,$email,$pass,$userType,$_SESSION['change_user_id']);
          }else{
            updateEmployee($conn,$fname,$lname,$email,$pass,$userType,$_SESSION['change_user_id']);
          }
  }
}
header("Location: ../updateUser.php");
exit();


// -------------------------- Functions -------------------------- \\


Function deleteAdminAndTransf($conn,$fname,$lname,$email,$id,$pass){
  if(empty($pass)){  // password is the same
            // First we get the old password from the database before we delete admin
            $sql = "SELECT passwrd FROM admin WHERE user_id=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
              header("Location: ../updateUser.php?error=sql");
              exit();
            }
            mysqli_stmt_bind_param($stmt,"i",$id);
            mysqli_stmt_execute($stmt);
            $stmt = mysqli_stmt_get_result($stmt);
            if(!$row = mysqli_fetch_assoc($stmt)){
              header("Location: ../updateUser.php?error=sql");
              exit();
            }
            $psw = $row['passwrd'];
            // then we delete the admin and insert to employee
            $sql = "DELETE FROM admin WHERE user_id=?;INSERT INTO employee(first_name,last_name,e_mail,passwrd)
            VALUES(?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
              header("Location: ../updateUser.php?error=sql");
              exit();
            }
            mysqli_stmt_bind_param($stmt,"issss",$id,$fname,$lname,$email,$psw);
            mysqli_stmt_execute($stmt);
  }else{  // we have new password
            // then we delete the admin and insert to employee
            $sql = "DELETE FROM admin WHERE user_id=?;INSERT INTO employee(first_name,last_name,e_mail,passwrd)
            VALUES(?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
              header("Location: ../updateUser.php?error=sql");
              exit();
            }
            $psw = password_hash($pass,PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt,"issss",$id,$fname,$lname,$email,$psw);
            mysqli_stmt_execute($stmt);
  }
}

Function deleteEmployeeAndTransf($conn,$fname,$lname,$email,$id,$pass){
  if(empty($pass)){  // password is the same
            // First we get the old password from the database before we delete admin
            $sql = "SELECT passwrd FROM employee WHERE user_id=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
              header("Location: ../updateUser.php?error=sql");
              exit();
            }
            mysqli_stmt_bind_param($stmt,"i",$id);
            mysqli_stmt_execute($stmt);
            $stmt = mysqli_stmt_get_result($stmt);
            if(!$row = mysqli_fetch_assoc($stmt)){
              header("Location: ../updateUser.php?error=sql");
              exit();
            }
            $psw = $row['passwrd'];
            // then we delete the employee and insert to admin
            $sql = "DELETE FROM employee WHERE user_id=?;INSERT INTO admin(first_name,last_name,e_mail,passwrd)
            VALUES(?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
              header("Location: ../updateUser.php?error=sql");
              exit();
            }
            mysqli_stmt_bind_param($stmt,"issss",$id,$fname,$lname,$email,$psw);
            mysqli_stmt_execute($stmt);
  }else{  // we have new password
            // then we delete the employee and insert to admin
            $sql = "DELETE FROM employee WHERE user_id=?;INSERT INTO admin(first_name,last_name,e_mail,passwrd)
            VALUES(?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
              header("Location: ../updateUser.php?error=sql");
              exit();
            }
            $psw = password_hash($pass,PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt,"issss",$id,$fname,$lname,$email,$psw);
            mysqli_stmt_execute($stmt);
  }
}


Function updateAdmin($conn,$fname,$lname,$email,$pass,$userType,$id){
  if(empty($pass)){
    $sql = "UPDATE admin SET first_name=?,last_name=?,e_mail=? WHERE user_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
      header("Location: ../updateUser.php?error=sql");
      exit();
    }
    mysqli_stmt_bind_param($stmt,"sssi",$fname,$lname,$email,$id);
    mysqli_stmt_execute($stmt);
  }else{
    $sql = "UPDATE admin SET first_name=?,last_name=?,e_mail=?,passwrd=? WHERE user_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
      header("Location: ../updateUser.php?error=sql");
      exit();
    }
    $passEncrepted = password_hash($pass,PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"ssssi",$fname,$lname,$email,$passEncrepted,$id);
    mysqli_stmt_execute($stmt);
  }
}
Function updateEmployee($conn,$fname,$lname,$email,$pass,$userType,$id){
  if(empty($pass)){
    $sql = "UPDATE employee SET first_name=?,last_name=?,e_mail=? WHERE user_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
      header("Location: ../updateUser.php?error=sql");
      exit();
    }
    mysqli_stmt_bind_param($stmt,"sssi",$fname,$lname,$email,$id);
    mysqli_stmt_execute($stmt);
  }else{
    $sql = "UPDATE employee SET first_name=?,last_name=?,e_mail=?,passwrd=? WHERE user_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
      header("Location: ../updateUser.php?error=sql");
      exit();
    }
    $passEncrepted = password_hash($pass,PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"ssssi",$fname,$lname,$email,$passEncrepted,$id);
    mysqli_stmt_execute($stmt);
  }
}
Function deleteAllApplicationsAndSubmitsAndSupervise($conn,$id){ // we delete employee
  // Delete the application's of the employee
  $sql = "DELETE FROM application WHERE application_code IN (SELECT application_code FROM submits WHERE user_id=?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
    header("Location: ../updateUser.php?error=sql");
    exit();
  }
  mysqli_stmt_bind_param($stmt,"i",$id);
  mysqli_stmt_execute($stmt);
  // Delete the submits's of the employee
  $sql = "DELETE FROM submits WHERE user_id=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
    header("Location: ../updateUser.php?error=sql");
    exit();
  }
  mysqli_stmt_bind_param($stmt,"i",$id);
  mysqli_stmt_execute($stmt);
  // Delete the supervise's of the employee
  $sql = "DELETE FROM supervise WHERE id_of_employee=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
    header("Location: ../updateUser.php?error=sql");
    exit();
  }
  mysqli_stmt_bind_param($stmt,"i",$id);
  mysqli_stmt_execute($stmt);
}
Function deleteSuperviseOfAdmin($conn,$id){
  $sql = "DELETE FROM supervise WHERE id_of_admin=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
    header("Location: ../updateUser.php?error=sql");
    exit();
  }
  mysqli_stmt_bind_param($stmt,"i",$id);
  mysqli_stmt_execute($stmt);
}
