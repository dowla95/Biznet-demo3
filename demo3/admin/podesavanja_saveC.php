<?php 
 include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
if($_POST['izmeni_podesavanja'])
{
 $la=mysqli_query($conn, "SELECT * FROM izgled");
 while($la1=mysqli_fetch_array($la))
 {
 $polje=$la1['polje'];
if(!mysqli_query($conn, "UPDATE izgled SET vrednost=".safe($_POST[$polje])." WHERE polje='$polje'")) echo mysqli_error();
 }
header("location: $patHA/index.php?base=admin&page=podesavanjaAC&id=1");
}
?>