<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
<?php
$threadlist = simplexml_load_file("threadlist.xml");
if (!empty($_SESSION['boards_username']))
{
	$username = $_SESSION['boards_username']; //fetch the username
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		
		print "<title>" . $threadlist['boardname'] . ' - Change Password</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
		print '<div class="centeralign"><h1>' . $threadlist['boardname'] ." - Change Password</h1>";
		print '<form action="changepass.php?' . SID . '" method="post">';
		print '<input name="password" type="password"> <br>New Password <br><br>';
		print '<input name="password2" type="password"> <br>Repeat password<br><br>';
		print '<input value="Change Password" type="submit"></form>';
	}
	else
	{
		print "<title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body><div class="centeralign">';
		exit( "Wrong board, sorry!");
	}
}
else
{
	print "<title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body><div class="centeralign">';
	exit ('You have been logged out or your session has expired. Please <a href="index.php">log in</a> again');
}
?>
</div>
</body>
</html>
