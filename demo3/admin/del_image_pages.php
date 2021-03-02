<?php 
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
$slika=$_GET['slika'];
$id=$_GET['id'];
@unlink("..".GALFOLDER."/thumb/$slika");
@unlink("..".GALFOLDER."/$slika");
mysqli_query($conn, "DELETE FROM $_GET[tabli]  WHERE id=$id LIMIT 1");
mysqli_query($conn, "DELETE FROM slike_lang  WHERE id_slike=$id");
?>
