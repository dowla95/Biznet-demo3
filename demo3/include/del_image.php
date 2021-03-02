<?php 
include("../Connections/conn.php");
$slika=$_GET['slika'];
$id=$_GET['id'];
@unlink("..".GALFOLDER."/thumb/$slika");
@unlink("..".GALFOLDER."/$slika");
mysqli_query($conn, "UPDATE users_data SET civi$_GET[rb]  WHERE user_id=$id");
?>
