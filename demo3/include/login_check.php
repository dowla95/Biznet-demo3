<?php 
/// users login function
   function confirmUser($email, $password){
 global $conn;
   $resulta=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($email)." AND akt='Y'");
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
         unset($_SESSION['password']);