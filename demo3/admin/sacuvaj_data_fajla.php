<?php 
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
$id=$_POST['idslike'];
$column=array("");
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
{
$lang=$la1['jezik'];
$column="naslov=".safe($_POST["naslov$lang"]);
 
if(!mysqli_query($conn, "UPDATE files_lang SET $column WHERE id_fajla=$id AND lang='$lang'")) echo mysqli_error();
}
  
if($_POST['akti']==1) $akti="Y"; else $akti="N";
if($_POST['pozicija']!="") $pozicija=",pozicija='$_POST[pozicija]'";
else $pozicija= ",pozicija=NULL";
mysqli_query($conn, "UPDATE $_POST[tabli] SET akt='$akti'$pozicija  WHERE id=$id");
 
//if(mysqli_affected_rows()>0)
///echo "IZMENJENO";
?>
