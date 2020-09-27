<?php
session_start();
if (!empty($_SESSION['boards_username']))
{
	if ($_SESSION['boards_username'] == "guest")
	{
		print "Guests are not allowed to post, sorry. Please sign up first.";
	}
	else
	{
		$username = $_SESSION['boards_username']; //fetch the username
		if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
		{
			if((!empty($_POST["title"])) && (!empty($_POST["message"])))
			{
				$title = (string)$_POST["title"];
				if(strlen($title) > 50)
				{
					$title = substr($title,0,49);
				}
				$message = (string)$_POST["message"];
				if (get_magic_quotes_gpc())
				{
					$title = htmlspecialchars(stripslashes($title),ENT_QUOTES);
					$message = htmlspecialchars(stripslashes($message),ENT_QUOTES);
				}
				else
				{
					$title = htmlspecialchars($title,ENT_QUOTES);
					$message = htmlspecialchars($message,ENT_QUOTES);
				}
				if(strlen($title) > 50)
				{
					$title = substr($title,0,49);
				}
				$threadid = md5(microtime() . rand());
				$thread = simplexml_load_string("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?><thread></thread>");
				$thread->addAttribute("poster",$username);
				$thread->addAttribute("title",$title);
				$thread->addAttribute("id",$threadid);
				$thread->addAttribute("time",time());
				$post = $thread->addChild('post',$message);
				$post->addAttribute("poster",$username);
				$post->addAttribute("id",md5(microtime() . rand())); //The post gets it's own unique ID.
				$post->addAttribute("time",time());
				$fileid = fopen($threadid . ".thread.xml",'w') or exit("Unable to open file!");
				flock($fileid, LOCK_EX);
				fwrite($fileid, $thread->asXML());
				flock($fileid,LOCK_UN);
				fclose($fileid);
				//Now for the hard part, read the threadlist and bump the thread.
				$oldthreadlist = simplexml_load_file('threadlist.xml');
				$newthreadlist = simplexml_load_string("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?><threadlist></threadlist>");
				$newthreadlist->addAttribute("boardname",$oldthreadlist['boardname']);
				$newthreadlist->addAttribute("signups",$oldthreadlist['signups']);
				$newthreadlist->addAttribute("guests",$oldthreadlist['guests']);
				$newthread = $newthreadlist->addChild('thread',$title);
				$newthread->addAttribute('id',$threadid);
				$newthread->addAttribute('poster',$username);
				$newthread->addAttribute('lastposter',$username);
				$newthread->addAttribute('postcount','1');
				$newthread->addAttribute('lastposttime',time());
				foreach ($oldthreadlist->thread as $thread)
				{
					$newthread = $newthreadlist->addChild('thread',$thread);
					$newthread->addAttribute('id',$thread['id']);
					$newthread->addAttribute('poster',$thread['poster']);
					$newthread->addAttribute('lastposter',$thread['lastposter']);
					$newthread->addAttribute('postcount',$thread['postcount']);
					$newthread->addAttribute('lastposttime',$thread['lastposttime']);
				}
				$fileid = fopen("threadlist.xml",'w') or exit("Unable to open file!");
				flock($fileid, LOCK_EX);
				fwrite($fileid, $newthreadlist->asXML());
				flock($fileid,LOCK_UN);
				fclose($fileid);
				header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/showthread.php?" . SID . '&threadid=' . $threadid);
			}
			else
			{
				exit( "You must enter a title and a message!");
			}
		}
		else
		{
			exit("Wrong board, sorry!");
		}
	}
}
else
{
	echo 'You have been logged out or your session has expired. Please <a href="index.php">log in</a> again';
}

?>
