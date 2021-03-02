<?php 
session_start();
$RandomStr = md5(microtime());// md5 to generate the random string
$ResultStr = substr($RandomStr,0,5);//trim 5 digit 
$_SESSION['keys'] = $ResultStr;// carry the data through session
$NewImage =imagecreatefromjpeg("images/images.jpg");//image create by existing image and as back ground 
$LineColor = imagecolorallocate($NewImage,233,239,239);//line color 
$TextColor = imagecolorallocate($NewImage, 255, 255, 255);//text color-white
imageline($NewImage,1,1,40,40,$LineColor);//create line 1 on image 
imageline($NewImage,1,100,60,0,$LineColor);//create line 2 on image 
imagestring($NewImage, 5, 9, 9, $ResultStr, $TextColor);// Draw a random string horizontally 
header("Content-type: image/jpeg");// out out the image 
imagejpeg($NewImage);//Output image to browser 
?>