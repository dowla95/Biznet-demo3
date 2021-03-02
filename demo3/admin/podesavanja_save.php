<?php 
 include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
if($_POST['izmene_stavkes'])
{
 $la=mysqli_query($conn, "SELECT * FROM settings");
 while($la1=mysqli_fetch_array($la))
 {
 $polje=$la1['fields'];
if($_FILES[$polje]['tmp_name'] and $_FILES[$polje]['tmp_name']!="")
{
$slika =UploadSlika($_FILES[$polje]['name'],$_FILES[$polje]['tmp_name'],$_FILES[$polje]['type'],"$page_path2".SUBFOLDER."".GALFOLDER."/","",2);
 
if($_FILES[$polje]['name']!=""){
@unlink("$page_path2".SUBFOLDER."".GALFOLDER."/".$_POST[$polje."1"]);
@unlink("$page_path2".SUBFOLDER."".GALFOLDER."/thumb/".$_POST[$polje."1"]);
$_POST[$polje]=$slika;
}
}  
//if($_POST[$polje."1"]!="" and $_FILES[$polje]['name']=="") $_POST[$polje]=$_POST[$polje."1"];
if(!mysqli_query($conn, "UPDATE settings SET vrednosti=".safe($_POST[$polje])." WHERE fields='$polje'")) echo mysqli_error();
 }
header("location: $patHA/index.php?base=admin&page=podesavanjaAA&id=1");
}
?>