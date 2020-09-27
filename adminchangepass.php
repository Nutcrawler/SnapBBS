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
	$username = strtolower($_SESSION['boards_username']); //fetch the username
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		print '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
		print '<html><head><meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">';
		print "<title>" . $threadlist['boardname'] . ' - Change Password</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';

		if($_SESSION['adminmode'] == 'true')
		{
			print '<div class="centeralign"><h1>' . $threadlist['boardname'] ."</h1><h2>" . $threadlist['boardname'] . ' - Change Password</h2>';
			$username = (string)$_POST["username"];
			$new_pass = (string)$_POST["password"];
			$new_pass_ver = (string)$_POST["password2"];
			if (($new_pass == $new_pass_ver) && (strlen($new_pass) > 5))
			{
				$pass_array = load_htpasswd();
				if (!empty($pass_array[$username]))
				{
					$pass_array[$username] = rand_salt_sha1($new_pass);
					save_htpasswd($pass_array);
					echo '<br><br><br><br><div class="centeralign">Password changed. <a href="admincp.php?' . SID . '">Return to admin control panel</a></div>';
				}
				else
				{
					//more forced admin
					//$username = 'admin';
					//$new_pass = 'password';
					//$pass_array[$username] = rand_salt_sha1($new_pass);
					//save_htpasswd($pass_array);
					echo 'Error: No such user. <a href="usercp.php?' . SID . '">Return to user management</a> and try again.';
				}
			}
			else
			{
				echo 'Error: Passwords do not match, or password is under 6 characters <a href="usercp.php?' . SID . '">Return to user management</a> and try again.';
			}
	
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
