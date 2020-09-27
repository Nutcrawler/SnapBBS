<?php
require_once('htpasswd.inc');
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
		else //process admin password, then forward!
		{
			$password = (string)$_POST["password"];
			$pass_array = load_htpasswd();
			if ( test_htpasswd($pass_array,  'admin', $password ))
			{
				$_SESSION['adminmode'] = 'true';
				if (strlen($threadid) > 0)
				{
					header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/" . $dest . ".php?" . SID . '&threadid=' . $threadid);
				}
				else
				{
					header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/" . $dest . ".php?" . SID);
				}
			}
			else
			{
				echo "<html><head><title>SnapBBS: Error</title></head><body>Error: Incorrect password!</body></html>";
			}
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
