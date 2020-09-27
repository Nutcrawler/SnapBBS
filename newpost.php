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
			$threadlist = simplexml_load_file("threadlist.xml");
			if(!empty($_POST["message"]))
			{
				$message = (string)$_POST["message"];
				if (get_magic_quotes_gpc())
				{
					$message = htmlspecialchars(stripslashes($message),ENT_QUOTES);
				}
				else
				{
					$message = htmlspecialchars($message,ENT_QUOTES);
				}
				$threadid = (string)$_GET["threadid"];
				
				if (file_exists($threadid . ".thread.xml"))
				{
					if (preg_match('/[^A-Fa-f0-9]/',$threadid))
					{
						print 'No such thread';
					}
					else
					{
						$thread = simplexml_load_file($threadid . ".thread.xml");
						$title = $thread['title'];
						$post = $thread->addChild('post',$message);
						$post->addAttribute("poster",$username);
						$post->addAttribute("id",md5(microtime() . rand()));
						$post->addAttribute("time",time());
						$fileid = fopen($threadid . ".thread.xml",'w');
						flock($fileid, LOCK_EX);
						fwrite($fileid, $thread->asXML());
						flock($fileid,LOCK_UN);
						fclose($fileid);
						//now count the number of posts
						$thread = simplexml_load_file((string)$_GET["threadid"] . ".thread.xml");
						foreach ($thread->post as $post)
						{
							$postcount++;
						}
						//now it is time to update the threadlist... SCARY!
						$oldthreadlist = simplexml_load_file('threadlist.xml');
						$newthreadlist = simplexml_load_string("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?><threadlist></threadlist>");
						$newthreadlist->addAttribute("boardname",$oldthreadlist['boardname']);
						$newthreadlist->addAttribute("signups",$oldthreadlist['signups']);
						$newthreadlist->addAttribute("guests",$oldthreadlist['guests']);
						$newthread = $newthreadlist->addChild('thread',$title);
						$newthread->addAttribute('id',$threadid);
						$newthread->addAttribute('poster',$thread['poster']);
						$newthread->addAttribute('lastposter',$username);
						$newthread->addAttribute('postcount',$postcount);
						$newthread->addAttribute('lastposttime',time());
						foreach ($oldthreadlist->thread as $oldthread)
						{
							if($oldthread['id'] != $threadid) //skip this thread to bump
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
						header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/showthread.php?" . SID . '&threadid=' . $threadid);
					}
				}
				else
				{
					//Thread does not exist
					print 'No such thread';
				}
				
			}
			else
			{
				exit( "You must enter a message!");
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
