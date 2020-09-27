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
	$username = strtolower($_SESSION['boards_username']); //fetch the username
	$threadid = (string)$_GET["threadid"];
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		print '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
		print '<html><head><meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">';
		print "<title>" . $threadlist['boardname'] . ' - Admin Mode </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
		if (file_exists($threadid . ".thread.xml"))
		{
			if (preg_match('/[^A-Fa-f0-9]/',$threadid))
			{
				print "<title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
				print '<div class="centeralign"><h1>' . $threadlist['boardname'] . " <br>No such thread</h1>";
				exit( '<a href="threadlist.php?' . SID . '">Back</a></div><br>');
			}
			if($_SESSION['adminmode'] == 'true')
			{
				$thread = simplexml_load_file($threadid . ".thread.xml");
				print '<div class="centeralign"><h1>' . $threadlist['boardname'] ."</h1><h2>" . $thread['title'] . ' - Admin mode</h2>';
				print '<a href="threadlist.php?' . SID . '">Return to board index</a> | <a href="deletethread.php?' . SID . '&threadid=' . $threadid . '">Delete this thread</a></div><br>';
				print '<div class="threadshow">';
				foreach ($thread->post as $post)
				{
					print $post['poster'] . " posted " . time_delta($post['time']) . " ago:<br><br> " . nl2br( htmlspecialchars( $post, ENT_QUOTES) . '<br><br>') . '<a href="deletepost.php?' . SID . '&postid=' . $post['id'] .'&threadid=' . $threadid .'">Delete this post</a><hr>';
				}
				print '</div>';
			}
			else //ask for admin password!
			{
				print "<title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body><div class="centeralign">';
				exit('<div class="centeralign">You are not an admin!</div>');
			}
		}
		else
		{
			print "<title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
			print '<div class="centeralign"><h1>' . $threadlist['boardname'] . " <br>No such thread</h1>";
			exit( '<a href="threadlist.php?' . SID . '">Back</a></div><br>');
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
