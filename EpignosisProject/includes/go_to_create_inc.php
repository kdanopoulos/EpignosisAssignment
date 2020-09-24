<?php
if(isset($_POST['go-to-create-user'])){
  header("Location: ../createUser.php");
  exit();
}
header("Location: ../admin.php");
exit();
