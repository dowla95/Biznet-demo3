<?php 
	$line=file("vote.txt");
			$line[0] +=1;
	$fp=fopen("vote.txt","w");
		fwrite($fp,$line[0]);
		fclose($fp);
$ResultStr = $_GET['id'];//trim 5 digit 
header("Content-type: image/jpeg");// out out the image 
//readfile("http://www.klikdoposla.me/private/images/images.jpg");//Output image to browser 
?>