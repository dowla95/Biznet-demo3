<?php 
include("../Connections/conn_admin.php");
$nizi=$_POST['ara'];

$pex=explode(",",kategorije($nizi,"page",1));
foreach($pex as $key => $value)
{ 
$pro=mysqli_query($conn, "SELECT * FROM page WHERE id=$value");
$pro1=mysqli_fetch_assoc($pro);
if($pro1['akt']==1) $novo=0; else $novo=1;
if(!mysqli_query($conn, "UPDATE page SET akt=$novo WHERE id=$value")) echo mysqli_error();
}
?>