<?php 
include("Connections/conn.php");
 $fajl=$_GET['down']; 
 $ext=substr($fajl,-3);
 if($_GET['fold']=="ir") $fold="deklaracije";
 if($_GET['fold']=="bi") $fold="cv-biografije";
 if($_GET['fold']=="fi") $fold="files";
if($_GET['fold']=="pp") $fold="propratno_pismo";

if(file_exists("$page_path2/private/$fold/$fajl") and ($fold=="cv-biografije" or $fold=="propratno_pismo"))
$fold=$fold;
elseif(file_exists("$page_path2/private/".$fold."1/$fajl") and ($fold=="cv-biografije" or $fold=="propratno_pismo"))
$fold=$fold."1";
 ///echo filesize("files/$fajl");
header("Content-Type: application/octet-stream");
Header("Content-Type: file/$ext; name=\"$fajl\"");
Header("Content-Length: ".filesize("$page_path2/private/$fold/$fajl"));
Header("Content-Disposition: attachment; filename=\"$fajl\"");
readfile("$page_path2/private/$fold/$fajl") or die ("File read error");
?>