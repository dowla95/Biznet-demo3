<?php 
session_start(); 
include('Connections/conn.php');
/**
 * Delete cookies - the time must be in the past,
 * so just negate what you added when creating the
 * cookie.
 */
if(isset($_COOKIE['ipcookname']) && isset($_COOKIE['ipcookpass'])){
   //setcookie("ipcookname", "", time()-60*60*24*100, "/");
   setcookie("ipcookpass", "", time()-60*60*24*100, "/");
}
   /* Kill session variables */
   unset($_SESSION['email']);
   unset($_SESSION['password']);
   unset($_SESSION['userid']);
   unset($_SESSION['fb_if']);
   unset($_SESSION['nameda']);
   unset($_SESSION['emailda']);
   session_destroy();   // destroy session.
   
    header("Location: ./"); 
 //echo "<h1>Logged Out</h1>\n";
 //echo "Uspesno ste se <b>izlogovali</b>. Vratite se <a href=\"log.php\">log</a>";

?>
</body>
</html>