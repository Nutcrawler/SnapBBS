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
	$username = strtolower($_SESSION['boards_username']); //fetch the username;
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		print '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
		print '<html><head><meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">';
		print "<title>" . $threadlist['boardname'] . ' - Admin Control Panel </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';

		if($_SESSION['adminmode'] == 'true')
		{
			print '<div class="centeralign"><h1>' . $threadlist['boardname'] ."</h1><h2>" . $threadlist['boardname'] . ' - Admin Control Panel</h2>';
			print '<a href="threadlist.php?' . SID . '">Return to board index</a></div><br>';
			print '<table class="threadlist"><tbody><tr><td><a href="appearance.php?' . SID . '">Appearance settings</a></td></tr>';
			print '<tr><td><a href="usercp.php?' . SID . '">User management</a></td></tr>';
			print '<tr><td><a href="userlist.php?' . SID . '">User list</a></td></tr>';
			print '<tr><td><a href="invite.php?' . SID . '">Invite new user</a></td></tr>';
			print '</tbody></table>';
		}
		else
		{
			exit( "You are not an admin!");
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
