<?php
$threadlist = simplexml_load_file("threadlist.xml");
session_start();
if (($threadlist['guests'] == 'yes') && (is_null($_SESSION['boards_username'])))
{
	$_SESSION['boards_username'] = "guest";
	$_SESSION['board_url'] = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/threadlist.php?" . SID);
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
 <?php
 print "<title>" . $threadlist['boardname'] . ' - Index</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
 print '<div class="centeralign"><h1>' . $threadlist['boardname'] . "</h1>";
 ?>
  	<h2>Log in</h2>
	<form action="login.php" method="post">
  	<input name="username" type="text"><br>Username
	<br><br>
	<input name="password" type="password"><br>Password <br><br>
	<input value="Log in" type="submit">
	</form>
  <?php
  if ($threadlist['signups'] != "private")
{
	print '<br><br><div><a href="signup.php">Sign up</a></div>';
}
  ?>
  
 </div>
 </body>
</html>
