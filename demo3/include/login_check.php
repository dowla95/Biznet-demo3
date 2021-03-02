<?php 
/// users login function
   function confirmUser($email, $password){
 global $conn;
   $resulta=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($email)." AND akt='Y'");   if(mysqli_num_rows($resulta)==0){
      return 1; //Pogresan email
   }
$dbarray = mysqli_fetch_array($resulta);
    $dbarray['password']  = stripslashes($dbarray['password']);
   $password = stripslashes($password);
$cek=tep_validate_password($password, $dbarray['password']);
   //if($password == $dbarray['password']){
   if($cek==1){
      return 0; //Uspesan login
   }
   else{
      return 2; //Pogresna Sifra
   }
}
function checkLogin(){
global $conn;
  if(isset($_COOKIE['ipcookname']) && isset($_COOKIE['ipcookpass'])){
    $_SESSION['email'] = $_COOKIE['ipcookname'];
    $_SESSION['password'] = $_COOKIE['ipcookpass'];    
   }
   if(isset($_SESSION['email']) && isset($_SESSION['password']) and mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users_data WHERE email='$_SESSION[email]'"))>0)
   {
    return true;
    }
    else
    {
         unset($_SESSION['email']);
         unset($_SESSION['password']);		 unset($_SESSION['userid']);		 unset($_SESSION['korisnik']);         return false;     } }if(isset($_POST['subloginer'])){   if(!$_POST['email'] || !$_POST['pass']){      $msl=$arrwords['niste_ispunili'];   }else{   $_POST['email'] = trim($_POST['email']);   //$md5pass = md5($_POST['pass']);   $md5pass = trim($_POST['pass']);   $result = confirmUser($_POST['email'], $md5pass);   if($result == 1){      $msl=$arrwords2['pogresni_podaci'];   }    else if($result == 2){      $msl=$arrwords2['pogresni_podaci'];   } else {   $_POST['email'] = stripslashes($_POST['email']);   $_SESSION['email'] = $_POST['email'];   $_SESSION['panel'] = $_POST['panel'];   $_SESSION['password'] = tep_encrypt_password($md5pass);    $qi = "select * from users_data where email = '".$_SESSION['email']."'";   $resulti = mysqli_query($conn, $qi);   $dbarrayi = mysqli_fetch_assoc($resulti);   $_SESSION['userid'] = $dbarrayi['user_id'];      $_SESSION['username'] = $dbarrayi['nickname'];   $_SESSION['fb_if'] = 0;  if($dbarrayi['tip']==1)   $_SESSION['korisnik'] =  $dbarrayi['ime']." ".$dbarrayi['prezime'];   else   $_SESSION['korisnik'] =  $dbarrayi['nickname'];   //mysqli_query($conn, "UPDATE users SET updatecode='Y' WHERE user_id='$dbarrayi[user_id]'",$conn);   setcookie("ipcookname", $_SESSION['email'], time()+60*60*24*100, "/");   /*   Opcija zapamti me    */   if(isset($_POST['remember'])){      setcookie("ipcookname", $_SESSION['email'], time()+60*60*24*100, "/");      setcookie("ipcookpass", $_SESSION['password'], time()+60*60*24*100, "/");	  setcookie("ipcookid", $_SESSION['userid'], time()+60*60*24*100, "/");   }if (isset($HTTP_SERVER_VARS['QUERY_STRING'])) {  $qqq .= "?" . $HTTP_SERVER_VARS['QUERY_STRING'];}   /* Zastita od ponovnog slanja podataka */// mysqli_query($conn, "UPDATE users SET last_login ='".$newtime."' WHERE user_id=".safe($_SESSION['userid'])."");if(mb_eregi("amount",curPageURL()))header("Location: ".curPageURL());elseif(isset($_SESSION['forredi']) and $_SESSION['forredi']!="" and mb_eregi("chat.php",curPageURL())  and mb_eregi("chat.php",$_SESSION['forredi']))header("location:". $_SESSION['forredi']);elseif(isset($_SESSION['forredi']) and $_SESSION['forredi']!="" and !mb_eregi("chat.php",$_SESSION['forredi']))header("location:". $_SESSION['forredi']);else header("Location: $patH1/");   }   }}/* podesavanje logged_in promenljive */if(!preg_match("/admin/",curPageURL()))$logged_in = checkLogin();function check_users(){global $conn, $logged_in;if($logged_in){   $qa = "select tip from users_data where email = '".$_SESSION['email']."'";    $resultadmin = mysqli_query($conn, $qa);   $addb = mysqli_fetch_assoc($resultadmin);    return $addb['tip'];	}}if(!preg_match("/admin/",curPageURL()))$ustip = check_users();?>