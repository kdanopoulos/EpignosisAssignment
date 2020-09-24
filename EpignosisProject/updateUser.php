
<!DOCTYPE html>
<html class="subbf">
<head><title>Update User Form</title></head>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
  <?php
  session_start();
  require 'includes/dbh_inc.php';
  if(isset($_POST['link'])){
    $text = $_POST['link'];
    if($text[0]=='a'){ // it's an admin user --------------------------------------
      $id = intval(substr($text,1));
      $sql = "SELECT * FROM admin WHERE user_id=?";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
        header("Location: ../EpignosisProject/admin.php?error=sql");
        exit();
      }
      mysqli_stmt_bind_param($stmt,"i",$id);
      mysqli_stmt_execute($stmt);
      $stmt = mysqli_stmt_get_result($stmt);
      if(!$row = mysqli_fetch_assoc($stmt)){
        header("Location: ../EpignosisProject/admin.php?error=sql");
        exit();
      }
      $fName = $row['first_name'];
      $lName = $row['last_name'];
      $email = $row['e_mail'];
      $tp = "admin";
      printPage($tp,$fName,$lName,$email);
      $_SESSION['change_user_id'] = $id;
      $_SESSION['change_user_type'] = $tp;


    }else{ // it's an employee user --------------------------------------
      $id = intval(substr($text,1));
      $sql = "SELECT * FROM employee WHERE user_id=?";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){ // failed to prepare sql statement
        header("Location: ../EpignosisProject/admin.php?error=sql");
        exit();
      }
      mysqli_stmt_bind_param($stmt,"i",$id);
      mysqli_stmt_execute($stmt);
      $stmt = mysqli_stmt_get_result($stmt);
      if(!$row = mysqli_fetch_assoc($stmt)){
        header("Location: ../EpignosisProject/admin.php?error=sql");
        exit();
      }
      $fName = $row['first_name'];
      $lName = $row['last_name'];
      $email = $row['e_mail'];
      $tp = "employee";
      printPage($tp,$fName,$lName,$email);
      $_SESSION['change_user_id'] = $id;
      $_SESSION['change_user_type'] = $tp;
    }
  }else{
    header("Location: ../EpignosisProject/admin.php");
    exit();
  }




  Function printPage($type,$fN,$lN,$ml){
    echo '<h1>User  '.$type.' : </h1>
    <form class="sub" action="includes/update_user_inc.php" method="post">
      <p>First Name</p>
      <input type="text" name="fname" value="'.$fN.'">
      <p>Last Name</p>
      <input type="text" name="lname" value="'.$lN.'">
      <p>Email</p>
      <input type="text" name="email" value="'.$ml.'">
      <p>Password</p>
      <input type="password" name="passw" placeholder="Enter Password">
      <p>Confirm Password</p>
      <input type="password" name="conpassw" placeholder="Re-enter Password">';
      if($type=="admin"){
        echo '<select name="option">
        <option value="employee">Employee</option>
          <option value="admin" SELECTED>Admin</option>
          </select>';
      }
      else{
        echo '<select name="option">
        <option value="employee"SELECTED>Employee</option>
          <option value="admin">Admin</option>
          </select>';
      }
        echo'<br><br><button type="submit" name="update-user">Update User</button>
        </form>
        </body>';
  }
  ?>




</html>
