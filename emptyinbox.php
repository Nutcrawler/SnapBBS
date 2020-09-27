<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
<?php
$threadlist = simplexml_load_file("threadlist.xml");
print "<title>" . $threadlist['boardname'] . ' - Empty Inbox</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
if (!empty($_SESSION['boards_username']))
{
	$username = strtolower($_SESSION['boards_username']); //fetch the username
	$filetime = filemtime($username . ".user.xml");
	$oldfiletime = (string)$_GET["filetime"];
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		if($filetime == $oldfiletime)
		{
			$messages = simplexml_load_file($username . ".user.xml");
			print '<div class="centeralign"><h1>' . $threadlist['boardname'] ."</h1>";
			print '<a href="threadlist.php?' . SID . '">Return to board index</a><br>';
			$file=fopen(strtolower($username) . ".user.xml","w") or exit("Unable to write new user.xml file! Please contact the site host.");
			fwrite($file,"<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?><user></user>");
			fclose($file);
			print "Inbox emptied</div>";
		}
		else
		{
			print "<title>" . $threadlist['boardname'] . ' - Empty Inbox</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
			print '<div class="centeralign"><h1>' . $threadlist['boardname'] ."</h1>";
			print "There are unread messages in the inbox. Aborting erase.<br><br>";
			print '<a href="readmessages.php?' . SID . '">Return to the inbox</a></div><br>';
		}
	}
	else
	{
		exit( '<div class="centeralign">Wrong board, sorry!</div>');
	}
}
else
{
	exit ('<div class="centeralign">You have been logged out or your session has expired. Please <a href="index.php">log in</a> again</div>');
}
?>
</div>
</body>
</html>
