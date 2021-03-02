<?php 
session_start();
include("../Connections/conn.php");
include("Izvrsenja.php");
if($_POST['tip']=="kursevi" and $_SESSION['userid']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM ust_kursevi WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt1']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE ust_kursevi SET akt1=$akti WHERE id=$_POST[id]");
}
if($_POST['tip']=="oglasi" and $_SESSION['userid']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM oglasi WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt1']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE oglasi SET akt1=$akti WHERE id=$_POST[id]");
}
if($_POST['tip']=="oglasik" and $_SESSION['userid']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM oglasi_kandidati WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt1']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE oglasi_kandidati SET akt1=$akti WHERE id=$_POST[id]");
}
if($_POST['tip']=="oglasi_konurisanje" and $_SESSION['userid']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM oglasi WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt2']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE oglasi SET akt2=$akti WHERE id=$_POST[id]");
}
if(($_POST['tip']=="prijave_na_oglas" or $_POST['tip']=="prijave_na_oglas1") and $_SESSION['userid']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM $_POST[tip] WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['izdvojeno']==1) $akti=0; else $akti=1;  echo $akti;
mysqli_query($conn, "UPDATE $_POST[tip] SET izdvojeno=$akti WHERE id=$_POST[id]");
}
if($_POST['tip']=="sacuvaj_cv" and $_SESSION['userid']>0)
{
$upit=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM sacuvane_biografije WHERE id_kand=$_POST[id] AND id_posl=$_SESSION[userid]"));
if($upit==0)
mysqli_query($conn, "INSERT INTO sacuvane_biografije SET id_kand=$_POST[id], id_posl=$_SESSION[userid], datum='".date("Y-m-d")."'");
else
mysqli_query($conn, "DELETE FROM sacuvane_biografije WHERE id_kand=$_POST[id] AND id_posl=$_SESSION[userid]");
}
if($_POST'tip']=="omoguci_odgovore_kandidata_naprijavu" and $_SESSION['userid']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM prijave_na_oglas WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['omoguci_kandidatu']==1) $akti=0; else $akti=1;  echo $akti;
mysqli_query($conn, "UPDATE prijave_na_oglas SET omoguci_kandidatu=$akti WHERE id=$_POST[id]");
}
?>