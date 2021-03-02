<?php 
include("../Connections/conn_admin.php");
 
$exp=explode(",",$_POST['ide']);
 
foreach($exp as $id =>$i)
{
if($i>0)
{
 $kolona="position"; 
mysqli_query($conn, "UPDATE $_POST[table] SET $kolona='$id' WHERE id=$i");
}
}
 
 
?>
