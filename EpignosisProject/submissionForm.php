
<!DOCTYPE html>
<html class="subbf">
<head><title>Submission Form</title></head>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
  <h1>Submit An Application</h1>
  <form class="sub" action="includes/submit_app_inc.php" method="post">
    <!--<p>Today</p>
    <input type="date" name="today"></input>-->
    <p>Vacation Start</p>
    <input type="date" name="dateS"></input>
    <p>Vacation End</p>
    <input type="date" name="dateE"></input>
    <p>Reason</p>
    <textarea id="txt" name="txt" rows="5" cols="40"></textarea>
    <br><br><br>
    <button type="submit" name="submit-application">Submit</button>
  </form>
</body>

</html>
