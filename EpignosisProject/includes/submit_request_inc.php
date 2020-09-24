<?php
if(isset($_POST['submit-request'])){
  header('Location: ../submissionForm.php');
  exit();
}else{
  header('Location: ../employee.php');
  exit();
}
