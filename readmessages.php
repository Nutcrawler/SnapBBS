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
	$filetime = filemtime($username . ".user.xml");
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		$messages = simplexml_load_file($username . ".user.xml");
		print "<title>" . $threadlist['boardname'] . ' - User Messages</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
		print '<div class="centeralign"><h1>' . $threadlist['boardname'] ."</h1>";
		if ((string)$_GET["messagesent"] == "yes")
		{
			print "<h2>*Message sent*</h2>";
		}
		print '<a href="threadlist.php?' . SID . '">Return to board index</a></div><br>';
		print '<div class="threadshow"><hr>';
		foreach ($messages->pm as $pm)
		{
			print $pm['sender'] . " said " . time_delta($pm['time']) . " ago:<br><br> " . nl2br( htmlspecialchars( $pm , ENT_QUOTES) . '<br><hr>');
		}
		print '</div><div class="centeralign"><a href="emptyinbox.php?' . SID . '&filetime=' . $filetime . '">Empty your inbox</a><br><br>';
		print '<form method="post" action="newmessage.php?' . SID . '&threadid=' . $threadid . '" name="newpost">Send to:<br><input name="to" size="65">';	
		print '<br><textarea wrap="soft" cols="65" rows="5" name="message"></textarea><br>';
		print '<input value="Send message" type="submit">';
		print '</form>';
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
