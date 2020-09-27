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
		if ($username == "guest")
		{
			exit("Guests are not allowed to send messages");
		}
		if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
		{
			$threadlist = simplexml_load_file("threadlist.xml");
			if(!empty($_POST["message"]))
			{
				$message = (string)$_POST["message"];
				$to = strtolower((string)$_POST["to"]);
				if (get_magic_quotes_gpc())
				{
					$message = htmlspecialchars(stripslashes($message),ENT_QUOTES);
				}
				else
				{
					$message = htmlspecialchars($message,ENT_QUOTES);
				}
				if (preg_match('/[^A-Za-z0-9-_]/', $to))
				{
					exit("Invalid username");
				}
				if (file_exists($to . ".user.xml"))
				{

					$messagexml = simplexml_load_file($to . ".user.xml");
					$pm = $messagexml->addChild('pm',$message);
					$pm->addAttribute("sender",$username);
					$pm->addAttribute("id",md5(microtime() . rand()));
					$pm->addAttribute("time",time());
					$fileid = fopen($to . ".user.xml",'w');
					flock($fileid, LOCK_EX);
					fwrite($fileid, $messagexml->asXML());
					flock($fileid,LOCK_UN);
					fclose($fileid);
					header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/readmessages.php?" . SID . '&messagesent=yes');
				
				}
				else
				{
					//User does not exist
					print "User does not exist";
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
