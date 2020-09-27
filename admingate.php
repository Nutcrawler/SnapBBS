<?php
session_start();
$dest = (string)$_GET["dest"];
if (preg_match('/[^A-Za-z0-9]/', $dest)) //Is the destination invalid?
{
	$dest = 'threadlist'; //Reset it to default then.
}
if (!empty($_SESSION['boards_username']))
{
	$username = strtolower($_SESSION['boards_username']); //fetch the username
	$threadid = (string)$_GET["threadid"];
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		//$_SESSION['adminmode'] = 'true'; //force admin
		if($_SESSION['adminmode'] == 'true') //If we're already admin, forward to the destination directly
		{
			if (strlen($threadid) > 0)
			{
				header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/" . $dest . ".php?" . SID . '&threadid=' . $threadid);
			}
			else
			{
				header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/" . $dest . ".php?" . SID);
			}
		}
		else //ask for admin password!
		{
			print '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
			print '<html><head><meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">';
			$threadlist = simplexml_load_file("threadlist.xml");
			print "<title>" . $threadlist['boardname'] . ' - Admin Mode </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
			print '<div class="centeralign"><h2>Please enter the admin password</h2>';
			if (strlen($threadid) > 0)
			{
				print '<form action="admingate2.php?' . SID . '&dest=' . $dest . '&threadid=' . $threadid . '" method="post">';
			}
			else
			{
				print '<form action="admingate2.php?' . SID . '&dest=' . $dest . '" method="post">';
			}
			print '<br><br>';
			print '<input name="password" type="password"><br>Password<br><br>';
			print '<input value="Log in" type="submit">';
			print '</form></div></body></html>';
		}
		
	}
	else
	{
		exit( "Wrong board, sorry!");
	}
}
else
{
	exit ('You have been logged out or your session has expired. Please <a href="index.php">log in</a> again');
}
?>
