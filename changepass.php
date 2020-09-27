<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
<?php
require_once('htpasswd.inc');
$threadlist = simplexml_load_file("threadlist.xml");
if (!empty($_SESSION['boards_username']))
{
	$username = $_SESSION['boards_username']; //fetch the username
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		$new_pass = (string)$_POST["password"];
		$new_pass_ver = (string)$_POST["password2"];
		if (($new_pass == $new_pass_ver) && (strlen($new_pass) > 5))
		{
			print "<title>" . $threadlist['boardname'] . ' - Change Password</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
			$pass_array = load_htpasswd();
			$pass_array[$username] = rand_salt_sha1($new_pass);
			save_htpasswd($pass_array);
			echo '<br><br><br><br><div class="centeralign">Password changed. <a href="threadlist.php?' . SID . '">Return to board index</a></div>';
		}
		else
		{
			echo 'Error: Passwords do not match, or password is under 6 characters <a href="password.php?' . SID . '">Return to the the password page</a> and try again.';
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
