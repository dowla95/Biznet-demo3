<?php 
session_start();
include("Connections/conn.php");
if($_POST['tip']=="oglas" and $_SESSION['userid']>0)
{
@mysqli_query($conn, "DELETE FROM oglasi WHERE id=$_POST[id] LIMIT 1");
@mysqli_query($conn, "DELETE FROM oglas_grad WHERE oglas=$_POST[id]");
@mysqli_query($conn, "DELETE FROM prijave_na_oglas WHERE id_oglasa=$_POST[id]");
@mysqli_query($conn, "DELETE FROM prijave_na_oglas1 WHERE id_oglasa=$_POST[id]");
}
if($_POST['tip']=="kursevi" and $_SESSION['userid']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM ust_kursevi WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
@unlink("$page_path2/private/galerija/thumb/$upit1[slika1]");
@unlink("$page_path2/private/galerija/$upit1[slika1]");
@mysqli_query($conn, "DELETE FROM ust_kursevi WHERE id=$_POST[id] LIMIT 1");
}
if($_POST['tip']=="brisip" and $_SESSION['userid']>0){
 
$se=mysqli_query($conn, "SELECT * FROM kontakt WHERE id=".safe($_POST['id'])."");
$se1=mysqli_fetch_assoc($se);

mysqli_query($conn, "DELETE FROM kontakt WHERE id=".safe($_POST['id'])."");
mysqli_query($conn, "DELETE FROM kontakt WHERE id_por=".safe($_POST['id'])."");
}
?>