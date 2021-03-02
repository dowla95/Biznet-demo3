<?php 
session_start();
$sid=session_id();
include("Connections/conn.php");
//if(!$_SESSION[$sid]){
//echo $_GET[vote];
$sum =  mysqli_query($conn, "SELECT * FROM votes WHERE  id_upisa=".safe($_GET['idupisa'])." AND id_page=".safe($_GET['idpage'])."");
$sum1=mysqli_fetch_array($sum);
$br_glasa=$sum1['br_glasa']+1;
$zbir=$sum1['zbir']+$_GET['vote'];

$sum1=mysqli_fetch_array($sum);
if(mysqli_num_rows($sum)==0 and $_GET['vote']>0)
{
mysqli_query($conn, "INSERT INTO votes SET id_upisa=".safe($_GET['idupisa']).", id_page=".safe($_GET['idpage']).", br_glasa='$br_glasa', zbir='$zbir'");
}elseif($_GET['vote']>0)
{  
mysqli_query($conn, "UPDATE votes SET  br_glasa='$br_glasa', zbir='$zbir' WHERE id_upisa=".safe($_GET['idupisa'])." AND id_page=".safe($_GET['idpage'])."");
}
/*} else
{
echo "Već ste ocenili tekst!";
}*/
$pros=ceil($zbir/$br_glasa);
echo "Trenutna ocena: ".$pros;
?>