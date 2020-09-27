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
		print "<title>" . $threadlist['boardname'] . ' - Appearance Admin</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';

		if($_SESSION['adminmode'] == 'true')
		{
			$text = (string)$_POST["text"];
			$background = (string)$_POST["background"];
			$link = (string)$_POST["link"];
			$table = (string)$_POST["table"];
			if ((preg_match('/[^A-Fa-f0-9]/',$text)) || (preg_match('/[^A-Fa-f0-9]/',$background)) || (preg_match('/[^A-Fa-f0-9]/',$link)) || (preg_match('/[^A-Fa-f0-9]/',$table)))
			{
				//failed first sanity check
				exit( "Invalid colors!");
			}
			if ((strlen($text) != 6) || (strlen($background) != 6) || (strlen($link) != 6) || (strlen($table) != 6))
			{
				//failed second sanity check
				exit( "Invalid colors!");
			}
			$csspage =  file_get_contents('template.css');
			$csspage = str_replace('fg-color',$text,$csspage);
			$csspage = str_replace('bg-color',$background,$csspage);
			$csspage = str_replace('link-color',$link,$csspage);
			$csspage = str_replace('table-color',$table,$csspage);
			$fileid = fopen("default.css",'w') or exit("Unable to open file!");
			flock($fileid, LOCK_EX);
			fwrite($fileid, $csspage);
			flock($fileid,LOCK_UN);
			fclose($fileid);
			print 'New stylesheet saved! <a href="admincp.php?' . SID . '">Return to Admin Control Panel</a><br>';
			
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
