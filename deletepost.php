<?php
session_start();
$threadlist = simplexml_load_file("threadlist.xml");
if (!empty($_SESSION['boards_username']))
{
	$username = strtolower($_SESSION['boards_username']); //fetch the username
	$threadid = (string)$_GET["threadid"];
	$postid = (string)$_GET["postid"];
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		if (file_exists($threadid . ".thread.xml"))
		{
			if (preg_match('/[^A-Fa-f0-9]/',$threadid))
			{
				print "<html><head><title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
				print '<div class="centeralign"><h1>' . $threadlist['boardname'] . " <br>No such thread</h1>";
				exit( '<a href="threadlist.php?' . SID . '">Back</a></div><br></body></html>');
			}
			if($_SESSION['adminmode'] == 'true')
			{
				$thread = simplexml_load_file($threadid . '.thread.xml');
				$elementnumber = 0;
				foreach ($thread->post as $post)
				{
					if($post['id'] == $postid)
					{
						$thread->post[$elementnumber] = "*Post Deleted*";
					}
					$elementnumber++;
				}
				$fileid = fopen($threadid . '.thread.xml','w') or exit("Unable to open file!");
				flock($fileid, LOCK_EX);
				fwrite($fileid, $thread->asXML());
				flock($fileid,LOCK_UN);
				fclose($fileid);
				header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/showthread.php?" . SID . '&threadid=' . $threadid);
			}
			else //ask for admin password!
			{
				print "<html><head><title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body><div class="centeralign">';
				exit( "You are not an admin!</body></html>");
			}
		}
		else
		{
			print "<html><head><title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
			print '<div class="centeralign"><h1>' . $threadlist['boardname'] . " <br>No such thread</h1>";
			exit( '<a href="threadlist.php?' . SID . '">Back</a></div><br></body></html>');
		}	
	}
	else
	{
		print "<html><head><title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body><div class="centeralign">';
		exit( "Wrong board, sorry!</body></html>");
	}
}
else
{
	print "<html><head><title>" . $threadlist['boardname'] . ' - Error </title><link rel="stylesheet" href="default.css" type="text/css"></head><body><div class="centeralign">';
	exit ('You have been logged out or your session has expired. Please <a href="index.php">log in</a> again</body></html>');
}
?>
