<?php 
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
$id=$_POST[id];

mysqli_query($conn, "UPDATE slike_paintb SET link=".safe($_POST[link])." WHERE id=$id");
if(mysqli_affected_rows()>0)
echo "IZMENJENO";
?>
