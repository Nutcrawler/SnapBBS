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
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		print '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
		print '<html><head><meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">';
		print "<title>" . $threadlist['boardname'] . ' - Appearance edit </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';

		if($_SESSION['adminmode'] == 'true')
		{
			$csspage =  file_get_contents('default.css');
			//I screwed up the original css file, so fix this if it's bad...
			$csspage = str_replace('black','#000000',$csspage);
			//Ok, now to load colors.
			$startposition = strpos($csspage,'#') + 1;
			$backgroundcolor = substr($csspage,$startposition,6);
			//Find the next # which is the text color
			$startposition = strpos($csspage,'#', $startposition) + 1;
			$textcolor = substr($csspage,$startposition,6);
			//Find the next # which is the link color
			$startposition = strpos($csspage,'#', $startposition) + 1;
			$linkcolor = substr($csspage,$startposition,6);
			//Find the next # which is the table color
			$startposition = strpos($csspage,'#', $startposition) + 1;
			$tablecolor = substr($csspage,$startposition,6);
			
			print '<div class="centeralign"><h1>' . $threadlist['boardname'] ."</h1><h2>" . $threadlist['boardname'] . ' - Appearance edit</h2>';
			print '<a href="admincp.php?' . SID . '">Return to Admin Control Panel</a><br>';
			print '<form action="modcss.php?' . SID . '" method="post">';
			print '<br>All colors should be entered as hex color codes. <a href="hextable.php" target="_blank">Color chart.</a><br><br>';
			print '<input name="text" type="text" value="' . $textcolor . '"> <br>Text color<br><br>';
			print '<input name="background" type="text" value="' . $backgroundcolor . '"> <br>Background color<br><br>';
			print '<input name="link" type="text" value="' . $linkcolor .'"> <br>Link color<br><br>';
			print '<input name="table" type="text" value="' . $tablecolor . '"> <br>Table color<br><br>';
			print '<input value="Update colors" type="submit">';
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
