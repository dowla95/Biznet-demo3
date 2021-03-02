<?php 
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
$id=$_POST['id'];
if($_POST['idap']==0) $idap='NULL'; else $idap=$_POST['idap'];
mysqli_query($conn, "UPDATE slike_paintb SET ap=$idap WHERE id=$id");
 
?>
