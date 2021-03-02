<?php 
session_start(); 
include("../Connections/conn_admin.php");
$patHA=$patH."/admin";
/**
 * Delete cookies - the time must be in the past,
 * so just negate what you added when creating the
 * cookie.
 */
if(isset($_COOKIE['ipcooknames']) && isset($_COOKIE['ipcookpass'])){
   setcookie("ipcooknames", "", time()-60*60*24*100, "/");
   setcookie("ipcookpasss", "", time()-60*60*24*100, "/");
   setcookie("ipcookids", "", time()-60*60*24*100, "/");
   setcookie("ipkorisniks", "", time()-60*60*24*100, "/");
}

//mysqli_query($conn, "UPDATE users SET updatecode='N' WHERE user_id='$_SESSION[userid]'");
   /* Kill session variables */
   unset($_SESSION['emails']);
   unset($_SESSION['passwords']);
  
   unset($_SESSION['korisniks']);
   unset($_SESSION['userids']);
   
   session_destroy();   // destroy session.
  
header("Location: $patHA"); 
 

?>


