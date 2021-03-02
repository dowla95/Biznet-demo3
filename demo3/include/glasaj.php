<?php 
include("Connections/conn.php"); 
session_start();
$sid=$_POST[sid];

if($_SESSION[$sid]<3)

$_SESSION[$sid] +=1;
if($_SESSION[$sid]>1)

echo "Vec ste glasali!";

else

{ 
$vot=$_POST[vote][0]; 
mysqli_query($conn, "UPDATE ankete SET brglasova=brglasova+1 WHERE id='$vot'");

echo "Vaš glas je upisan!";

$pra=1;

 }



?>
