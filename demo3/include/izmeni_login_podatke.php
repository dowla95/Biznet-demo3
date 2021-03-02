<?php 
session_start();
include("Connections/conn.php"); 
$as=mysqli_query($conn, "SELECT * FROM users WHERE  user_id=".safe($_SESSION[userid])."");
$as1=mysqli_fetch_array($as);
$cs=mysqli_query($conn, "SELECT * FROM users WHERE username=".safe($_POST[username])." AND NOT user_id=".safe($_SESSION[userid])."");
$us=mysqli_query($conn, "SELECT * FROM users WHERE email=".safe($_POST[email])." AND NOT user_id=".safe($_SESSION[userid])."");
if($_POST[username]=="" or $_POST[pass1]==""  or $_POST[email]=="")
echo "Niste ispunili sva obavezna polja!";
else
if(mysqli_num_rows($cs)==1)
echo "Korisničko ime je već u upotrebi!";
else
if(mysqli_num_rows($us)==1)
echo "Email je već u upotrebi!";
else
if (!mb_eregi("^[A-Z0-9._%-]+[@][A-Z0-9._%-]+[.][A-Z]{2,6}$", $_POST[email])) 
echo "Email adresa nije validna!";
else
if(tep_validate_password(trim($_POST[pass1]), $as1[password])!=1)
echo "Stara lozinka nije odgovarajuća!" ;
else
if($_POST[pass2]!="" and strlen($_POST[pass2])<6)
echo "Nova lozinka mora imati najmanje 6 karaktera!";
else
{ 
if($_POST[pass2]!="")
$pass2=", password='".tep_encrypt_password($_POST[pass2])."'";
@mysqli_query($conn, "UPDATE subscribers_poslodavci SET email=".safe($_POST[emails])."  WHERE user_id=".safe($_SESSION[userid])."");
if(mysqli_query($conn, "UPDATE users SET username =".safe($_POST[username]).", email =".safe($_POST[email])." $pass2 WHERE user_id=".safe($_SESSION[userid]).""))
echo "Izmena je uspešno izvršena!";
else
echo mysqli_error(); 
//echo "Izmmena nije izvršena!";
}



?>
