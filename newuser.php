<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
<?php
require_once('htpasswd.inc');
$threadlist = simplexml_load_file("threadlist.xml");
if (!empty($_SESSION['boards_username']))
{
	$username = strtolower($_SESSION['boards_username']); //fetch the username
	if($_SESSION['board_url'] == rtrim(dirname($_SERVER['PHP_SELF']), '/\\'))
	{
		print '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
		print '<html><head><meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">';
		print "<title>" . $threadlist['boardname'] . ' - New user </title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';

		if($_SESSION['adminmode'] == 'true')
		{
			if((!empty($_POST["password"])) && (!empty($_POST["username"])))
			{
				$new_user = (string)$_POST["username"];
				$new_pass = (string)$_POST["password"];
				$new_pass_ver = (string)$_POST["password2"];
				if (strtolower($new_user) == "guest")
				{
					echo 'Username is reserved! <a href="signup.php">Return to the the signup page</a>';
				}
				else
				{
					if (preg_match('/[^A-Za-z0-9-_]/', $new_user))
					{
						echo 'Error: Username must only contain numbers, letters, and the characters - and _  <a href="invite.php?' . SID . '">Return to the the invite page</a> and try again.';
					}
					else
					{
						if(strlen($new_user) > 32)
						{
							echo "Error: Username too long. Please keep it under 32 characters in length";
						}
						else
						{
							if (($new_pass == $new_pass_ver) && (strlen($new_pass) > 5))
							{
								$pass_array = load_htpasswd();
								if ((empty($pass_array[$new_user])) && (!file_exists(strtolower($new_user) . ".user.xml"))) //Two users can't sign up with different capitalization
								{
									$pass_array[$new_user] = rand_salt_sha1($new_pass);
									save_htpasswd($pass_array); 
									$file=fopen(strtolower($new_user) . ".user.xml","w") or exit("Unable to write new user.xml file! Please contact the site host.");
									fwrite($file,"<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?><user></user>");
									fclose($file);
									echo 'New user created.<a href="invite.php?' . SID . '">Return to the the invite page</a>';
								}
								else
								{
									echo 'Error: There is already a user with that name! <a href="invite.php?' . SID . '">Return to the the invite page</a> and try again.';
								}
							}
							else
							{
								echo 'Error: Passwords do not match, or password is less than 6 characters long! <a href="invite.php?' . SID . '">Return to the the invite page</a> and try again.';
							}
						}
					}
				}
				
			}
			else 
			{
				echo 'Error: Information not properly entered. <a href="invite.php?' . SID . '">Return to the the invite page</a> and try again.';
			}
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
