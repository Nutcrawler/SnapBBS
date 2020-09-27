<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
<?php
session_start();
	$threadlist = simplexml_load_file("threadlist.xml");
	print "<title>" . $threadlist['boardname'] . ' - Sign Up</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';
?>

<div class="centeralign">
<h3>Sign up</h3>
<?php
if ($threadlist['signups'] == "private")
{
	print 'Board is invite only, no public registration.';
}

else
{
	print '<form action="signup2.php?' . SID . '" method="post">';
	print '<input name="username" type="text"> <br>Desired username<br><br>';
	print '<input name="password" type="password"> <br>Password <br><br>';
	print '<input name="password2" type="password"> <br>Repeat password<br><br>';
	print '<img src="cap.php?' . SID . '"><br>';
	print '<input name="captext"> <br>Enter the numbers and letters from the image<br>';
	print '<input value="Sign up" type="submit">';
}
?>
</form>
</div>
</body>
</html>
