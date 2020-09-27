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
	$username = strtolower($_SESSION['boards_username']); //fetch the username
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		print '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
		print '<html><head><meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">';
		print "<title>" . $threadlist['boardname'] . ' - New user </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';

		if($_SESSION['adminmode'] == 'true')
		{
			print '<div class="centeralign"><h1>' . $threadlist['boardname'] ."</h1><h2>" . $threadlist['boardname'] . ' - New user</h2>';
			print '<a href="admincp.php?' . SID . '">Return to Admin Control Panel</a><br>';
			print '<form action="newuser.php?' . SID . '" method="post">';
			print '<br>This will create a new user with the specified username and password<br><br>';
			print '<input name="username" type="text"> <br>Username<br><br>';
			print '<input name="password" type="password"> <br>Password<br><br>';
			print '<input name="password2" type="password"> <br>Repeat password<br><br>';
			print '<input value="Create user" type="submit">';
		}
		else
		{
			exit('<div class="centeralign">You are not an admin!</div>');
		}
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
