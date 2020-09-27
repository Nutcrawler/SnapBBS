<?php
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); 
$captext = strtoupper( dechex(rand(65536,1048575)));
$fontselector = rand(0,5);
$thefont = imageloadfont("anonymous.gdf");
$im = imagecreate(150, 50);
imagesetthickness($im,2);
$bg = imagecolorallocate($im, rand(0,155),rand(0,155),rand(0,155));
$drawingcolor = imagecolorallocate($im, rand(100,255), rand(100,255), rand(100,255));
for($x = 0; $x < 3 ; $x++)
{
	imageline($im, 0, rand(0,50), 150, rand(0,50), $drawingcolor);
}
imagesetthickness($im,3);
for($x = 0; $x < 10 ; $x++)
{
	$singlepointx = rand(0,150);
	$singlepointy = rand(0,50);
	imageline($im, $singlepointx, $singlepointy, $singlepointx+3, $singlepointy, $drawingcolor);
}
$_SESSION['captext'] = $captext;
imagestring($im, $thefont, rand(0,36),rand(0,14), $captext, $drawingcolor);
header("Content-type: image/jpeg");
imagejpeg($im);
?>
