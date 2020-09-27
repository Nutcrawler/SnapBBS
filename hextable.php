<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
<title>Hex color chart</title>
</head>
<body>
<table><tbody><tr>
<?php //Hooray for ugly hacky php!
for($x = 0; $x < 256; $x+=(17*3))
{
	for($y = 0; $y < 65536; $y+=(4352*3))
	{
		for($z = 0; $z < 16777216; $z+=(1114112*3))
		{
			$out = dechex($x + $y + $z);
			if(strlen($out) == 1)
			{
				$out="0" . $out;
			}
			
			if(strlen($out) == 2)
			{
				$out="00" . $out;
			}
			if(strlen($out) == 4)
			{
				$out="00" . $out;
			}
			if ((hexdec(substr($out,0,2)) + hexdec(substr($out,2,2)) + hexdec(substr($out,4,2))) < hexdec('ff'))
			{
				$fontcol = "ffffff";
			}
			else
			{
				$fontcol = "000000";
			} 
			
			print '<td style="background-color: #' . $out . '; text-align: center; color: #' . $fontcol . ';">' . strtoupper($out) . '</td>' ;
		}
		print "</tr><tr>";
	}
}

?>
</tr>
</tbody></table>
</body>

</html>

