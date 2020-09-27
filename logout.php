<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
<?php
session_start();
print "<title>" . $threadlist['boardname'] . ' - Logged out </title><link rel="stylesheet" href="default.css" type="text/css"></head><body class="centeralign">';
session_destroy();
?>
<br><br><br><br>
Logged out
</body>
</html>
