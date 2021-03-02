<?php 
session_start();
include("Connections/conn.php");
$po=mysqli_query($conn, "SELECT * FROM users  WHERE email=".safe($_POST['email'])."");
if(mysqli_num_rows($po)>0) 
echo "false";
else 
echo "true";
?>
