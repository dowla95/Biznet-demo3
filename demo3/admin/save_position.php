<?php 
include("../Connections/conn_admin.php");
 

 
foreach($_POST[sortid] as $id =>$i)
{
if($i>0)
{
if($_GET['table']=="stavke") $kolona="position"; else $kolona="pozicija";
mysqli_query($conn, "UPDATE $_GET[table] SET $kolona='$id' WHERE id=$i");
}
}
 
 
?>
