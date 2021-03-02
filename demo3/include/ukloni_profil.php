<?php 
session_start();
include("../Connections/conn.php");
$zs=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid]");
$zs1=mysqli_fetch_assoc($zs);
if($zs1['user_id'])
{
for($i=1; $i<8; $i++)
{
unlink("$page_path2/private/galerija/".$zs1["civi$i"]."");
unlink("$page_path2/private/galerija/thumb/".$zs1["civi$i"]."");
}
mysqli_query($conn, "DELETE FROM users_data WHERE user_id=$_SESSION[userid]");
echo 0;
}
?>