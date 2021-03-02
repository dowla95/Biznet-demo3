<?php 
session_start();
include("Connections/conn.php");

$us=mysqli_query($conn, "SELECT * FROM subscribers WHERE email=".safe($_POST[email])."");
$us1=mysqli_fetch_array($us);
if($_POST[control_4]==""  or $_POST[email]=="")
echo "Niste ispunili sva obavezna polja!";
else
if(mysqli_num_rows($us)==1 and $us1[akt]=="Y")
echo "Email je već u upotrebi!";
else
if (!mb_eregi("^[A-Z0-9._%-]+[@][A-Z0-9._%-]+[.][A-Z]{2,6}$", $_POST[email])) 
echo "Email adresa nije validna!";
else
{
$kat=implode(",",$_POST[control_4]);
$ip = $_SERVER['REMOTE_ADDR'];
if($_POST['nvesti']=="Y") $nvesti=", vesti='Y'"; else $nvesti="";
if($us1[akt]=="N")
mysqli_query($conn, "UPDATE subscribers SET   kategorije=".safe($kat).", ip='$ip', akt='Y' $nvesti WHERE id=$us1[id]");
elseif(!mb_eregi("cchbc.com",$_POST[email]) and !mb_eregi("co.yu",$_POST[email]))
mysqli_query($conn, "INSERT INTO subscribers SET  email =".safe(str_replace("nadlanu.com","open.telekom.rs",trim($_POST[email]))).",  kategorije=".safe($kat).", ip='$ip', time='".time()."', akt='Y' $nvesti");
echo "Vaš email je uspešno upisan!";
 
//echo "Izmmena nije izvršena!";
}
?>