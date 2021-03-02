<?php 
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
if($_POST['izm_stavke'])
{
$la=mysqli_query($conn, "SELECT * FROM settings3");
while($la1=mysqli_fetch_array($la))
{
$polje=$la1['fields'];  
if(!mysqli_query($conn, "UPDATE settings3 SET vrednosti=".safe($_POST[$polje])." WHERE fields='$polje'")) echo mysqli_error();
 }
header("location: $patHA/index.php?base=admin&page=podesavanjaAB&id=1");
}
?>