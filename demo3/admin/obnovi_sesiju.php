<?php 
session_start();
include("../Connections/conn_admin.php");

$qi = mysqli_query($conn, "select * from users_admin where user_id = '".$_SESSION['userids']."'");
 $tabela="adrese_poslodavci";

   $dbarrayi = mysqli_fetch_assoc($qi);
 

   $_SESSION['emails'] = $dbarrayi['email'];   
   $_SESSION['passwords'] = $dbarrayi['password']; 
   $_SESSION['userids'] = $dbarrayi['user_id'];
  $_SESSION['korisniks'] = $dbarrayi['name']." ".$dbarrayi['surname'];
   echo $_SESSION['password'];
  /* echo $_SESSION['userid'];
   echo"<br>";
   echo $_SESSION['email'];
   echo"<br>";
   echo $_SESSION['password'];
   echo"<br>";
   echo $_SESSION['korisnik'];
   echo"<br>";
   echo $_SESSION['panel'];
   */

?>
