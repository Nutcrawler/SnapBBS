<?php
function time_delta($timestamp)
{
  $sec = time() - $timestamp;   // unix timestamp is in seconds
  if($sec <= 60)
    return "$sec seconds";

  $min = intval($sec / 60);
  if($min <= 60)
    return "$min minutes";

  $hr = intval($min / 60);
  if($hr <= 24)
  {
    $min = $min % 60;     // remainder
    return "$hr hours $min minutes";
  }

  $days = intval($hr / 24);
  $hr = $hr % 24;
  return "$days days $hr hours";
}
?>
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
		$threadid = (string)$_GET["threadid"];
		if (file_exists($threadid . ".thread.xml"))
		{
			if (preg_match('/[^A-Fa-f0-9]/',$threadid))
			{
				print "<title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
				print '<div class="centeralign"><h1>' . $threadlist['boardname'] . " <br>No such thread</h1>";
				print '<a href="threadlist.php?' . SID . '">Back</a></div><br>';
			}
			else
			{
				$thread = simplexml_load_file($threadid . ".thread.xml");
				print "<title>" . $threadlist['boardname'] . ' -  ' . $thread['title'] . '</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
				print '<div class="centeralign"><h1>' . $threadlist['boardname'] ."</h1><h2>" . $thread['title'] . '</h2>';
				if ($_SESSION['boards_username'] == "guest")
				{
					print '<a href="threadlist.php?' . SID . '">Return to board index</a><br><br>';
					print '<b>You are not logged in.</b> <a href="index.php?' . SID . '">Log in</a> | <a href="signup.php">Sign up</a></div><br>';
				}
				else
				{
					print '<a href="threadlist.php?' . SID . '">Return to board index</a> | <a href="admingate.php?' . SID . '&dest=adminthread&threadid=' . $threadid .  '">Admin Thread</a></div><br>';
				}
				print '<div class="threadshow"><hr>';
				foreach ($thread->post as $post)
				{
					print '--' . $post['poster'] . " posted " . time_delta($post['time']) . " ago:<br><br> " . nl2br( htmlspecialchars($post, ENT_QUOTES) . '<br><hr>');
				}
				print '</div><div class="centeralign">';
				if ($_SESSION['boards_username'] != "guest")
				{
					print '<form method="post" action="newpost.php?' . SID . '&threadid=' . $threadid . '" name="newpost">';	
					print '<textarea wrap="soft" cols="65" rows="5" name="message"></textarea><br>';
					print '<input value="Post reply" type="submit">';
					print '</form>';
				}
			}
			
		}
		else
		{
			//Thread does not exist
			print "<title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
			print '<div class="centeralign"><h1>' . $threadlist['boardname'] . " No such thread</h1>";
			print '<a href="threadlist.php?' . SID . '">Back</a></div><br>';
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