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
		print "<title>" . $threadlist['boardname'] . ' - User Management</title><link rel="stylesheet" href="default.css" type="text/css"></head><body>';

		if($_SESSION['adminmode'] == 'true')
		{
			print '<div class="centeralign"><h1>' . $threadlist['boardname'] ."</h1><h2>" . $threadlist['boardname'] . ' - User Management</h2>';
			print '<a href="admincp.php?' . SID . '">Return to Admin Control Panel</a> | <a href="usercp.php?' . SID . '">Return to User Management</a><br>';
			// Copyright (C) 2004,2005 Jarno Elonen <elonen@iki.fi>
			//
			// Redistribution and use in source and binary forms, with or without modification,
			// are permitted provided that the following conditions are met:
			//
			// * Redistributions of source code must retain the above copyright notice, this
			//   list of conditions and the following disclaimer.
			// * Redistributions in binary form must reproduce the above copyright notice,
			//   this list of conditions and the following disclaimer in the documentation
			//   and/or other materials provided with the distribution.
			// * The name of the author may not be used to endorse or promote products derived
			//   from this software without specific prior written permission.
			//
			// THIS SOFTWARE IS PROVIDED BY THE AUTHOR ''AS IS'' AND ANY EXPRESS OR IMPLIED
			// WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
			// AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR
			// BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
			// DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
			// LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
			// ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
			// NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
			// EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
				  foreach(file(".htpasswd") as $l)
				  {
					  $array = explode(':',$l);
					  $user = $array[0];
					  echo $user . "<br><br>";
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
