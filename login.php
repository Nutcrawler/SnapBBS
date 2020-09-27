<?php
require_once('htpasswd.inc');
$threadlist = simplexml_load_file("threadlist.xml");
$username = (string)$_POST["username"];
$password = (string)$_POST["password"];
$pass_array = load_htpasswd();
if ((strtolower($username) == "guest") && ($threadlist['guests'] == 'yes'))
{
	session_start();
	$_SESSION['boards_username'] = "guest";
	$_SESSION['board_url'] = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/threadlist.php?" . SID);
	exit();
}
if((!empty($_POST["password"])) && (!empty($_POST["username"]))) 
{


		
	if ( test_htpasswd( $pass_array,  $username, $password ))
	{
		session_start();
		$_SESSION['boards_username'] = $username;
		$_SESSION['board_url'] = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/threadlist.php?" . SID);
	}
	else
	{
		echo "<html><head><title>SnapBBS: Error</title></head><body>Error: Incorrect username or password!</body></html>";
	}
	
} 
else 
{
	echo "<html><head><title>SnapBBS: Error</title></head><body>Error: Information not properly entered</body></html>";
}
?>

