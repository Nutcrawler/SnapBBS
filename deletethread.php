<?php
session_start();
$threadlist = simplexml_load_file("threadlist.xml");
if (!empty($_SESSION['boards_username']))
{
	$username = strtolower($_SESSION['boards_username']); //fetch the username
	$threadid = (string)$_GET["threadid"];
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
				unlink($threadid . ".thread.xml");
				$oldthreadlist = simplexml_load_file('threadlist.xml');
				$newthreadlist = simplexml_load_string("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?><threadlist></threadlist>");
				$newthreadlist->addAttribute("boardname",$oldthreadlist['boardname']);
				$newthreadlist->addAttribute("signups",$oldthreadlist['signups']);
				$newthreadlist->addAttribute("guests",$oldthreadlist['guests']);
				foreach ($oldthreadlist->thread as $oldthread)
				{
					if($oldthread['id'] != $threadid) //skip this thread to delete it
					{
						$newthread = $newthreadlist->addChild('thread',$oldthread);
						$newthread->addAttribute('id',$oldthread['id']);
						$newthread->addAttribute('poster',$oldthread['poster']);
						$newthread->addAttribute('lastposter',$oldthread['lastposter']);
						$newthread->addAttribute('postcount',$oldthread['postcount']);
						$newthread->addAttribute('lastposttime',$oldthread['lastposttime']);
					}
				}
				$fileid = fopen("threadlist.xml",'w') or exit("Unable to open file!");
				flock($fileid, LOCK_EX);
				fwrite($fileid, $newthreadlist->asXML());
				flock($fileid,LOCK_UN);
				fclose($fileid);
				header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/threadlist.php?" . SID);
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
