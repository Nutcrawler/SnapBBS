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
?>
<?php
if (!empty($_SESSION['boards_username']))
{
	$username = $_SESSION['boards_username']; //fetch the username
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		$messages = simplexml_load_file(strtolower($username) . ".user.xml");
		$messagecount = 0;
		foreach ($messages->pm as $pm)
		{
			$messagecount++;
		}
		
		print "<title>" . $threadlist['boardname'] . ' - Index</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
		print '<div class="centeralign"><h1>' . $threadlist['boardname'] . "</h1>";
		if ($_SESSION['boards_username'] == "guest")
		{
			print '<b>You are not logged in.</b> <a href="index.php?' . SID . '">Log in</a> | <a href="signup.php">Sign up</a></div><br>';
		}
		else
		{
			print '<a href="logout.php?' . SID . '">Log out</a> | <a href="readmessages.php?' . SID . '">Messaging</a> ' . $messagecount . ' messages | <a href="password.php?' . SID . '">Change password</a> | <a href="admingate.php?' . SID . '&dest=admincp">Admin</a></div><br>';
			print '<div class="centeralign">';
			print '<form method="post" action="newthread.php?' . SID . '" name="newpost"><input name="title" size="65" maxlength="50"><br>';
			print '<textarea wrap="soft" cols="65" rows="5" ';
			print 'name="message"></textarea><br>';
			print '<input value="Post new thread" type="submit">';
			print '</form>';
		}
		print '<br><br><table class="threadlist">';
		print "<tbody>";
		print "<tr><td>Title</td><td>User </td><td>Last post</td><td>Posts</td></tr>";
		foreach ($threadlist->thread as $thread)
		{
			print '<tr><td><a href="showthread.php?' . SID . "&threadid=" . $thread['id'] . '">' . $thread . "</a></td>";
			print '<td>' . $thread['poster'] . '</td>';
			print '<td>' . time_delta($thread['lastposttime']) . " ago by " . $thread['lastposter'] . '</td>';
			print '<td>' . $thread['postcount'] . '</td></tr>';
		}
		print "</tbody></table>";
		
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
<br><br>
</div>

</body>
</html>
