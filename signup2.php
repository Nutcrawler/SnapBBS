<?php session_start(); ?>
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
<?php
$threadlist = simplexml_load_file("threadlist.xml");
print "<title>" . $threadlist['boardname'] . ' - Sign Up</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
require_once('htpasswd.inc');
if ($threadlist['signups'] == "private")
{
	echo 'Board is invite only, no public registration.';
}
else
{
	if((!empty($_POST["password"])) && (!empty($_POST["username"])) && (!empty($_SESSION['captext']))) 
	{
	
		if($_SESSION['captext'] == strtoupper($_POST["captext"]))
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
					echo 'Error: Username must only contain numbers, letters, and the characters - and _  <a href="signup.php">Return to the the signup page</a> and try again.';
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
								echo 'New user created. <a href="index.php">Log in</a>';
							}
							else
							{
								echo 'Error: There is already a user with that name! <a href="signup.php">Return to the the signup page</a> and try again.';
							}
						}
						else
						{
							echo 'Error: Passwords do not match, or password is less than 6 characters long! <a href="signup.php">Return to the the signup page</a> and try again.';
						}
					}
				}
			}
		}
		else
		{
			echo 'Error: Captcha failed. <a href="signup.php">Return to the the signup page</a> and try again.';
		}
	} 
	else 
	{
		echo 'Error: Information not properly entered. <a href="signup.php">Return to the the signup page</a> and try again.';
	}
}
session_destroy();
?>
</body>
</html>
