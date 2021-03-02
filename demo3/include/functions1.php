<?php 
 function curPageURL() {
 $pageURL = 'https';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
function meta_tags_new($title, $desc, $key)
{
$vrati .=PHP_EOL.'<title>'.strip_tags($title).'</title>'.PHP_EOL.'
<meta name="description" content="'.strip_tags($desc).'" />'.PHP_EOL.'
<meta name="Keywords" content="'.strip_tags($key).'" />'.PHP_EOL.'';
return $vrati;
}
function confirmUsers($email, $password){
 
   $resulta=mysqli_query($conn, "SELECT * FROM users_admin WHERE email=".safe($email)." AND akt='Y'");
   if(mysqli_num_rows($resulta)==0){
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
 
 
function checkLogins(){
global $conn;
 
  if(isset($_COOKIE['ipcooknames']) && isset($_COOKIE['ipcookpasss'])){
    $_SESSION['emails'] = $_COOKIE['ipcookname'];
    $_SESSION['passwords'] = $_COOKIE['ipcookpasss'];    
   }
   if(isset($_SESSION['emails']) && isset($_SESSION['passwords']) and mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users_admin WHERE email='$_SESSION[emails]'"))>0)
   {
   
    return true;
    }
    else
    {
         unset($_SESSION['emails']);
         unset($_SESSION['passwords']);
		 unset($_SESSION['userids']);
		 unset($_SESSION['korisniks']);
         return false;
  
     } 
  
}

if(isset($_POST['sublogins'])){

   if(!$_POST['email'] || !$_POST['pass']){
      $msls=$langa['logins7'];
      
   }else{

   $_POST['email'] = trim($_POST['email']);
   

   //$md5pass = md5($_POST['pass']);
   $md5pass = trim($_POST['pass']);
   
   $result = confirmUsers($_POST['email'], $md5pass);


   if($result == 1){
      $msls=$langa['logins8'];

   } 
   else if($result == 2){
      $msls=$langa['logins8'];
   } else {

   $_POST['emails'] = stripslashes($_POST['email']);
   $_SESSION['emails'] = $_POST['email'];
   $_SESSION['panels'] = $_POST['panel'];
   $_SESSION['passwords'] = tep_encrypt_password($md5pass); 
   $resulti = mysqli_query($conn, "select * from users_admin where email = '".$_SESSION['emails']."'");   
   $dbarrayi = mysqli_fetch_assoc($resulti);
   $_SESSION['userids'] = $dbarrayi['user_id'];
   $_SESSION['korisniks'] = $dbarrayi['name']." ".$dbarrayi['surname'];
   
   
   if(isset($_POST['remember'])){
      setcookie("ipcooknames", $_SESSION['emails'], time()+60*60*24*100, "/");
    setcookie("ipcookpasss", $_SESSION['passwords'], time()+60*60*24*100, "/");
	  setcookie("ipcookids", $_SESSION['userids'], time()+60*60*24*100, "/");
   }
 

 
 echo header("Location: $patH/admin/index.php");
  

   }
   }
}
 
/* podesavanje logged_in promenljive */
if(preg_match("/admin/",curPageURL()))
 $logged_ins = checkLogins();
 
function check_admins(){
global $logged_ins;
if($logged_ins){
   $qa = "select active from users_admin where email = '".$_SESSION['emails']."'";
    $resultadmin = mysqli_query($conn, $qa);
   $addb = mysqli_fetch_assoc($resultadmin);
  
    return $addb['active'];

	}
}
if(preg_match("/admin/",curPageURL()))
$admins = check_admins();

/// users login function
   function confirmUser($email, $password){
 
   $resulta=mysqli_query($conn, "SELECT * FROM users WHERE email=".safe($email)." AND akt='Y'");
   if(mysqli_num_rows($resulta)==0){
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
   if(isset($_SESSION['email']) && isset($_SESSION['password']) and mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users WHERE email='$_SESSION[email]'"))>0)
   {
   
    return true;
    }
    else
    {
         unset($_SESSION['email']);
         unset($_SESSION['password']);
		 unset($_SESSION['userid']);
		 unset($_SESSION['korisnik']);
         return false;
  
     } 
  
}

if(isset($_POST['sublogin'])){

   if(!$_POST['email'] || !$_POST['pass']){
      $msl=$langa['logins7'];
      
   }else{

   $_POST['email'] = trim($_POST['email']);
   

   //$md5pass = md5($_POST['pass']);
   $md5pass = trim($_POST['pass']);
   
   $result = confirmUser($_POST['email'], $md5pass);


   if($result == 1){
      $msl=$langa['logins8'];

   } 
   else if($result == 2){
      $msl=$langa['logins8'];
   } else {

   $_POST['email'] = stripslashes($_POST['email']);
   $_SESSION['email'] = $_POST['email'];
   $_SESSION['panel'] = $_POST['panel'];
   $_SESSION['password'] = tep_encrypt_password($md5pass); 
   $qi = "select * from users where email = '".$_SESSION['email']."'";
   $resulti = mysqli_query($conn, $qi,$conn);
   $dbarrayi = mysqli_fetch_assoc($resulti);
   $_SESSION['userid'] = $dbarrayi['user_id'];
   $_SESSION['username'] = $dbarrayi['username'];
   $_SESSION['fb_if'] = 0;
  $ni = mysqli_query($conn, "select * from adrese where id_user = '".$dbarrayi['user_id']."'"); $ni1=mysqli_fetch_array($ni);
   $_SESSION['korisnik'] = $ni1['name'];
   //mysqli_query($conn, "UPDATE users SET updatecode='Y' WHERE user_id='$dbarrayi[user_id]'",$conn);
   setcookie("ipcookname", $_SESSION['email'], time()+60*60*24*100, "/");
   /*
   Opcija zapamti me
    */
   if(isset($_POST['remember'])){
      setcookie("ipcookname", $_SESSION['email'], time()+60*60*24*100, "/");
      setcookie("ipcookpass", $_SESSION['password'], time()+60*60*24*100, "/");
	  setcookie("ipcookid", $_SESSION['userid'], time()+60*60*24*100, "/");
   }
   
if (isset($HTTP_SERVER_VARS['QUERY_STRING'])) {
  $qqq .= "?" . $HTTP_SERVER_VARS['QUERY_STRING'];
}
   /* Zastita od ponovnog slanja podataka */
   
 mysqli_query($conn, "UPDATE users SET last_login ='".$newtime."' WHERE user_id=".safe($_SESSION['userid'])."");
  if($dbarrayi['agencija']==1)
  echo header("Location: $patH1/korisnik/vasi-oglasi/");
  

   }
   }
}

/* podesavanje logged_in promenljive */
if(!preg_match("/admin/",curPageURL()))
$logged_in = checkLogin();
 
function check_admin(){
global $conn, $logged_in;
if($logged_in){
   $qa = "select active from users where email = '".$_SESSION['email']."'";
    $resultadmin = mysqli_query($conn, $qa,$conn);
   $addb = mysqli_fetch_assoc($resultadmin);
  
    return $addb['active'];

	}
}
if(!preg_match("/admin/",curPageURL()))
$admin = check_admin();


function message($msl)
{
global $msl;
return $msl;
}
function cmsniz($cmsniz)
{
global $cmsniz;
return $cmsniz;
}

function page_path($page_path2)
{
global $page_path2;
return $page_path2;
}

function pat($path)
{
global $path;
return $path;
}
function lang($lang)
{
global $lang;
return $lang;
}
function idpage($idpage)
{
global $idpage;
return $idpage;
}
function apat($patH)
{
global $patH;
return $patH;
}
function apat1($patH1)
{
global $patH1;
return $patH1;
}
function page($page)
{
global $page;
return $page;
}
function alt($alt)
{
global $alt;
return $alt;
}
function replace_day($c)
{
$d=str_replace("Sun","Ponedeljak",$c);

    $d=str_replace("Mon","Utorak",$d);

    $d=str_replace("Tue","Sreda",$d);

    $d=str_replace("Wed","Cetvrtak",$d);

    $d=str_replace("Thu","Petak",$d);

    $d=str_replace("Fri","Subota",$d);

    $d=str_replace("Sat","Nedelja",$d); 
return $d;
}
function replace($all){
$nid_pr=str_replace("Ć","C",$all);
$nid_pr=str_replace("ć","c",$nid_pr);
$nid_pr=str_replace("Č","C",$nid_pr);
$nid_pr=str_replace("č","c",$nid_pr);
$nid_pr=str_replace("Š","S",$nid_pr);
$nid_pr=str_replace("š","s",$nid_pr);
$nid_pr=str_replace("ž","z",$nid_pr);
$nid_pr=str_replace("Ž","Z",$nid_pr);
$nid_pr=str_replace("đ","dj",$nid_pr);
$nid_pr=str_replace("Đ","Dj",$nid_pr);
$nid_pr=preg_replace("/[[:punct:]]/","",$nid_pr);
$nid_pr1=strtolower($nid_pr);
$nid_pr2=trim($nid_pr1);
return $nid_pr2;
}
function replaceR($all){
$nid_pr=str_replace("Ć","C",$all);
$nid_pr=str_replace("ć","c",$nid_pr);
$nid_pr=str_replace("Č","C",$nid_pr);
$nid_pr=str_replace("č","c",$nid_pr);
$nid_pr=str_replace("Š","S",$nid_pr);
$nid_pr=str_replace("š","s",$nid_pr);
$nid_pr=str_replace("ž","z",$nid_pr);
$nid_pr=str_replace("Ž","Z",$nid_pr);
$nid_pr=str_replace("đ","dj",$nid_pr);
$nid_pr=str_replace("Đ","Dj",$nid_pr);
$nid_pr=preg_replace("/[[:punct:]]/","",$nid_pr);
$nid_pr2=trim($nid_pr);
return $nid_pr2;
}
function replace_implode($all){
$nid_pr=str_replace("Ć","C",$all);
$nid_pr=str_replace("ć","c",$nid_pr);
$nid_pr=str_replace("Č","C",$nid_pr);
$nid_pr=str_replace("č","c",$nid_pr);
$nid_pr=str_replace("Š","S",$nid_pr);
$nid_pr=str_replace("š","s",$nid_pr);
$nid_pr=str_replace("ž","z",$nid_pr);
$nid_pr=str_replace("Ž","Z",$nid_pr);
$nid_pr=str_replace("đ","dj",$nid_pr);
$nid_pr=str_replace("Đ","Dj",$nid_pr);
$nid_pr=preg_replace("/[[:punct:]]/","",$nid_pr);
$nid_pr1=strtolower($nid_pr);
$nid_pr2=implode("_",explode(" ",trim($nid_pr1)));

return $nid_pr2;
}
function replace_implode1($all){
$nid_pr=str_replace("Ć","C",$all);
$nid_pr=str_replace("ć","c",$nid_pr);
$nid_pr=str_replace("Č","C",$nid_pr);
$nid_pr=str_replace("č","c",$nid_pr);
$nid_pr=str_replace("Š","S",$nid_pr);
$nid_pr=str_replace("š","s",$nid_pr);
$nid_pr=str_replace("ž","z",$nid_pr);
$nid_pr=str_replace("Ž","Z",$nid_pr);
$nid_pr=str_replace("đ","dj",$nid_pr);
$nid_pr=str_replace("Đ","Dj",$nid_pr);

$nid_pr=str_replace('"','',$nid_pr);
$nid_pr=str_replace("'","",$nid_pr);
$nid_pr=str_replace("?","",$nid_pr);
$nid_pr=str_replace("!","",$nid_pr);
$nid_pr=str_replace("(","_",$nid_pr);
$nid_pr=str_replace(")","_",$nid_pr);
$nid_pr=str_replace("€","evra",$nid_pr);
//$nid_pr=str_replace(".","",$nid_pr);
$nid_pr=str_replace(":","",$nid_pr);
$nid_pr=str_replace(";","",$nid_pr);
$nid_pr=str_replace("/","",$nid_pr);
$nid_pr=str_replace("&","",$nid_pr);
$nid_pr=preg_replace("/[[:punct:]]/","",$nid_pr);
$nid_pr1=strtolower($nid_pr);
 
$nid_pr2=implode("-",explode(" ",trim($nid_pr1)));

return $nid_pr2;
}
function replace_implode2($all){
$nid_pr=str_replace("Ć","C",$all);
$nid_pr=str_replace("ć","c",$nid_pr);
$nid_pr=str_replace("Č","C",$nid_pr);
$nid_pr=str_replace("č","c",$nid_pr);
$nid_pr=str_replace("Š","S",$nid_pr);
$nid_pr=str_replace("š","s",$nid_pr);
$nid_pr=str_replace("ž","z",$nid_pr);
$nid_pr=str_replace("Ž","Z",$nid_pr);
$nid_pr=str_replace("đ","dj",$nid_pr);
$nid_pr=str_replace("Đ","Dj",$nid_pr);
$nid_pr=str_replace('"','',$nid_pr);
$nid_pr=str_replace("'","",$nid_pr);
$nid_pr=str_replace("?","",$nid_pr);
$nid_pr=str_replace("!","",$nid_pr);
$nid_pr=str_replace(".","",$nid_pr);
$nid_pr=str_replace(":","",$nid_pr);
$nid_pr=str_replace(";","",$nid_pr);
$nid_pr=str_replace("/","",$nid_pr);
$nid_pr=preg_replace("/[[:punct:]]/","",$nid_pr);
$nid_pr1=strtolower($nid_pr);
$nid_pr2=implode("-",explode(" ",trim($nid_pr1)));

return $nid_pr2;
}
function replace1($all){
$nid_pr=str_replace("Ć","C",$all);
$nid_pr=str_replace("ć","c",$nid_pr);
$nid_pr=str_replace("Č","C",$nid_pr);
$nid_pr=str_replace("č","c",$nid_pr);
$nid_pr=str_replace("Š","S",$nid_pr);
$nid_pr=str_replace("š","s",$nid_pr);
$nid_pr=str_replace("ž","z",$nid_pr);
$nid_pr=str_replace("Ž","Z",$nid_pr);
$nid_pr=str_replace("đ","dj",$nid_pr);
$nid_pr=str_replace("Đ","Dj",$nid_pr);
$nid_pr=preg_replace("/[[:punct:]]/","",$nid_pr);
$nid_pr2=trim($nid_pr);
return $nid_pr2;
}

function replacem($all){
$nid_pr=str_replace("Ć","C",$all);
$nid_pr=str_replace("ć","c",$nid_pr);
$nid_pr=str_replace("Č","C",$nid_pr);
$nid_pr=str_replace("č","c",$nid_pr);
$nid_pr=str_replace("Š","S",$nid_pr);
$nid_pr=str_replace("š","s",$nid_pr);
$nid_pr=str_replace("ž","z",$nid_pr);
$nid_pr=str_replace("Ž","Z",$nid_pr);
$nid_pr=str_replace("đ","dj",$nid_pr);
$nid_pr=str_replace("Đ","Dj",$nid_pr);
//$nid_pr=preg_replace("/[[:punct:]]/","",$nid_pr);
$nid_pr2=trim($nid_pr);
return $nid_pr2;
}

function replace2($all){
$nid_pr=str_replace("Ć","C",$all);
$nid_pr=str_replace("ć","c",$nid_pr);
$nid_pr=str_replace("Č","C",$nid_pr);
$nid_pr=str_replace("č","c",$nid_pr);
$nid_pr=str_replace("Š","S",$nid_pr);
$nid_pr=str_replace("š","s",$nid_pr);
$nid_pr=str_replace("ž","z",$nid_pr);
$nid_pr=str_replace("Ž","Z",$nid_pr);
$nid_pr=str_replace("đ","dj",$nid_pr);
$nid_pr=str_replace("Đ","Dj",$nid_pr);
$nid_pr=str_replace('"','',$nid_pr);
$nid_pr=str_replace("'","",$nid_pr);
$nid_pr=str_replace("?","",$nid_pr);
$nid_pr=str_replace("!","",$nid_pr);
$nid_pr=str_replace("(","_",$nid_pr);
$nid_pr=str_replace(")","_",$nid_pr);
//$nid_pr=str_replace(".","",$nid_pr);
$nid_pr=str_replace(":","",$nid_pr);
$nid_pr=str_replace(";","",$nid_pr);
$nid_pr=str_replace("/","",$nid_pr);
$nid_pr=str_replace("&","",$nid_pr);
return $nid_pr;
}

function addslash($theValue){
 $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
 return $theValue;
 }
function safed($str, $using_like=false) { 
    if( get_magic_quotes_gpc() )  // if already escaped 
            $str = stripslashes($str); 
    $str = mysqli_real_escape_string($str); 

    return ( $using_like? addcslashes($str, '%_') : $str ); 
}  
 function safe($value) {
  if (get_magic_quotes_gpc()) //dali je magic quptes ukljucen
     $value = stripslashes($value); //ako je, ponisti sta je napravio
  if (is_string($value)) //dali nije numericka vrjednost (dali je string?)
    $value = "'" . mysqli_real_escape_string($value) . "'"; //ako je string, escapaj ga kako spada
  return $value;
}

/*
function flash($path1,$fajl,$wid,$heig)
{
echo "<object style='visibility: visible;z-index:-1000;'  type='application/x-shockwave-flash' data='$path1/$fajl' width='$wid' height='$heig'>

<param name='movie' value='$path1/$fajl' />
  <param name='quality' value='high' />
  <param name='wmode' value='transparent' />
</object> 
";
}*/
################ RAND ##################
function gen_rand_string($ime)
{
	/*$chars = array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w',  'x', 'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
	
	$max_chars = count($chars) - 1;
	srand( (double) microtime()*1000000);
	
	$rand_str = '';
	for($i = 0; $i < 5; $i++)
	{
		$rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
	}*/
	$rand_str=date("d-m-Y-H-i-s",time());
$rep=str_replace(".jpg","",$ime);
$rep=str_replace(".JPG","",$rep);
$rep=str_replace(".JPEG","",$rep);
$rep=str_replace(".jpeg","",$rep);
$rep=str_replace(".gif","",$rep);
$rep=str_replace(".GIF","",$rep);
$rep=str_replace(".png","",$rep);
$rep=str_replace(".PNG","",$rep);
$rep=str_replace(".swf","",$rep);
$rep=str_replace(".SWF","",$rep);
$rep=str_replace(".doc","",$rep);
$rep=str_replace(".DOC","",$rep);
$rep=str_replace(".pdf","",$rep);
$rep=str_replace(".PDF","",$rep);
	return $rand_str."-".$rep;
}
function gen_rand()
{
	$chars = array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w',  'x', 'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
	
	$max_chars = count($chars) - 1;
	srand( (double) microtime()*1000000);
	
	$rand_str = '';
	for($i = 0; $i < 15; $i++)
	{
		$rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
	}
	return $rand_str;
}
############################### UPLOAD IMAGE ##############
function UploadSlika($imesl,$tmp_name,$ext,$lokacija) {

$slika2="";
$exti=explode('.', $imesl);
$ext= ".".end($exti);
/*$ext = str_replace("image/pjpeg",".jpg", $ext);
$ext = str_replace("image/jpeg",".jpg", $ext);
$ext = str_replace("image/gif",".gif", $ext);
$ext = str_replace("image/png",".png", $ext);
$ext = str_replace("image/bmp",".bmp", $ext);
$ext = str_replace("image/tiff",".tiff", $ext);

$ext = str_replace("application/x-shockwave-flash",".swf", $ext);
$ext = str_replace("application/pdf",".pdf", $ext);
$ext = str_replace("application/doc",".doc", $ext);
$ext = str_replace("application/docx",".docx", $ext);
$ext = str_replace("application/vnd.openxmlformats-officedocument.wordprocessingml.document",".docx", $ext);
$ext = str_replace("application/msword",".doc", $ext);
$ext = str_replace("application/zip",".zip", $ext);
$ext = str_replace("file/doc",".doc", $ext);
$ext = str_replace("file/docx",".docx", $ext);
$ext = str_replace("file/ocx",".docx", $ext);
$ext = str_replace("file/pdf",".pdf", $ext);
$ext = str_replace("binary/octet-stream",".doc", $ext);
$ext = str_replace("application/octet-stream",".doc", $ext);
$ext = str_replace("application/vnd.oasis.opendocument.text",".odt", $ext);
$ext = str_replace("application/vnd.oasis.opendocument.spreadsheet",".ods", $ext);
$ext = str_replace("application/rtf",".rtf", $ext);
$ext = str_replace("application/vnd.ms-powerpoint",".ppt", $ext);*/
$imesl=str_replace(" ","_",$imesl);
$imesl=str_replace("&","_",$imesl);
$imesl=str_replace($ext,"",$imesl);

$slika2 = gen_rand_string(replace2($imesl)).$ext;

$uploadfile = $lokacija.$slika2;
copy($tmp_name, $uploadfile);
if(mb_eregi("galerija",$lokacija) or mb_eregi("apartmani_beograd",$lokacija)  or mb_eregi("apartmani_beograd",$lokacija))
resize($slika2,$lokacija);
resize_check($slika2,$lokacija);
//resizerv($slika2,$fold);
chmod($uploadfile, 0644);

return $slika2;

}

########################## RESIZE IMAGE create thumb ###################
function resize($slika,$folder){
$image = "$folder$slika";//ovo je slika koju ces da resajzujes
//$newHeight = '200';//u pixelima postavim visinu i sirinu
$kvalitet = '95';

$size = GetImageSize($image);//u pixelima uzima stvarnu visinu i sirinu slike
$width = $size[0];
$height = $size[1];

$imgratio=$width/$height;
$wid=200;
$heig=130;
if($width>$height){
$wd=$width/$height;
$newWidth=$wid;
$newHeight=$wid/$wd;
}elseif($width<=$height){
$hd=$height/$width;
$newHeight=$heig;
$newWidth=$heig/$hd;
}
$x = 0;//ovde u pixelima stavi odakle da krene sa crop-ovanjem
$y = 0;

//ako je slika gif onda ovako, ako je jpg onda ImageCreateFromJpg a ako je png ImageCreateFromPng
$exti=explode('.', $image);
$exstension=end($exti);
 if($exstension == "jpeg" || $exstension == "jpg" || $exstension == "JPG" || $exstension == "JPEG"){
               $src = imagecreatefromjpeg($image);
           }elseif($exstension == "x-png" || $exstension == "png"  || $exstension == "PNG"){
               $src = imagecreatefrompng($image);
           }elseif($exstension == "gif" || $exstension == "GIF"){
               $src = imagecreatefromgif($image);
           }

 
$tmb = ImageCreateTrueColor($newWidth,$newHeight);//pravi praznu lsiku sa zadatim velicinama
//// eliminisanje pozadine PNG slike///
if($exstension == "x-png" || $exstension == "png"  || $exstension == "PNG"){
imagealphablending($tmb, false);
imagesavealpha($tmb,true);
$transparent = imagecolorallocatealpha($tmb, 255, 255, 255, 127);
imagefilledrectangle($tmb, 0, 0, $newWidth, $newHeight, $transparent);
}
//////////
ImageCopyresampled($tmb, $src, 0, 0, $x, $y, $newWidth, $newHeight, $width, $height);
//opet menjaj u zavisnosti kakva je slika u pitanju (gif,jpg,png)



$destJpeg=$folder."thumb/$slika";
if($exstension == "jpg" || $exstension == "JPG" || $exstension == "JPEG" || $exstension == "jpeg")
imageJpeg($tmb, $destJpeg,$kvalitet);
elseif($exstension == "gif" || $exstension == "GIF")
imageGif($tmb, $destJpeg,$kvalitet);
elseif($exstension == "png" || $exstension == "PNG")
imagePng($tmb, $destJpeg,5);  
ImageDestroy($src);
ImageDestroy($tmb);

}

########################## RESIZE IMAGE ako je veca od 800px ###################
function resize_check($slika,$folder){
$image = "$folder$slika";//ovo je slika koju ces da resajzujes
//$newHeight = '200';//u pixelima postavim visinu i sirinu
$kvalitet = '95';

$size = GetImageSize($image);//u pixelima uzima stvarnu visinu i sirinu slike
$width = $size[0];
$height = $size[1];
 
if($width>800 or $height>800)
{
$imgratio=$width/$height;
$wid=800;
$heig=800;
if($width>$height){
$wd=$width/$height;
$newWidth=$wid;
$newHeight=$wid/$wd;
}elseif($width<=$height){
$hd=$height/$width;
$newHeight=$heig;
$newWidth=$heig/$hd;
}
$x = 0;//ovde u pixelima stavi odakle da krene sa crop-ovanjem
$y = 0;

//ako je slika gif onda ovako, ako je jpg onda ImageCreateFromJpg a ako je png ImageCreateFromPng
$exti=explode('.', $image);
$exstension=end($exti); 
 if($exstension == "jpeg" || $exstension == "jpg" || $exstension == "JPG"){
               $src = imagecreatefromjpeg($image);
           }elseif($exstension == "x-png" || $exstension == "png"  || $exstension == "PNG"){
               $src = imagecreatefrompng($image);
           }elseif($exstension == "gif" || $exstension == "GIF"){
               $src = imagecreatefromgif($image);
           }


$tmb = ImageCreateTrueColor($newWidth,$newHeight);//pravi praznu lsiku sa zadatim velicinama
//// eliminisanje pozadine PNG slike///
if($exstension == "x-png" || $exstension == "png"){
imagealphablending($tmb, false);
imagesavealpha($tmb,true);
$transparent = imagecolorallocatealpha($tmb, 255, 255, 255, 127);
imagefilledrectangle($tmb, 0, 0, $newWidth, $newHeight, $transparent);
}
//////////
ImageCopyresampled($tmb, $src, 0, 0, $x, $y, $newWidth, $newHeight, $width, $height);
//opet menjaj u zavisnosti kakva je slika u pitanju (gif,jpg,png)

unlink($folder."$slika");

$destJpeg=$folder."$slika";
if($exstension == "jpg" || $exstension == "JPG" || $exstension == "JPEG" || $exstension == "jpeg")
imageJpeg($tmb, $destJpeg,$kvalitet);
elseif($exstension == "gif" || $exstension == "GIF")
imageGif($tmb, $destJpeg,$kvalitet);
elseif($exstension == "png" || $exstension == "PNG")
imagePng($tmb, $destJpeg,5);  
ImageDestroy($src);
ImageDestroy($tmb);
}
}

function resizerv($slika,$folder){
$image = "$folder$slika";//ovo je slika koju ces da resajzujes
//$newHeight = '200';//u pixelima postavim visinu i sirinu

$kvalitet = '85';
$size = GetImageSize($image);//u pixelima uzima stvarnu visinu i sirinu slike
$width = $size[0];
$height = $size[1];
if($width>1000 or $height>800){
$imgratio=$width/$height;
$wid=1000;
$heig=800;
if($width>$height){
$wd=$width/$height;
$newWidth=$wid;
$newHeight=$wid/$wd;
}elseif($width<=$height){
$hd=$height/$width;
$newHeight=$heig;
$newWidth=$heig/$hd;
}
$x = 0;//ovde u pixelima stavi odakle da krene sa crop-ovanjem
$y = 0;

//ako je slika gif onda ovako, ako je jpg onda ImageCreateFromJpg a ako je png ImageCreateFromPng
$exti=explode('.', $image);
$exstension=end($exti); 
  if($exstension == "jpeg" || $exstension == "jpg" || $exstension == "JPG"){
               $src = imagecreatefromjpeg($image);
           }elseif($exstension == "x-png" || $exstension == "png"  || $exstension == "PNG"){
               $src = imagecreatefrompng($image);
           }elseif($exstension == "gif" || $exstension == "GIF"){
               $src = imagecreatefromgif($image);
           }



$tmb = ImageCreateTrueColor($newWidth,$newHeight);//pravi praznu lsiku sa zadatim velicinama

ImageCopyresampled($tmb, $src, 0, 0, $x, $y, $newWidth, $newHeight, $width, $height);
//opet menjaj u zavisnosti kakva je slika u pitanju (gif,jpg,png)


unlink($folder."$slika");
$destJpeg=$folder."$slika";
if($exstension == "jpg" || $exstension == "JPG" || $exstension == "JPEG" || $exstension == "jpeg")
imageJpeg($tmb, $destJpeg,$kvalitet);
elseif($exstension == "gif" || $exstension == "GIF")
imageGif($tmb, $destJpeg,$kvalitet);
elseif($exstension == "png" || $exstension == "PNG")
imagePng($tmb, $destJpeg,$kvalitet); 
ImageDestroy($src);
ImageDestroy($tmb);
}
}
################### for page site ###################
function opis($duz,$opis,$id,$fajl,$podrob){
$patH=apat($patH);
$path1=pat($path1);

echo "<div class='opis'>";
if($duz>1){
$op=strip_tags(stripslashes($opis));
echo substr($op,0,$duz)."...";
echo "<div class='link'>
<a href='$path1/$fajl?id=$id'>$podrob</a>
</div>";
}else{
$opis=str_replace("IMG", "img alt='digitalni_print'", $opis);
$opis=str_replace("<P>", "<p>", $opis);
$opis=str_replace("</P>", "</p>", $opis);
$opis=str_replace("<ul>", "<ul>", $opis);
$opis=str_replace("</ul>", "</ul>", $opis);
$opis=str_replace("<LI>", "<li>", $opis);
$opis=str_replace("</LI>", "</li>", $opis);
$opis=str_replace("<BR>", "<br />", $opis);
$opis=str_replace("<br>", "<br />", $opis);
$opis=str_replace("<STRONG>", "<strong>", $opis);
$opis=str_replace("</STRONG>", "</strong>", $opis);
//$opis=str_replace("size=\"1\"","style=\"font-size:10px;\"",$opis);
//$opis=str_replace("size=\"2\"","style=\"font-size:11px;\"",$opis);
//$opis=str_replace("size=1","style=\"font-size:10px;\"",$opis);
//$opis=str_replace("size=2","style=\"font-size:11px;\"",$opis);
//$opis=str_replace("size=3","style=\"font-size:11px;\"",$opis);
/*$opis=str_replace("face=\"Times New Roman\"","",$opis);
//$opis=str_replace("align=middle","align=center",$opis);
$opis=str_replace("src=\"../../../../","src=\"$patH/",$opis);
$opis=str_replace("src=\"../../","src=\"$patH/",$opis);
$opis=str_replace("src=\"../","src=\"$patH/",$opis);
$opis=str_replace("id=\"_mcePaste\"","",$opis);*/
$opis=str_replace("&lt;","<",$opis);
$opis=str_replace("&gt;",">",$opis);

echo stripslashes($opis);
}
echo "</div>";
}
function opis1($duz,$opis,$id,$fajl,$podrob){
$patH=apat($patH);
$path1=pat($path1);
echo "<div class='opis1'>";
if($duz>1){
$op=strip_tags(stripslashes($opis));
echo substr($op,0,$duz)."...";
echo "<div class='link'>
<a href='$path1/$fajl/$id/'>$podrob</a>
</div>";
}else{
$opis=str_replace("IMG", "img alt='digitalni_print'", $opis);
$opis=str_replace("<P>", "<p>", $opis);
$opis=str_replace("</P>", "</p>", $opis);
$opis=str_replace("<ul>", "<ul>", $opis);
$opis=str_replace("</ul>", "</ul>", $opis);
$opis=str_replace("<LI>", "<li>", $opis);
$opis=str_replace("</LI>", "</li>", $opis);
$opis=str_replace("<BR>", "<br />", $opis);
$opis=str_replace("<STRONG>", "<strong>", $opis);
$opis=str_replace("</STRONG>", "</strong>", $opis);
$opis=str_replace("size=\"1\"","style=\"font-size:10px;\"",$opis);
$opis=str_replace("size=\"2\"","style=\"font-size:11px;\"",$opis);
$opis=str_replace("size=1","style=\"font-size:10px;\"",$opis);
$opis=str_replace("size=2","style=\"font-size:11px;\"",$opis);
$opis=str_replace("size=3","style=\"font-size:11px;\"",$opis);
$opis=str_replace("face=\"Times New Roman\"","",$opis);
$opis=str_replace("<img ","<img class='magnify' ",$opis);
$opis=str_replace("align=middle","align=center",$opis);
$opis=str_replace("align=center","style='text-align:center;'",$opis);


echo stripslashes($opis);
}
echo "</div>";
}
function opis2($duz,$opis,$id,$fajl,$podrob){
$patH=apat($patH);
echo "<div class='opis2'>";
if($duz>1){
$op=strip_tags(stripslashes($opis));
echo substr($op,0,$duz)."...";
echo "<div class='link'>
<a href='$patH/$fajl?id=$id'>$podrob</a>
</div>";
}else{
$opis=str_replace("IMG", "img alt='digitalni_print'", $opis);
$opis=str_replace("<P>", "<p>", $opis);
$opis=str_replace("</P>", "</p>", $opis);
$opis=str_replace("<ul>", "<ul>", $opis);
$opis=str_replace("</ul>", "</ul>", $opis);
$opis=str_replace("<LI>", "<li>", $opis);
$opis=str_replace("</LI>", "</li>", $opis);
$opis=str_replace("<BR>", "<br />", $opis);
$opis=str_replace("<STRONG>", "<strong>", $opis);
$opis=str_replace("</STRONG>", "</strong>", $opis);
$opis=str_replace("size=\"1\"","style=\"font-size:10px;\"",$opis);
$opis=str_replace("size=\"2\"","style=\"font-size:11px;\"",$opis);
$opis=str_replace("size=1","style=\"font-size:10px;\"",$opis);
$opis=str_replace("size=2","style=\"font-size:11px;\"",$opis);
echo stripslashes($opis);
}
echo "</div>";
}
function opis3($duz,$opis,$id,$fajl,$podrob){
$patH=apat($patH);
$path1=pat($path1);

echo "<div class='opis1'>";
if($duz>1){
$op=strip_tags(stripslashes($opis));
echo substr($op,0,$duz)."...";
echo "<div class='link'>
<a href='$path1/$fajl/$id/'>$podrob</a>
</div>";
}else{
$opis=str_replace("IMG", "img alt='digitalni_print'", $opis);
$opis=str_replace("<P>", "<p>", $opis);
$opis=str_replace("</P>", "</p>", $opis);
$opis=str_replace("<ul>", "<ul>", $opis);
$opis=str_replace("</ul>", "</ul>", $opis);
$opis=str_replace("<LI>", "<li>", $opis);
$opis=str_replace("</LI>", "</li>", $opis);
$opis=str_replace("<BR>", "<br />", $opis);
$opis=str_replace("<STRONG>", "<strong>", $opis);
$opis=str_replace("</STRONG>", "</strong>", $opis);
$opis=str_replace("size=\"1\"","style=\"font-size:10px;\"",$opis);
$opis=str_replace("size=\"2\"","style=\"font-size:11px;\"",$opis);
$opis=str_replace("size=1","style=\"font-size:10px;\"",$opis);
$opis=str_replace("size=2","style=\"font-size:11px;\"",$opis);
$opis=str_replace("size=3","style=\"font-size:11px;\"",$opis);
$opis=str_replace("face=\"Times New Roman\"","",$opis);
$opis=str_replace("align=middle","align=center",$opis);
return stripslashes($opis);
}
echo "</div>";
}
/////////// convert DATE ////////////
function datum($datum)
        {
        $exp=explode("-",$datum);
        $exp_rev=array_reverse($exp);
        $imp=implode(".",$exp_rev);
        return $imp.".";
        }
function datumr($datum)
 {
        $exp=explode("-",$datum);
        $exp_rev=array_reverse($exp);
        $imp=implode("-",$exp_rev);
        return $imp;
}
//////////////////// return idpage //////////////
function idpages($strana,$lang)
{
$pp=mysqli_query($conn, "SELECT * FROM page WHERE file='$strana' AND jezik='$lang'");
$pp1=mysqli_fetch_array($pp);
return $pp1[id_grupe];
}
function read_files($kol,$i,$idpage,$patH,$page_path2)
{
global $lang;
$pp=mysqli_query($conn, "SELECT * FROM files_paintb WHERE idstrane='$i' AND id_page=$idpage AND akt='Y'");
while(@$pp1=mysqli_fetch_array($pp)){

$nast=explode("<>",$pp1[naslov]);
$ss=mysqli_query($conn, "SELECT * FROM page WHERE id_grupe=$idpage");
$ss1=mysqli_fetch_array($ss);
$vez=array_search($lang,explode("<><>",$ss1[jezik]));
if(substr($pp1['opis'],-3)=="pdf") $tip="pdf.gif";
if(substr($pp1['opis'],-3)=="xls") $tip="xls.gif";
if(substr($pp1['opis'],-3)=="doc") $tip="word.jpg";
if(substr($pp1['opis'],-3)=="zip") $tip="pdf.gif";
if(file_exists("$page_path2/private/files/".$pp1['opis'].""))
$size=ceil(filesize("$page_path2/private/files/".$pp1['opis']."")/1024);
if($size>0 and strlen($pp1['opis'])>0){
echo "<table style='float:left;width:50%;' class='files'> 
<tr ><td style='width:30px;'><img src='".$patH."/images/$tip' alt='' /></td><td><a href='".$patH."/download.php?fold=fi&down=".$pp1['opis']."'  style='font-weight:bold;'>
&raquo; $nast[$vez]  ( $size Kb)
</a></td></tr></table>";
}
}
}
function read_galery($id,$idp,$wi,$he,$ur)
{
$patH=apat($patH);
$path1=pat($path1);
$lang=lang($lang);
$page_path2=page_path($page_path2)."/private";
if(empty($wi)) $wid=90; else $wid=$wi;
if(empty($he)) $heig=80; else $heig=$he;
if($id)
$im=mysqli_query($conn, "SELECT * FROM galerija WHERE katid='$id'  AND akt='Y' AND id_page='$idp' ORDER BY pozicija, id ASC");
else
$im=mysqli_query($conn, "SELECT * FROM galerija WHERE id_page='$idp' AND akt='Y' ORDER BY pozicija, id ASC");
$l=0;
while($p1=mysqli_fetch_array($im))
{
$sl="slika1";
$b=$l%$ur;
if($b==0 and $l>0)
echo "<div style='float:left;width:100%;height:4px;'></div>";
if(strlen($p1[$sl])>3){

$pic=$page_path2."/private/galerija/$p1[slika1]";
$size = GetImageSize($pic);
$width  = $size[0];
$height = $size[1];
if($width>$height){
$wd=$width/$height;
$width1=$wid;
$height1=$wid/$wd;
}elseif($width<=$height){
$hd=$height/$width;
$height1=$heig;
$width1=$heig/$hd;
}
if(empty($p1[naslov])) $title="Cvetlicarna GARDENIA"; else $title="$p1[naslov]";
echo "<div style='float:left;'><div style='margin-left:5px;margin-top:10px;'>
<a href='$patH/galerija/$p1[$sl]'  class='pirobox_gall' title='$title'><img src='$patH/galerija/thumb/$p1[$sl]' width='$width1' height='$height1' style='border:1px solid #fff;'  alt='paintball club' /></a></div></div>";
}
$l++;
}
}
//////////////////// read images///////////
function read_images($id,$idp,$kol,$wi,$he,$title)
{
$patH=apat($patH);
$path1=pat($path1);
$lang=lang($lang);
$page_path2=page_path($page_path2)."/private";
if(empty($wi)) $wid=90; else $wid=$wi;
if(empty($he)) $heig=80; else $heig=$he;
$im=mysqli_query($conn, "SELECT * FROM slike_paintb WHERE $kol='$id' AND akt='Y' AND id_page='$idp' ORDER BY pozicija, id ASC");
$l=0;
$num=mysqli_num_rows($im);
while($p1=mysqli_fetch_array($im))
{
$sl="slika";
$b=$l%3;
if($b==0 and $l>0)
echo "<div style='float:left;width:100%;height:4px;'></div>";
if(strlen($p1[$sl])>3){

$pic=$page_path2."/private/galerija/$p1[slika]";
$size = GetImageSize($pic);
$width  = $size[0];
$height = $size[1];
if($width>$height){
$wd=$width/$height;
$width1=$wid;
$height1=$wid/$wd;
}elseif($width<=$height){
$hd=$height/$width;
$height1=$heig;
$width1=$heig/$hd;
}
/*echo "<div style='float:left;'><div style='margin-left:5px;margin-top:10px;'>
<a href='$patH/galerija/$p1[$sl]' rel='lightbox[slide]' title='paintball club airsoft'><img src='$patH/galerija/thumb/$p1[$sl]' width='$width1' height='$height1' style='border:1px solid #99999;'  alt='paintball club' /></a></div></div>";*/
if($num==1) $pi="pirobox"; else $pi="pirobox_gall";
echo "<div style='float:left;'><div style='margin-left:5px;margin-top:10px;'>
<a href='$patH/galerija/$p1[$sl]'   class=\"highslide\" onclick=\"return hs.expand(this)\" title='$title' ><img src='$patH/galerija/thumb/$p1[$sl]' width='$width1' height='$height1' style='border:1px solid #111;'  alt='paintball club' /></a></div></div>";
}
$l++;
}
}
function read_images1($id,$idp,$kol,$bruredu,$wi,$he)
{
$patH=apat($patH);
$path1=pat($path1);
$lang=lang($lang);
if(empty($wi)) $wid=74; else $wid=$wi;
if(empty($he)) $heig=50; else $heig=$he;
$im=mysqli_query($conn, "SELECT * FROM slike_paintb WHERE $kol='$id' AND id_page='$idp' ORDER BY pozicija, id ASC");
$i=1;
$widd=$wid+10;
$widd1=$wid+2;
while($p1=mysqli_fetch_array($im))
{
$b=$i%$bruredu;

?>
<div style='float:left;width:<?php echo $widd?>px;text-align:center;font-size:1px;'>
<div style='border:1px solid #999;width:<?php echo $widd1?>px;'>
<?php 
if(strlen($p1[slika])>3){
$page_path2=page_path($page_path2)."/private";
$pic=$page_path2."/galerija/$p1[slika]";
//$pic="galerija/$p1[slika]";
$size = GetImageSize($pic);
$width  = $size[0];
$height = $size[1];
if($width>$height){
$wd=$width/$height;
$width1=$wid;
$height1=$wid/$wd;
}elseif($width<=$height){
$hd=$height/$width;
$height1=$heig;
$width1=$heig/$hd;
}

//echo "<a href='$patH/galerija/$p1[slika]'  rel='lightbox[slide]' alt='airsoft paintball club'>";
echo "<a href='$patH/galerija/$p1[slika]' rel='thumbnail'><img src='$patH/galerija/$p1[slika]' width='$width1' height='$height1' alt='paintbal club airsoft' title='paintbal airsoft club'  class='magnify' /></a>";
}
?>
</div>
</div>
<?php 
if($b==0) 
echo "<div style='width:100%;height:10px;float:left;font-size:1px;'>&nbsp;</div>";
$i++;
}
}
function image_size($wid,$heig,$slika){
global $page_path2;
if(is_file("$page_path2/private/$slika"))
{
$size = GetImageSize("$page_path2/private/$slika"); 
$width = $size[0];
$height = $size[1];

$odnos_wh=$width/$height;
if($odnos_wh>=1)
{
$width=$wid;
$height=$width/$odnos_wh;
if($height>$heig)
{
$height=$heig;
$width=$odnos_wh*$height;
}

}
else
{

$height=$heig;
$width=$height*$odnos_wh;

}
return array($width, $height);
 }
}
 
function image_size2($wid,$heig,$slika,$fold){
$patH=apat($patH);
$page_path2=page_path($page_path2);

if(strlen($slika)>2 and file_exists($page_path2."/$fold/$slika")){
$pic=$page_path2."/$fold/$slika";
$size = GetImageSize($pic);
$width  = $size[0];
$height = $size[1];

if($heig>0){
if($width>$height){
$wd=$width/$height;
$height1=$heig;
$width1=$wd*$height1;
}elseif($width<=$height){
$hd=$height/$width;
$height1=$heig;
$width1=$heig/$hd;
}
return $width1."-".$height1;
 }elseif($width>0){
if($width>$height){
$wd=$width/$height;
$width1=$wid;
$height1=$width1/$wd;
}elseif($width<=$height){
$hd=$height/$width;
$width1=$wid;
$height1=$width1*$hd;
}
return $width1."-".$height1;
 }
 }
}
function image_size3($wid,$heig,$slika,$fold){

$page_path2=page_path($page_path2)."/private";

$pic="$page_path2/$fold/$slika";
if(strlen($slika)>0  and file_exists($pic)){

$size = GetImageSize($pic);
$width  = $size[0];
$height = $size[1];
if($heig>0){
if($height>$width){
$hd=$height/$width;
$width1=$heig/$hd;
$height1=$heig;
}
if($height<$width){
$hd=$width/$height;
$width1=$heig*$hd;
$height1=$heig;
}
return $width1."-".$heig;
 }elseif($wid>0){
if($height>=$width){
$hd=$height/$width;
if($height>=150){

$width1=150/$hd;
$height1=150;

}else{

$width1=$wid;
$height1=$wid*$hd;
}
}
if($height<$width){
$hd=$width/$height;
$width1=$wid;
$height1=$wid/$hd;
}
return $width1."-".$height1;
 }
}
}
function image_size33($wid,$heig,$slika,$fold){


$pic="$fold/$slika";
if(strlen($slika)>0  and file_exists("$fold/$slika")){

$size = GetImageSize($pic);
$width  = $size[0];
$height = $size[1];
if($heig>0){
if($height>$width){
$hd=$height/$width;
$width1=$heig/$hd;
$height1=$heig;
}
if($height<$width){
$hd=$width/$height;
$width1=$heig*$hd;
$height1=$heig;
}
return $width1."-".$heig;
 }elseif($wid>0){
if($height>=$width){
$hd=$height/$width;
if($height>=80){

$width1=80/$hd;
$height1=80;

}else{

$width1=$wid;
$height1=$wid*$hd;
}
}
if($height<$width){
$hd=$width/$height;
$width1=$wid;
$height1=$wid/$hd;
}
return $width1."-".$height1;
 }
}
}
function ukupno_art($nd){
$ku=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id_parent='$nd'");

  while($ku1=mysqli_fetch_array($ku)){
$nn2 .=", ".$ku1['id'];
$num=mysqli_query($conn, "SELECT * FROM proizvodi_new WHERE katid = '$ku1[id]'");
$num1=mysqli_num_rows($num);
$nums .=",".$num1;

//////// ispis podkategorija /////////
//echo $ku1[ime];
$kd=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id_parent='$ku1[id]'");
$br1 =mysqli_num_rows($kd);
  while($kd1=mysqli_fetch_array($kd)){
// echo $kd1['id']."--";
 $nn3 .=", ".$kd1['id'];
 $num=mysqli_query($conn, "SELECT * FROM proizvodi_new WHERE katid='$kd1[id]'");
$numi1 =mysqli_num_rows($num);
 
//echo "--".$numi1;
$numi11 .=", ".$numi1;

  }
  } 
  $numg=mysqli_query($conn, "SELECT * FROM proizvodi_new WHERE katid='$nd'");
$numg1 =mysqli_num_rows($numg);
$nums_exp=explode(",",$nums);
$nums_exp1=explode(",",$numi11);
$num1=array_sum($nums_exp);
$vuv=array_sum($nums_exp1);
echo $vuv+$num1+$numg1;
} 

function find($nn1,$v,$v1,$v2){

  global $nn;
  global $num2;
  
$ku=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id_parent='$nn1'");

  while($ku1=mysqli_fetch_array($ku)){
  
 
$nn2 .=", ".$ku1['id'];
$num=mysqli_query($conn, "SELECT * FROM proizvodi_new WHERE katid = '$ku1[id]'");
$num1=mysqli_num_rows($num);
//////// ispis podkategorija /////////
//echo $ku1[ime];
$kd=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id_parent='$ku1[id]'");
$br1 =mysqli_num_rows($kd);
  while($kd1=mysqli_fetch_array($kd)){
// echo $kd1['id']."--";
 $nn3 .=", ".$kd1['id'];
 $num=mysqli_query($conn, "SELECT * FROM proizvodi_new WHERE katid='$kd1[id]'");
$numi1 =mysqli_num_rows($num);
//echo "--".$numi1;
$numi11 .=", ".$numi1;
$vuv +=$numi1;
  }
//echo $vuv;
  $numi111=explode(", ",$numi11);
  
  array_shift($numi111);
  $numi111=array_reverse($numi111);
   $nuv=array_slice($numi111,0,$br1);
 $gg= array_sum($nuv);

  $num2=$num1+$gg;
 
 if($v2==1 and $nn1>0)
 {
 echo "<option  style='color:black;font-weight:normal;' $su value=$ku1['id']>$ku1[ime] ($num2)</option>";
 } 
if($v==1){ 
echo "<div style='float:left;width:50%;'>";
echo "
<img src='images/B2.jpg'>
<a href=$PHP_SELF?id_kat=$ku1['id'] class='link11'>$ku1[ime]</a> <span style='font-size:11px;color:#999;'>($num2)</span>";
echo "</div>";
}

  }

  if($v1==1){
  $nn=$nn1.$nn2.$nn3;
  return $nn;
  }
  }
  
  ##################### PORUDZBINE @##############
 function toma()
{

}



  function poruceno($poruceno,$nnt,$cene,$ddv,$jezik,$nacin_placanja){
//$cmsniz=cmsniz($cmsniz);
//$nacin_placanja= nacin($nacin_placanja);
global $niz;

  
$exa=explode(",",$poruceno);
$ce=explode(",",$cene);
$send= "<table style='width:670px;'>";
if($jezik) $tab=$jezik."_proizvodi_new"; else $tab="proizvodi_new";
for($g=0; $g<count($exa); $g++)
{
$nim=explode("-",$exa[$g]);
$cec=explode("-",$ce[$g]);
$key=$nim[0];
$val=$nim[1];
$kor=mysqli_query($conn, "SELECT * FROM $tab WHERE id='$key'");
$kor1=mysqli_fetch_array($kor);
//$num=mysqli_num_rows($kor);
//if($admin==1 or $admin==2)
 $cc=$cec[1];
  //elseif($admin==0) $cc=$kor1[cena]+($kor1[cena]*(30/100));                      
//$vrzapr=$cc*$val;
//if($admin==0) $cc=$kor1[cena];
//elseif($admin==1) $cc=$kor1[cena1];                                

$cc1=sprintf("%4.2f",$cc);
$cc2=number_format ($cc1, 2, ",", ".");
$sddv1=sprintf("%4.2f",($cc1+($cc1*($ddv/100))));
$sddv2=number_format ($sddv1, 2, ",", ".");
$ubrez=$cc1*$val;
$ubrez1=number_format ($ubrez, 2, ",", ".");

$uzddv=$sddv1*$val;

  $uzddv1=number_format ($uzddv, 2, ",", ".");
  $val1=explode("-",$val);
$send .= "<tr>
<td><a href='$PHP_SELF?idpro=$kor1['id']' class='reg2' style='color:white;'>".stripslashes($kor1[naslov])."</a></td>
<td>$cc2 </td>
<td>";
$send .= "<form method=post action='$PHP_SELF?izmeni=izmeni&prikazi=$_GET[prikazi]' style='margin:0px;'>";
$send .= "<input type='text' name='kolicina' value='$val' size='1' style='font-size:9px;margin:0px;'>
<input type='hidden' name='kol' value='$val'>
<input type='hidden' name='tabela' value='$_GET[tabela]'>
<input type='hidden' name='vred' value='$key'>
";
$send .= "</form>";
$send .= "</td>
<td align='right'>$ubrez1 </td>
</tr>";
$ukupno+=$ubrez;
$ukupno1+=$uzddv;

}
 $ukupno=number_format ($ukupno, 2, ",", ".");
  $ukupno1=number_format ($ukupno1, 2, ",", ".");
//$ukupno1=$ukupno+($ukupno*($ddv/100));
//$ukupno=str_replace(".",",",sprintf("%4.2f",$ukupno)) ;

//$ukupno1=str_replace(".",",",sprintf("%4.2f",$ukupno1)) ;
$send .= "<tr><td colspan='5'>&nbsp;</td></tr>";
$send .= "<tr style='font-size:13px;font-weight:bold;background:#f1f1f1;height:20px;'><td colspan='2'>".$niz[kupovina][8]."</td><td></td>
<td align='right' colspan='3'>
<div style='width:100%;text-align:right;float:left;'>
<span style='font-weight:bold;font-size:13px;'>$ukupno $din</span></div>
</td>
</tr>";
$send .= "<tr><td colspan='5' style='padding-bottom:10px;'>
<strong>Način plaćanja:</strong> ";
 
 $send .= $nacin_placanja[$nnt];
 
$send .= "</td></tr>";
$send .= "</table>";
return $send;
}


 function poruceno1($poruceno,$nnt,$cene,$ddv,$jezik,$nacin_placanja){
//$cmsniz=cmsniz($cmsniz);
//$nacin_placanja= nacin($nacin_placanja);
global $niz;

  
$exa=explode(",",$poruceno);
$ce=explode(",",$cene);
$send= "<table style='width:520px;'>";
if($jezik) $tab=$jezik."_proizvodi_new"; else $tab="proizvodi_new";
for($g=0; $g<count($exa); $g++)
{
$nim=explode("-",$exa[$g]);
$cec=explode("-",$ce[$g]);
$key=$nim[0];
$val=$nim[1];
$kor=mysqli_query($conn, "SELECT * FROM $tab WHERE id='$key'");
$kor1=mysqli_fetch_array($kor);
//$num=mysqli_num_rows($kor);
//if($admin==1 or $admin==2)
 $cc=$cec[1];
  //elseif($admin==0) $cc=$kor1[cena]+($kor1[cena]*(30/100));                      
//$vrzapr=$cc*$val;
//if($admin==0) $cc=$kor1[cena];
//elseif($admin==1) $cc=$kor1[cena1];                                

$cc1=sprintf("%4.2f",$cc);
$cc2=number_format ($cc1, 2, ",", ".");
$sddv1=sprintf("%4.2f",($cc1+($cc1*($ddv/100))));
$sddv2=number_format ($sddv1, 2, ",", ".");
$ubrez=$cc1*$val;
$ubrez1=number_format ($ubrez, 2, ",", ".");

$uzddv=$sddv1*$val;

  $uzddv1=number_format ($uzddv, 2, ",", ".");
  $val1=explode("-",$val);
$send .= "<tr>
<td><span style='color:red;'>".stripslashes($kor1[naslov])."</span></td>
<td>$cc2 </td>
<td>";
$send .= "<form method=post action='$PHP_SELF?izmeni=izmeni&prikazi=$_GET[prikazi]' style='margin:0px;'>";
$send .= "<input type='text' name='kolicina' value='$val' size='1' style='font-size:9px;margin:0px;'>
<input type='hidden' name='kol' value='$val'>
<input type='hidden' name='tabela' value='$_GET[tabela]'>
<input type='hidden' name='vred' value='$key'>
";
$send .= "</form>";
$send .= "</td>
<td align='right'>$ubrez1 </td>
</tr>";
$ukupno+=$ubrez;
$ukupno1+=$uzddv;

}
 $ukupno=number_format ($ukupno, 2, ",", ".");
  $ukupno1=number_format ($ukupno1, 2, ",", ".");
//$ukupno1=$ukupno+($ukupno*($ddv/100));
//$ukupno=str_replace(".",",",sprintf("%4.2f",$ukupno)) ;

//$ukupno1=str_replace(".",",",sprintf("%4.2f",$ukupno1)) ;
$send .= "<tr><td colspan='5'>&nbsp;</td></tr>";
$send .= "<tr style='font-size:13px;font-weight:bold;background:#f1f1f1;height:20px;'><td colspan='2'>".$niz[kupovina][8]."</td><td></td>
<td align='right' colspan='3'>
<span style='font-weight:bold;font-size:13px;'>$ukupno $din</span>
</td>
</tr>";
$send .= "<tr><td colspan='5' style='padding-bottom:10px;'>
<strong>Način plaćanja:</strong> ";
 
 $send .= $nacin_placanja[$nnt];
 
$send .= "</td></tr>";
$send .= "</table>";
return $send;
}

function ukupno_upisa($kateg, $tabela, $tabela_upisa, $kolona, $plus="")
{
$niz=array();
$niz[]=$kateg;
$ar=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent=$kateg");
while($ar1=mysqli_fetch_array($ar))
{
$niz[]=$ar1['id'];
$ars=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent=$ar1[id]");
while($ars1=mysqli_fetch_array($ars))
{
$niz[]=$ars1['id'];
$arss=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent=$ars1[id]");
while($arss1=mysqli_fetch_array($arss))
{
$niz[]=$arss1['id'];
$arsss=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent=$arss1[id]");
while($arsss1=mysqli_fetch_array($arsss))
{
$niz[]=$arsss1['id'];
}
}
}
}
$nizt=implode(",",$niz);

$ukupno=mysqli_num_rows(mysqli_query($conn, "SELECT $kolona FROM $tabela_upisa WHERE $kolona IN($nizt) $plus AND akt='Y'"));
return  $ukupno;
}
function kategorije_firme($kateg, $tabela)
{

$niz=array();
$niz[]=$kateg;
$ar=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent=$kateg");
while($ar1=mysqli_fetch_array($ar))
{
$niz[]=$ar1['id'];
$ars=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent=$ar1[id]");
while($ars1=mysqli_fetch_array($ars))
{
$niz[]=$ars1['id'];
$arss=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent=$ars1[id]");
while($arss1=mysqli_fetch_array($arss))
{
$niz[]=$arss1['id'];
$arsss=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent=$arss1[id]");
while($arsss1=mysqli_fetch_array($arsss))
{
$niz[]=$arsss1['id'];
}
}
}
}
$nizt=implode(",",$niz);
return $nizt;
}
function back_category($kateg, $tabela)
{
$niz=array();
$ar=mysqli_query($conn, "SELECT * FROM $tabela WHERE id=$kateg");
$ar1=mysqli_fetch_array($ar);
//$niz[0]=$kateg;
$niz[1]=$ar1[ime];
if($ar1[id_parent]>0)
{
$zr=mysqli_query($conn, "SELECT * FROM $tabela WHERE id=$ar1[id_parent]");
$zr1=mysqli_fetch_array($zr);
$niz[2]=$zr1[ime];
}
if($zr1[id_parent]>0)
{
$cr=mysqli_query($conn, "SELECT * FROM $tabela WHERE id=$zr1[id_parent]");
$cr1=mysqli_fetch_array($cr);
$niz[3]=$cr1[ime];
}
$fir_kateg=array_reverse($niz);
$fkateg=implode(" &raquo; ", $fir_kateg)." &raquo;";
/*foreach($fir_kateg as $key => $val)
{

$fkateg[]=$fir_kateg[$key];
}*/
return $fkateg;
}
function kategorije1($idkat,$tabela)
{



$sa=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent='$idkat'");
$c=0;
while($sa1=mysqli_fetch_array($sa)){
if($c==0) $za=""; else $za=",";
$in .="$za".$sa1['id'];
$sg=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent='$sa1[id]'");
while($sg1=mysqli_fetch_array($sg)){
$in .=",".$sg1['id'];
$st=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_parent='$sg1[id]'");
while($sg1=mysqli_fetch_array($st)){
$in .=",".$st1['id'];
}
}
$c++;
}
if(empty($in)) $za=""; else $za=",";
return $idkat."$za".$in;
}
function kategorije2($idkat)
{

$ss=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$idkat'");
$ss1=mysqli_fetch_array($ss);
$ins=$ss1['id'];

$sa=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$ss1[id_parent]'");
while($sa1=mysqli_fetch_array($sa)){
$ins .=",".$sa1['id'];
$sg=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$sa1[id_parent]'");
while($sg1=mysqli_fetch_array($sg)){
$ins .=",".$sg1['id'];
$st=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$sg1[id_parent]'");
while($sg1=mysqli_fetch_array($st)){
$ins .=",".$st1['id'];
}
}
}
return $ins;
}

function kategorije3($idkat,$patH)
{
$sa=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$idkat'");
$sa1=mysqli_fetch_array($sa);
if($sa1[nivo]==1)
$insa= "<a href='$patH/proizvodi/$sa1[ime1]__$sa1['id']/' class='sc1'>$sa1[ime]</a>&raquo; ";
elseif($sa1[nivo]==2)
{
$sg=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$sa1[id_parent]'");
$sg1=mysqli_fetch_array($sg);
$insa= "<a href='$patH/proizvodi/$sg1[ime1]__$sg1['id']/' class='sc1'>$sg1[ime]</a>&raquo; <a href='$patH/proizvodi/$sg1[ime1]__$sg1['id']/$sa1[ime1]__$sa1['id']/' class='sc1'>$sa1[ime]</a>&raquo; ";
}
elseif($sa1[nivo]==3)
{
$sg=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$sa1[id_parent]'");
$sg1=mysqli_fetch_array($sg);
$sb=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$sg1[id_parent]'");
$sb1=mysqli_fetch_array($sb);
$insa= "<a href='$patH/proizvodi/$sb1[ime1]__$sb1['id']/' class='sc1'>$sb1[ime]</a>&raquo; <a href='$patH/proizvodi/$sb1[ime1]__$sb1['id']/$sg1[ime1]__$sg1['id']/' class='sc1'>$sg1[ime]</a>&raquo; <a href='$patH/proizvodi/$sb1[ime1]__$sb1['id']/$sg1[ime1]__$sg1['id']/$sa1[ime1]__$sa1['id']/' class='sc1'>$sa1[ime]</a>&raquo; ";
}


return $insa;
}
function kategorije4($idkat)
{
$sa=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$idkat'");
$sa1=mysqli_fetch_array($sa);
if($sa1[nivo]==1)
$insak= " $sa1[ime] ";
elseif($sa1[nivo]==2)
{
$sg=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$sa1[id_parent]'");
$sg1=mysqli_fetch_array($sg);
$insak= " $sg1[ime], $sa1[ime], ";
}
elseif($sa1[nivo]==3)
{
$sg=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$sa1[id_parent]'");
$sg1=mysqli_fetch_array($sg);
$sb=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id='$sg1[id_parent]'");
$sb1=mysqli_fetch_array($sb);
$insak= " $sb1[ime], $sg1[ime], $sa1[ime], ";
}


return $insak;
}
function format_ceneS($cc)
{
$cc1=sprintf("%4.2f",$cc);
$cc2=number_format ($cc1, 2, ".", ".");
return $cc2;
}
############### CENE format ###############
function format_cenec($id)
{

$cc=$id;                              
$cc1=sprintf("%4.2f",$cc);
$cc2=number_format ($cc1, 2, ",", ".");
$sddv1=sprintf("%4.2f",($cc1+($cc1*($ddv/100))));
$sddv2=number_format ($sddv1, 2, ",", ".");
//$ubrez=$cc1;
//$ubrez1=number_format ($ubrez, 2, ",", ".");
$uzddv=$sddv1;
$uzddv1=number_format ($uzddv, 2, ",", ".");
return $uzddv1;
}

function format_cene($cena1,$cena,$ddv)
{
//$kor=mysqli_query($conn, "SELECT * FROM proizvodi_new WHERE id='$id'");
//$kor1=mysqli_fetch_array($kor);

if($cena1>0){
 
$cc=$cena1;
$cc1=sprintf("%4.2f",$cc);
$cc2=number_format ($cc1, 2, ",", ".");
$sddv1=sprintf("%4.2f",($cc1+($cc1*($ddv/100))));
$sddv2=number_format ($sddv1, 2, ",", ".");
//$ubrez=$cc1;
//$ubrez1=number_format ($ubrez, 2, ",", ".");
$uzddv=$sddv1;
$uzddvA1=number_format ($uzddv, 2, ",", ".");
}else $uzddvA1=0;

$cc=$cena;                              
$cc1=sprintf("%4.2f",$cc);
$cc2=number_format ($cc1, 2, ",", ".");
$sddv1=sprintf("%4.2f",($cc1+($cc1*($ddv/100))));
$sddv2=number_format ($sddv1, 2, ",", ".");
//$ubrez=$cc1;
//$ubrez1=number_format ($ubrez, 2, ",", ".");
$uzddv=$sddv1;
$uzddv1=number_format ($uzddv, 2, ",", ".");
return $uzddv1."-".$uzddvA1;
}





 function tep_rand($min = null, $max = null) {
    static $seeded;

    if (!$seeded) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }
   function tep_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if ( (is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }
  
  function tep_validate_password($plain, $encrypted) {
    if (tep_not_null($plain) && tep_not_null($encrypted)) {
// split apart the hash / salt
      $stack = explode(':', $encrypted);

      if (sizeof($stack) != 2) return false;

      if (md5($stack[1] . $plain) == $stack[0]) {
        return true;
      }
    }

    return false;
  }
  
  
  
  function tep_encrypt_password($plain) {
    $password = '';

    for ($i=0; $i<10; $i++) {
      $password .= tep_rand();
    }

    $salt = substr(md5($password), 0, 2);

    $password = md5($salt . $plain) . ':' . $salt;

    return $password;
  }



function create_table($table,$fix,$database_conn)
{

$structure = "CREATE TABLE IF NOT EXISTS  `".$table."` (\n";
		$records = @mysqli_query($conn, 'SHOW FIELDS FROM `'.$table.'`');
		if ( @mysqli_num_rows($records) == 0 )
			return false;
			$n=0;
		while ( $record = mysqli_fetch_assoc($records) ) {
		if(n==0) $prim=$record['Field'];
			$structure .= '`'.$record['Field'].'` '.$record['Type'];
			if ( !empty($record['Default']) )
				$structure .= ' DEFAULT \''.$record['Default'].'\'';
			if ( @strcmp($record['Null'],'YES') != 0 )
				$structure .= ' NOT NULL';
			//if ( !empty($record['Extra']) )
			//	$structure .= ' '.$record['Extra'];
			$structure .= ",\n";
			$n++;
		}
		$x = mysqli_list_fields($database_conn, $table);


for ($i = 0; $i < 1; $i++) {
  $prim ="(`".mysqli_field_name($x, $i)."`)";
}

		$structure .= "PRIMARY KEY". $prim."\n";
		$structure = @str_replace(",\n$", null, $structure);

		// Save all Column Indexes
	//	$structure .= $this->getSqlKeysTable($table);
		$structure .= "\n)";

		//Save table engine
		$records = @mysqli_query($conn, "SHOW TABLE STATUS LIKE '".$table."'");
		
		if ( $record = @mysqli_fetch_assoc($records) ) {
			if ( !empty($record['Engine']) )
				$structure .= ' ENGINE='.$record['Engine'];
			if ( !empty($record['Auto_increment']) )
				$structure .= ' DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci 
        AUTO_INCREMENT='.$record['Auto_increment'];
		}

		$structure .= ";";
		
$structure .= "";
		$tab=$fix."_".$table;
		$str=str_replace("$table","$tab",$structure);
	mysqli_query($conn, "$str");
	
}
function isTextValue($field_type) {
		switch ($field_type) {
			case "tinytext":
			case "text":
			case "mediumtext":
			case "longtext":
			case "binary":
			case "varbinary":
			case "tinyblob":
			case "blob":
			case "mediumblob":
			case "longblob":
				return True;
				break;
			default:
				return False;
		}
	}
	function getTableData($table,$fix,$hexValue = false) {
		
		// Header
		

		$records = mysqli_query($conn, 'SHOW FIELDS FROM `'.$table.'`');
		$num_fields = @mysqli_num_rows($records);
		if ( $num_fields == 0 )
			return false;
		// Field names
		$selectStatement = "SELECT ";
		$insertStatement = "INSERT INTO `$fix$table` (";
		$hexField = array();
		for ($x = 0; $x < $num_fields; $x++) {
			$record = @mysqli_fetch_assoc($records);
			if ( ($hexValue) && (isTextValue($record['Type'])) ) {
				$selectStatement .= 'HEX(`'.$record['Field'].'`)';
				$hexField [$x] = true;
			}
			else
				$selectStatement .= '`'.$record['Field'].'`';
			$insertStatement .= '`'.$record['Field'].'`';
			$insertStatement .= ", ";
			$selectStatement .= ", ";
		}
		$insertStatement = @substr($insertStatement,0,-2).') VALUES';
		$selectStatement = @substr($selectStatement,0,-2).' FROM `'.$table.'`';

		$records = @mysqli_query($conn, $selectStatement);
		$num_rows = @mysqli_num_rows($records);
		$num_fields = @mysqli_num_fields($records);
		// Dump data
		if ( $num_rows > 0 ) {
			$data .= $insertStatement;
			for ($i = 0; $i < $num_rows; $i++) {
				$record = @mysqli_fetch_assoc($records);
				$data .= ' (';
				for ($j = 0; $j < $num_fields; $j++) {
					$field_name = @mysqli_field_name($records, $j);
					if ( $hexField[$j] && (@strlen($record[$field_name]) > 0) )
						$data .= "0x".$record[$field_name];
					else
						$data .= "'".@str_replace('\"','"',@mysqli_escape_string($record[$field_name]))."'";
					$data .= ',';
				}
				$data = @substr($data,0,-1).")";
				$data .= ( $i < ($num_rows-1) ) ? ',' : ';';
			
				//if data in greather than 1MB save
		
			}
			 mysqli_query($conn, $data);
		
		}
	}
		function getTableData1($table,$fix,$idpage,$hexValue = false) {	

		$records = mysqli_query($conn, 'SHOW FIELDS FROM `'.$table.'`');
		$num_fields = @mysqli_num_rows($records);
		if ( $num_fields == 0 )
			return false;
		// Field names
		$selectStatement = "SELECT ";
		$insertStatement = "INSERT INTO `$table` (";
		$hexField = array();
		for ($x = 0; $x < $num_fields; $x++) {
			$record = @mysqli_fetch_assoc($records);
			if ( ($hexValue) && (isTextValue($record['Type'])) ) {
				$selectStatement .= 'HEX(`'.$record['Field'].'`)';
				$hexField [$x] = true;
			}
			else
				$selectStatement .= '`'.$record['Field'].'`';
			if($x>0){
			$insertStatement .= '`'.$record['Field'].'`';
			$insertStatement .= ", ";
			}
			$selectStatement .= ", ";
		}
		$insertStatement = @substr($insertStatement,0,-2).') VALUES';
		$selectStatement = @substr($selectStatement,0,-2).' FROM `'.$table.'` WHERE id_page='.$idpage.'';

		$records = @mysqli_query($conn, $selectStatement);
		$num_rows = @mysqli_num_rows($records);
		$num_fields = @mysqli_num_fields($records);
		// Dump data
		if ( $num_rows > 0 ) {
			$data .= $insertStatement;
			for ($i = 0; $i < $num_rows; $i++) {
				$record = @mysqli_fetch_assoc($records);
				$data .= ' (';
				for ($j = 0; $j < $num_fields; $j++) {
					$field_name = @mysqli_field_name($records, $j);
					if ( $hexField[$j] && (@strlen($record[$field_name]) > 0) )
						$data .= "".$record[$field_name];
						else
					{
					
					if($j>0 and $j!=$num_fields-1)
					{
						$data .= "'".@str_replace('\"','"',@mysqli_escape_string($record[$field_name]))."'";
					$data .= ',';
					}
						if($j==$num_fields-1)
					{
					
						$data .= "'".@str_replace('\"','"',$fix)."'";
					$data .= "'";
					}
				}
					$data .= '';
				}
				$data = @substr($data,0,-1).")";
				$data .= ( $i < ($num_rows-1) ) ? ',' : ';';
			
				//if data in greather than 1MB save
		
			}
		
			 mysqli_query($conn, $data);
		
		}
	}
		function getTableData2($table,$fix,$idpage,$hexValue = false) {	
$fix1 .=$fix."_";
		$records = mysqli_query($conn, 'SHOW FIELDS FROM `'.$table.'`');
		$num_fields = @mysqli_num_rows($records);
		if ( $num_fields == 0 )
			return false;
		// Field names
		$selectStatement = "SELECT ";
		$insertStatement = "INSERT INTO `$fix1$table` (";
		$hexField = array();
		for ($x = 0; $x < $num_fields; $x++) {
			$record = @mysqli_fetch_assoc($records);
			if ( ($hexValue) && (isTextValue($record['Type'])) ) {
				$selectStatement .= 'HEX(`'.$record['Field'].'`)';
				$hexField [$x] = true;
			}
			else
				$selectStatement .= '`'.$record['Field'].'`';
			
			$insertStatement .= '`'.$record['Field'].'`';
			$insertStatement .= ", ";
			
			$selectStatement .= ", ";
		}
		$insertStatement = @substr($insertStatement,0,-2).') VALUES';
		$selectStatement = @substr($selectStatement,0,-2).' FROM `'.$table.'` WHERE id_page='.$idpage.'';

		$records = @mysqli_query($conn, $selectStatement);
		$num_rows = @mysqli_num_rows($records);
		$num_fields = @mysqli_num_fields($records);
		// Dump data
		if ( $num_rows > 0 ) {
			$data .= $insertStatement;
			for ($i = 0; $i < $num_rows; $i++) {
				$record = @mysqli_fetch_assoc($records);
				$data .= ' (';
				for ($j = 0; $j < $num_fields; $j++) {
					$field_name = @mysqli_field_name($records, $j);
					if ( $hexField[$j] && (@strlen($record[$field_name]) > 0) )
						$data .= "".$record[$field_name];
						else
					{
					
					if($j!=$num_fields-1)
					{
						$data .= "'".@str_replace('\"','"',@mysqli_escape_string($record[$field_name]))."'";
					$data .= ',';
					}
						if($j==$num_fields-1)
					{
					
						$data .= "'".@str_replace('\"','"',$fix)."'";
					$data .= "'";
					}
				}
					$data .= '';
				}
				$data = @substr($data,0,-1).")";
				$data .= ( $i < ($num_rows-1) ) ? ',' : ';';
			
				//if data in greather than 1MB save
		
			}
		
		
		
		} 	 mysqli_query($conn, $data);
	}


	function del_slike($kolona,$idupisa,$jezik){
	$patH=apat($patH);
$page_path2=page_path($page_path2)."/private";
$pic=$page_path2."/galerija/$slika";
	$sel=mysqli_query($conn, "SELECT * FROM slike_paintb WHERE $kolona='$idupisa' AND jezik='$jezik'");
while($sel1=@mysqli_fetch_array($sel)){
$sl="slika";
$el=mysqli_query($conn, "SELECT * FROM slike_paintb WHERE slika='$sel1[$sl]'");
if(strlen($sel1[$sl])>2 and mysqli_num_rows($el)==1){
unlink("$page_path2/galerija/$sel1[$sl]");
unlink("$page_path2/galerija/thumb/$sel1[$sl]");
}
}
}
	function del_files($kolona,$idupisa,$jezik){
	$patH=apat($patH);
$page_path2=page_path($page_path2)."/private";
$sel=mysqli_query($conn, "SELECT * FROM files_paintb WHERE $kolona='$idupisa' AND jezik='$jezik'");
while($sel1=@mysqli_fetch_array($sel)){
$sl="opis";
$el=mysqli_query($conn, "SELECT * FROM files_paintb WHERE opis='$sel1[opis]'");
if(strlen($sel1[opis])>2 and mysqli_num_rows($el)==1){
unlink("$page_path2/files/$sel1[$sl]");
}
}
}
function del_galerije($id_page,$tabela){
	$patH=apat($patH);
$page_path2=page_path($page_path2)."/private";
$pic=$page_path2."/galerija/$slika";
	$sel=mysqli_query($conn, "SELECT * FROM $tabela WHERE id_page='$id_page'");
while($sel1=mysqli_fetch_array($sel)){
$sl="slika1";
$el=mysqli_query($conn, "SELECT * FROM $tabela WHERE slika1='$sel1[$sl]'");
if(strlen($sel1[$sl])>2 and mysqli_num_rows($el)==1){
unlink("$page_path2/galerija/$sel1[$sl]");
unlink("$page_path2/galerija/thumb/$sel1[$sl]");
}
}
}
function freeRTE_Preload($content) {
	// Strip newline characters.
	$content = str_replace(chr(10), " ", $content);
	$content = str_replace(chr(13), " ", $content);
	// Replace single quotes.
	$content = str_replace(chr(145), chr(39), $content);
	$content = str_replace(chr(146), chr(39), $content);
	// Return the result.
	return $content;
}




function check_image($slika)
{
$form_slika=array("jpg","peg","JPG","PEG","gif","GIF","png","PNG");
if(!in_array(substr($slika,-3),$form_slika))
return 0;
else return 1;
}
function check_file($slika,$ext="")
{
$af=array_reverse(explode(".",$slika));

$form_slika=array("doc","pdf","DOC","PDF","docx","DOCX","jpg","jpeg","gif","png", "zip", "ZIP", "rar", "RAR");
if($ext!="")
$form_slika=array("$ext", strtoupper($ext));
if(!in_array($af[0],$form_slika))
return 0;
else return 1;
}
function find_link_email($text)

    {

    if(!mb_eregi("https://" , $text))

$text=str_replace ("www", "https://www", $text);

$text=preg_replace("/(https:\/\/|ftp:\/\/)([^\s,]*)/i","<a href='$1$2' class=reg3 target='_blank'>$1$2</a>",$text);

    

     $emailsuchen[]="/([\s])([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,}))/si"; 



 $emailsuchen[]="/^([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,}))/si"; 



 $emailreplace[]="\\1<a href=\"mailto:\\2\" class='reg3'>\\2</a>";

 $emailreplace[]="<a href=\"mailto:\\0\" class='reg3'>\\0</a>";



 if (strpos($text, "@"))

    {

    $text = preg_replace($emailsuchen, $emailreplace, $text);

    }

      return $text;

    }
function linkifyYouTubeURLs($text, $visina) {
if(mb_eregi("vimeo.com",$text) or mb_eregi("www.youtu",$text) or  mb_eregi("http://youtu.be",$text)){
 if(mb_eregi("vimeo",$text)){
 $idv = preg_replace ( '/[^0-9]/', '', $text );
 $text='<iframe src="http://player.vimeo.com/video/'.$idv.'?byline=0&amp;portrait=0" width="200" height="150" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
 }else{
    $text = preg_replace('~
        # Match non-linked youtube URL in the wild. (Rev:20111012)
        https?://         # Required scheme. Either http or https.
        (?:[0-9A-Z-]+\.)? # Optional subdomain.
        (?:               # Group host alternatives.
          youtu\.be/      # Either youtu.be,
        | youtube\.com    # or youtube.com followed by
          \S*             # Allow anything up to VIDEO_ID,
          [^\w\-\s]       # but char before ID is non-ID char.
        )                 # End host alternatives.
        ([\w\-]{11})      # $1: VIDEO_ID is exactly 11 chars.
        (?=[^\w\-]|$)     # Assert next char is non-ID or EOS.
        (?!               # Assert URL is not pre-linked.
          [?=&+%\w]*      # Allow URL (query) remainder.
          (?:             # Group pre-linked alternatives.
            [\'"][^<>]*>  # Either inside a start tag,
          | </a>          # or inside <a> element text contents.
          )               # End recognized pre-linked alts.
        )                 # End negative lookahead assertion.
        [?=&+%\w]*        # Consume any URL (query) remainder.
        ~ix', 
        '<iframe src="http://www.youtube.com/embed/$1" width="100%" height="'.$visina.'" style="padding-right:5px;padding-bottom:5px;padding-top:5px;" frameborder="0"></iframe><br />',
        $text);
        }
    return $text;
    }else return "";
}
 

function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
   
    /*return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );*/
    $yourbrowser= "Your browser: " . $bname . " " . $version . " on " .$platform . " reports: " . $u_agent;
    return $yourbrowser;
}

function get_user_browser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = '';
    if(preg_match('/MSIE/i',$u_agent))
    {
        $ub = "ie";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $ub = "firefox";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $ub = "opera";
    }
  
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $ub = "chrome";
    }
      elseif(preg_match('/Safari/i',$u_agent))
    {
        $ub = "safari";
    }
    elseif(preg_match('/Flock/i',$u_agent))
    {
        $ub = "flock";
   }
    

  return $ub;
}
function filter_uri($sta, $u_sta="",$page=0)
{

$impl=str_replace("$sta", "$u_sta", curPageURL());
$impl=str_replace("index.php", "", $impl);
if($page>0)
$impl=str_replace("$page/", "", $impl);
$impl=str_replace("?&","?",$impl);
$impl=str_replace("&&","&",$impl);
return $impl;
}
 function razlika_datuma($time_1, $time_2, $vrati) {   

    $val_1 = new DateTime($time_1);
    $val_2 = new DateTime($time_2);

    $interval = $val_1->diff($val_2);
    $year     = $interval->y;
    $month    = $interval->m;
    $day      = $interval->d;
    $hour     = $interval->h;
    $minute   = $interval->i;
    $second   = $interval->s;

    $output   = '';

    if($year > 0){
        if ($year > 1){
            $output .= $year;     
        } else {
            $output .= $year;
        }
    }

    if($month > 0){
        if ($month > 1){
            $output .= $month;       
        } else {
            $output .= $month;
        }
    }

    if($day > 0){
        if ($day > 1){
            $output .= $day." dana";       
        } else {
            $output .= $day." dan";
        }
    }

    if($hour > 0){
        if ($hour > 1){
            $output .= $hour;     
        } else {
            $output .= $hour;
        }
    }

    if($minute > 0){
        if ($minute > 1){
            $output .= $minute;     
        } else {
            $output .= $minute;
        }
    }

    if($second > 0){
        if ($second > 1){
            $output .= $second;      
        } else {
            $output .= $second;
        }
    }
if($vrati=="d")
return $day;
else
if($vrati=="m")
return $month;
else
if($vrati=="y")
return $year;
else
    return $output;
}

// RAZLIKA DVA DATUMA (dve naredne funkcije)
 function date_dif($since, $until, $keys = 'year|month|week|day|hour|minute|second')
{
if($since>=$until)
{
    $date = array_map('strtotime', array($since, $until));

    if ((count($date = array_filter($date, 'is_int')) == 2) && (sort($date) === true))
    {
        $result = array_fill_keys(explode('|', $keys), 0);

        foreach (preg_grep('~^(?:year|month)~i', $result) as $key => $value)
        {
            while ($date[1] >= strtotime(sprintf('+%u %s', $value + 1, $key), $date[0]))
            {
                ++$value;
            }

            $date[0] = strtotime(sprintf('+%u %s', $result[$key] = $value, $key), $date[0]);
        }

        foreach (preg_grep('~^(?:year|month)~i', $result, PREG_GREP_INVERT) as $key => $value)
        {
            if (($value = intval(abs($date[0] - $date[1]) / strtotime(sprintf('%u %s', 1, $key), 0))) > 0)
            {
                $date[0] = strtotime(sprintf('+%u %s', $result[$key] = $value, $key), $date[0]);
            }
        }

        return $result;
    }
}else return array("day"=>"oglas je istekao");
    return false;
}
function humanize($array)
{
    $result = array();

    foreach ($array as $key => $value)
    {
        $result[$key] = $value . ' ' . $key;

        if ($value != 1)
        {
            $result[$key] .= 's';
        }
    }
$vrati=str_replace("days","",implode(', ', $result));
$vrati=str_replace("day","",$vrati);
    return $vrati;
} 
 
?>
