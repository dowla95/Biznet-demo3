<?php 

include("class.phpmailer.php");
function html2plain($html, $numchars) {
        // Remove the HTML tag
        
        $html = strip_tags($html);
        // Convert HTML entities to single characters
        $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
        // Make the string the desired number of characters
        // Note that substr is not good as it counts by bytes and not characters
        $html = mb_substr($html, 0, $numchars, 'UTF-8');
        // Add an elipsis
        $html .= "…";
        return $html;
    }
function filtriraj($value,$tit="")
{
$value=strip_tags($value);
$value=preg_replace('/<[^>]*>/', '',$value);
if($tit==1)
$value=str_replace("'","",$value);
$value=htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
return $value;
}

function confirmUsers($email, $password){
 
   $resulta=mysql_query("SELECT * FROM users_admin WHERE email=".safe($email)." AND akt='Y'");
   if(mysql_num_rows($resulta)==0){
      return 1; //Pogresan email
   }
$dbarray = mysql_fetch_array($resulta);
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
    $_SESSION['emails'] = $_COOKIE['ipcooknames'];
    $_SESSION['passwords'] = $_COOKIE['ipcookpasss'];    
    $_SESSION['userid'] = $_COOKIE['ipcookids']; 
   }
   if(isset($_SESSION['emails']) && isset($_SESSION['passwords']) and mysql_num_rows(mysql_query("SELECT email FROM users_admin WHERE email='$_SESSION[emails]'"))>0)
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
   $resulti = mysql_query("select * from users_admin where email = '".$_SESSION['emails']."'");   
   $dbarrayi = mysql_fetch_assoc($resulti);
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
    $resultadmin = mysql_query($qa);
   $addb = mysql_fetch_assoc($resultadmin);
  
    return $addb['active'];

	}
}
if(preg_match("/admin/",curPageURL()))
$admins = check_admins();

 //include($page_path2."/language/$lang.php");
//include($page_path2."/funkc.php");
function replace_slug($all){

$all=trim($all);

$nid_pr=str_replace("Ć","c",$all);



$nid_pr=str_replace("ć","c",$nid_pr);

$nid_pr=str_replace("ä","a",$nid_pr);
$nid_pr=str_replace("ö","o",$nid_pr);
$nid_pr=str_replace("ü","u",$nid_pr);
$nid_pr=str_replace("Ä","a",$nid_pr);
$nid_pr=str_replace("Ö","o",$nid_pr);
$nid_pr=str_replace("ß","s",$nid_pr);

$nid_pr=str_replace("Č","c",$nid_pr);



$nid_pr=str_replace("č","c",$nid_pr);



$nid_pr=str_replace("Š","s",$nid_pr);



$nid_pr=str_replace("š","s",$nid_pr);



$nid_pr=str_replace("ž","z",$nid_pr);



$nid_pr=str_replace("Ž","z",$nid_pr);



$nid_pr=str_replace("đ","dj",$nid_pr);



$nid_pr=str_replace("Đ","dj",$nid_pr);



$nid_pr=str_replace('"','',$nid_pr);



$nid_pr=str_replace("'","",$nid_pr);



$nid_pr=str_replace("?","",$nid_pr);



$nid_pr=str_replace("!","",$nid_pr);



$nid_pr=str_replace(".","",$nid_pr);



$nid_pr=str_replace(":","",$nid_pr);



$nid_pr=str_replace(";","",$nid_pr);



$nid_pr=str_replace("/","",$nid_pr);

$nid_pr=str_replace("   ","-",$nid_pr);
$nid_pr=str_replace("  ","-",$nid_pr);
$nid_pr=str_replace(" ","-",$nid_pr);
//$nid_pr=str_replace("-","",$nid_pr);

$nid_pr=str_replace("+","-",$nid_pr);
$nid_pr=str_replace("*","-",$nid_pr);
$nid_pr=str_replace("(","-",$nid_pr);
$nid_pr=str_replace(")","-",$nid_pr);
$nid_pr=str_replace("=","-",$nid_pr);
$nid_pr=str_replace("^","-",$nid_pr);

$nid_pr=str_replace("&","",$nid_pr);



$nid_pr=str_replace("[[:punct:]]","",$nid_pr);



$nid_pr1=strtolower($nid_pr);



$nid_pr2=trim($nid_pr1);

$nid_pr2=implode("-",explode(" ",$nid_pr2));
$nid_pr2=str_replace("--","-",$nid_pr2);

return $nid_pr2;



}


//include($page_path2."/language/$lang.php");
//include($page_path2."/funkc.php");
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



$nid_pr=str_replace('"','',$nid_pr);



$nid_pr=str_replace("'","",$nid_pr);



$nid_pr=str_replace("?","",$nid_pr);



$nid_pr=str_replace("!","",$nid_pr);



$nid_pr=str_replace(".","",$nid_pr);



$nid_pr=str_replace(":","",$nid_pr);



$nid_pr=str_replace(";","",$nid_pr);



$nid_pr=str_replace("/","",$nid_pr);



$nid_pr=str_replace("-","",$nid_pr);

$nid_pr=str_replace("+","-",$nid_pr);
$nid_pr=str_replace("*","-",$nid_pr);
$nid_pr=str_replace("(","-",$nid_pr);
$nid_pr=str_replace(")","-",$nid_pr);
$nid_pr=str_replace("=","-",$nid_pr);
$nid_pr=str_replace("^","-",$nid_pr);

$nid_pr=str_replace("&","",$nid_pr);



$nid_pr=str_replace("[[:punct:]]","",$nid_pr);



$nid_pr1=strtolower($nid_pr);



$nid_pr2=trim($nid_pr1);



return $nid_pr2;



}
 
function replaceZZ($all){
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
$nid_pr=str_replace("?","",$nid_pr);
$nid_pr=str_replace("!","",$nid_pr);
$nid_pr=preg_replace("/[[:punct:]]/","",$nid_pr);
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
return $nid_pr;
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
$nid_pr=str_replace("?","",$nid_pr);
$nid_pr=str_replace("!","",$nid_pr);
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
$nid_pr=str_replace(".","",$nid_pr);
$nid_pr=str_replace(":","",$nid_pr);
$nid_pr=str_replace(";","",$nid_pr);
$nid_pr=str_replace("/","",$nid_pr);
$nid_pr=str_replace("(","",$nid_pr);
$nid_pr=str_replace(")","",$nid_pr);
$nid_pr=str_replace("^","",$nid_pr);
$nid_pr=str_replace(",","",$nid_pr);
$nid_pr=str_replace("  "," ",$nid_pr);
$nid_pr=str_replace("$","",$nid_pr);
$nid_pr=str_replace("#","",$nid_pr);
$nid_pr=str_replace("&","",$nid_pr);
$nid_pr=str_replace("*","",$nid_pr);
$nid_pr=str_replace("=","",$nid_pr);
$nid_pr=str_replace("+","",$nid_pr);
$nid_pr=preg_replace("/[[:punct:]]/","",$nid_pr);
$nid_pr2=strtolower($nid_pr);
$nid_pr2=str_replace("--","-",$nid_pr2);
$nid_pr2=implode("-",explode(" ",trim($nid_pr2)));

return $nid_pr2;
}
function replace_implode2($nid_pr,$nosrb="", $norazm=""){
if($nosrb=="")
{
$nid_pr=str_replace("Ć","C",$nid_pr);
$nid_pr=str_replace("ć","c",$nid_pr);
$nid_pr=str_replace("Č","C",$nid_pr);
$nid_pr=str_replace("č","c",$nid_pr);
$nid_pr=str_replace("Š","S",$nid_pr);
$nid_pr=str_replace("š","s",$nid_pr);
$nid_pr=str_replace("ž","z",$nid_pr);
$nid_pr=str_replace("Ž","Z",$nid_pr);
$nid_pr=str_replace("đ","dj",$nid_pr);
$nid_pr=str_replace("Đ","Dj",$nid_pr);
}
$nid_pr=str_replace('"','',$nid_pr);
$nid_pr=str_replace("'","",$nid_pr);
$nid_pr=str_replace("?","",$nid_pr);
$nid_pr=str_replace("!","",$nid_pr);
$nid_pr=str_replace(".","",$nid_pr);
$nid_pr=str_replace(":","",$nid_pr);
$nid_pr=str_replace(";","",$nid_pr);
$nid_pr=str_replace("/","",$nid_pr);
$nid_pr=str_replace("(","",$nid_pr);
$nid_pr=str_replace(")","",$nid_pr);
$nid_pr=str_replace("^","",$nid_pr);
$nid_pr=str_replace(",","",$nid_pr);
$nid_pr=str_replace("  "," ",$nid_pr);
$nid_pr=str_replace("$","",$nid_pr);
$nid_pr=str_replace("#","",$nid_pr);
$nid_pr=str_replace("&","",$nid_pr);
$nid_pr=str_replace("*","",$nid_pr);
$nid_pr=str_replace("=","",$nid_pr);
$nid_pr=str_replace("+","",$nid_pr);
$nid_pr=str_replace("-","",$nid_pr);
$nid_pr=preg_replace("/[[:punct:]]/","",$nid_pr);
$nid_pr1=strtolower($nid_pr);
if($norazm=="")
$nid_pr=implode("",explode(" ",trim($nid_pr)));

return $nid_pr;
}
function addslash($theValue){
 $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
 return $theValue;
 }
function safed($str, $using_like=false) { 
    if( get_magic_quotes_gpc() )  // if already escaped 
            $str = stripslashes($str); 
    $str = mysql_real_escape_string($str); 

    return ( $using_like? addcslashes($str, '%_') : $str ); 
}  
 function safe($value,$sp="") {
  if (get_magic_quotes_gpc()) //dali je magic quptes ukljucen
     $value = stripslashes($value); //ako je, ponisti sta je napravio
  //if (!is_numeric($value)) //dali nije numericka vrjednost (dali je string?)
    $value = "'" . mysql_real_escape_string($value) . "'"; //ako je string, escapaj ga kako spada
  if($sp==1)
  $value=strip_tags($value);
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
	$chars = array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w',  'x', 'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
	
	$max_chars = count($chars) - 1;
	srand( (double) microtime()*1000000);
	
	$rand_str = '';
	for($i = 0; $i < 5; $i++)
	{
		$rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
	}
$rep=str_replace(".jpg","-",$ime);
$rep=str_replace(".JPG","-",$rep);
$rep=str_replace(".JPEG","-",$rep);
$rep=str_replace(".jpeg","-",$rep);
$rep=str_replace(".gif","-",$rep);
$rep=str_replace(".GIF","-",$rep);
$rep=str_replace(".png","-",$rep);
$rep=str_replace(".PNG","-",$rep);
$rep=str_replace(".swf","-",$rep);
$rep=str_replace(".SWF","-",$rep);
$rep=str_replace(".doc","-",$rep);
$rep=str_replace(".DOC","-",$rep);
$rep=str_replace(".pdf","-",$rep);
$rep=str_replace(".PDF","-",$rep);
	return $rep.$rand_str;
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
function UploadSlika($imesl,$tmp_name,$ext,$lokacija,$da="",$crop="") {

$slika2="";
$iimesl=explode('.', $imesl);
$ext= ".".end($iimesl);
 
$imesl=str_replace(" ","_",$imesl);
$imesl=str_replace("&","_",$imesl);
$imesl=str_replace($ext,"",$imesl);

$slika2 = date("Y-m-d-H-i")."-".replace2($imesl).$ext;
//} else $slika2 = $imesl;


$fold=$lokacija;
$uploadfile = $lokacija . $slika2;


@copy($tmp_name, $uploadfile);
if(preg_match("/galerija/",$lokacija) or preg_match("/apartmani_beograd/",$lokacija) or $da==1)
if($ext==".jpg" or $ext==".JPG" or $ext==".gif" or $ext==".GIF" or $ext==".png" or $ext==".PNG")
{
if($crop!=1 and $crop!=100)
{
resize($slika2,$fold);
}

resizerv($slika2,$fold);


if($crop==1 or $crop==100)
{
//resizervE($slika2,$fold,$crop);
if($crop==100) //$crop=100; else $crop="";
create_square_image($slika2,$fold,$crop);
else
create_square_image1($slika2,$fold,320);
}

}

//chmod($uploadfile, 0644);
if($imesl!="")
return $slika2;

}

########################## RESIZE IMAGE create thumb ###################
function resize($slika,$folder){
$image = "$folder$slika";//ovo je slika koju ces da resajzujes
//$newHeight = '200';//u pixelima postavim visinu i sirinu
$kvalitet = '100';

if($slika!="")
{

$size = GetImageSize($image);//u pixelima uzima stvarnu visinu i sirinu slike
$width = $size[0];
$height = $size[1];

$imgratio=$width/$height;
$wid=320;
$heig=320;
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
$exstension = substr($image,-3); 
 if($exstension == "jpeg" || $exstension == "jpg" || $exstension == "JPG"){
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
if($exstension == "jpg" || $exstension == "JPG")
imageJpeg($tmb, $destJpeg,$kvalitet);
elseif($exstension == "gif" || $exstension == "GIF")
imageGif($tmb, $destJpeg,$kvalitet);
elseif($exstension == "png" || $exstension == "PNG")
imagePng($tmb, $destJpeg,5);  
ImageDestroy($src);
ImageDestroy($tmb);

}
}
function resizervE($slika,$folder, $isto=0){
$image = "$folder$slika";//ovo je slika koju ces da resajzujes
//$newHeight = '200';//u pixelima postavim visinu i sirinu

$kvalitet = '100';
$size = GetImageSize($image);//u pixelima uzima stvarnu visinu i sirinu slike
$newWidth=$width = $size[0];
$newHeight=$height = $size[1];

if($width>=520 or $height>=520 or $isto>0){
if($isto=0)
{
$imgratio=$width/$height;
$wid=$heig=520;
if($width>$height){
$wd=$width/$height;
$newWidth=$wid*$wd;
$newHeight=$heig;
}elseif($width<=$height){
$hd=$height/$width;
$newHeight=$hd*$wid;
$newWidth=$wid;
}
}
 

$x = 0;//ovde u pixelima stavi odakle da krene sa crop-ovanjem
$y = 0;

//ako je slika gif onda ovako, ako je jpg onda ImageCreateFromJpg a ako je png ImageCreateFromPng
$exstension = substr($image,-3); 
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



$destJpeg=$folder."thumb/$slika";
if($exstension == "jpg" || $exstension == "JPG")
imageJpeg($tmb, $destJpeg,$kvalitet);
elseif($exstension == "gif" || $exstension == "GIF")
imageGif($tmb, $destJpeg,$kvalitet);
elseif($exstension == "png" || $exstension == "PNG")
imagePng($tmb, $destJpeg,5);  
ImageDestroy($src);
ImageDestroy($tmb);
}
}
function resizerv($slika,$folder,$tip=""){
$image = "$folder$slika";//ovo je slika koju ces da resajzujes
//$newHeight = '200';//u pixelima postavim visinu i sirinu

$kvalitet = '100';
$size = GetImageSize($image);//u pixelima uzima stvarnu visinu i sirinu slike
$width = $size[0];
$height = $size[1];
if($width>640 or $height>640){
$imgratio=$width/$height;
$wid=640;
$heig=640;
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
$exstension = substr($image,-3); 
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
if($exstension == "jpg" || $exstension == "JPG")
imageJpeg($tmb, $destJpeg,$kvalitet);
elseif($exstension == "gif" || $exstension == "GIF")
imageGif($tmb, $destJpeg,$kvalitet);
elseif($exstension == "png" || $exstension == "PNG")
imagePng($tmb, $destJpeg,5);  
ImageDestroy($src);
ImageDestroy($tmb);
}
}

	function create_square_image1($original_file, $destination_file, $sq=520){
$square_size=$sq;		
if($square_size=="") $square_size=520;

$imagez = $destination_file."".$original_file; 
 
		// get width and height of original image
		$imagedata = getimagesize($imagez);
		$original_width = $imagedata[0];	
		$original_height = $imagedata[1];
		
		if($original_width > $original_height){
			$new_height = $square_size;
			$new_width = $new_height*($original_width/$original_height);
		}
		if($original_height > $original_width){
			$new_width = $square_size;
			$new_height = $new_width*($original_height/$original_width);
		}
		if($original_height == $original_width){
			$new_width = $square_size;
			$new_height = $square_size;
		}
		
		$new_width = round($new_width);
		$new_height = round($new_height);
		
		// load the image
		if(substr_count(strtolower($original_file), ".jpg") or substr_count(strtolower($original_file), ".jpeg")){
			$original_image = imagecreatefromjpeg($imagez);
		}
		if(substr_count(strtolower($original_file), ".gif")){
			$original_image = imagecreatefromgif($imagez);
		}
		if(substr_count(strtolower($original_file), ".png")){
			$original_image = imagecreatefrompng($imagez);
		}
		
		$smaller_image = imagecreatetruecolor($new_width, $new_height);
		$square_image = imagecreatetruecolor($square_size, $square_size);
		
  /*if(substr_count(strtolower($original_file), ".png")){
imagealphablending($square_image, false);
imagesavealpha($square_image,true);
$transparent = imagecolorallocatealpha($square_image, 255, 255, 255, 127);
imagefilledrectangle($square_image, 0, 0, $new_width, $new_height, $transparent);
} */ 

if(substr_count(strtolower($original_file), ".png")){


            imagecolortransparent($square_image, imagecolorallocatealpha($square_image, 0, 0, 0, 127));
            imagealphablending($square_image, false);
            imagesavealpha($square_image, true);
    
        }   

    
		imagecopyresampled($smaller_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
		
		if($new_width>$new_height){
			$difference = $new_width-$new_height;
			$half_difference =  round($difference/2);
			imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $square_size+$difference, $square_size, $new_width, $new_height);
		}
		if($new_height>$new_width){
			$difference = $new_height-$new_width;
			$half_difference =  round($difference/2);
			imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $square_size, $square_size+$difference, $new_width, $new_height);
		}
		if($new_height == $new_width){
			imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size, $new_width, $new_height);
		}
		

		// if no destination file was given then display a png		
		if(!$destination_file){
			imagepng($square_image,NULL,9);
		}
$destJpeg=$destination_file."thumb/$original_file";
		// save the smaller image FILE if destination file given
    
		if(substr_count(strtolower($original_file), ".jpg")){
			imagejpeg($square_image,$destJpeg,100);
		}
		if(substr_count(strtolower($original_file), ".gif")){
			imagegif($square_image,$destJpeg);
		}
		if(substr_count(strtolower($original_file), ".png")){
			imagepng($square_image,$destJpeg,9);
		}

		imagedestroy($original_image);
		imagedestroy($smaller_image);
		imagedestroy($square_image);

	}
 // create_square_image($original_file, $destination_file, $sq=520)
 function create_square_image($source, $destination, $sq=520) {
$quality=90;
$square_size=$sq;		
if($square_size=="") $square_size=520;
$iimesl=explode('.', $source);
$extension= strtolower(end($iimesl));
$slika = $destination."thumb/".$source;
        $status  = false;
        list($width, $height, $type, $attr) = getimagesize($slika);

        if($width> $height) {
           $width_t =  $square_size;
           $height_t    =   round($height/$width*$square_size);
           $off_y       =   ceil(($width_t-$height_t)/2);
           $off_x       =   0;
           
          $difference = $width_t-$new_height_t;
			    $half_difference =  round($difference/2);
           

        } elseif($height> $width) {

           $height_t    =   $square_size;
           $width_t =   round($width/$height*$square_size);
           $off_x       =   ceil(($height_t-$width_t)/2);
           $off_y       =   0;
           $difference = $height_t-$width_t;
			     $half_difference =  round($difference/2);

        } else {

            $width_t    =   $height_t   =   $square_size;
            $off_x      =   $off_y      =   0;
        }

        $thumb_p    = imagecreatetruecolor($square_size, $square_size);

    //   $extension  = self::get_file_extension($source);

        if($extension == "gif" or $extension == "png"){

            imagecolortransparent($thumb_p, imagecolorallocatealpha($thumb_p, 0, 0, 0, 127));
            imagealphablending($thumb_p, false);
            imagesavealpha($thumb_p, true);
        }   

        if ($extension == 'jpg' || $extension == 'jpeg')
            $thumb = imagecreatefromjpeg($slika);
        if ($extension == 'gif')
            $thumb = imagecreatefromgif($slika);
        if ($extension == 'png')
            $thumb = imagecreatefrompng($slika);

        $bg = imagecolorallocate ( $thumb_p, 255, 255, 255 );
        imagefill ($thumb_p, 0, 0, $bg);

if($width_t>$height_t)
imagecopyresampled($thumb_p, $thumb, 0-$half_difference+1, 0, 0, 0, $square_size+$difference, $square_size, $width, $height);
else
if($width_t>$height_t)
imagecopyresampled($thumb_p, $thumb, 0-$half_difference+1, 0, 0, 0, $square_size, $square_size+$difference,  $width, $height);
else
if($width_t==$height_t)
        imagecopyresampled($thumb_p, $thumb, 0, 0, 0, 0, $square_size, $square_size, $width, $height);
        
        
    $destinationa=$destination."thumb/$source";
        if ($extension == 'jpg' || $extension == 'jpeg')
            $status = @imagejpeg($thumb_p,$destinationa,$quality);
        if ($extension == 'gif')
            $status = @imagegif($thumb_p,$destinationa,$quality);
        if ($extension == 'png')
            $status = @imagepng($thumb_p,$destinationa,9);

        imagedestroy($thumb);
        imagedestroy($thumb_p);

        return $status;
    }
function opist($opis)
{
return str_replace("diframe", "iframe",$opis);
}
################### for page site ###################
function opis($duz,$opis,$id,$fajl,$podrob){
global $patH;
global $path1;


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
global $patH;
global $path1;
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
global $patH;
global $path1;
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
global $patH;
global $path1;

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
        return $imp;
        }
function datum1($datum)
        {
        $exp=explode("-",$datum);
        $exp_rev=array_reverse($exp);
        $imp=implode("-",$exp_rev);
        return $imp;
        }        
//////////////////// return idpage //////////////
function idpages($strana,$lang)
{
$pp=mysql_query("SELECT * FROM page WHERE file='$strana' AND jezik='$lang'");
$pp1=mysql_fetch_array($pp);
return $pp1[id_grupe];
}
function read_files($kol,$i,$idpage,$patH,$page_path2,$download=0)
{
global $lang;

$pp = mysql_query("SELECT p.*, pt.*
        FROM files p
        INNER JOIN files_lang pt ON p.id = pt.id_fajla        
        WHERE pt.lang='$lang'  AND p.akt='Y' AND p.$kol=$i ORDER BY -p.pozicija DESC");

if (mysql_num_rows($pp)>0) {
$g=0;
echo "<div  class='files'><ul>";
while(@$pp1=mysql_fetch_array($pp)){
//if($g%2==0)
//$fr=" class='iright'"; else $fr="";
$nazi=$pp1["naslov"];
if(substr($pp1['slika'],-3)=="pdf") $tip="<i class='fa fa-file-pdf-o'></i>";
if(substr($pp1['slika'],-3)=="xls") $tip="<i class='fa fa-file-excel-o'></i>";
if(substr($pp1['slika'],-4)=="xlsx") $tip="<i class='fa fa-file-excel-o'></i>";
if(substr($pp1['slika'],-3)=="doc") $tip="<i class='fa fa-file-word-o'></i>";
if(substr($pp1['slika'],-4)=="docx") $tip="<i class='fa fa-file-word-o'></i>";
if(substr($pp1['slika'],-3)=="zip") $tip="<i class='fa fa-file-zip-o'></i>";
if(substr($pp1['slika'],-3)=="swf") $tip="<i class='fa fa-flash'></i>";
if(substr($pp1['slika'],-3)=="avi") $tip="<i class='fa fa-file-video-o'></i>";
if(substr($pp1['slika'],-3)=="mpg") $tip="<i class='fa fa-file-video-o'></i>";
if(substr($pp1['slika'],-3)=="wmv") $tip="<i class='fa fa-file-video-o'></i>";
if(substr($pp1['slika'],-3)=="mp3") $tip="<i class='fa fa-file-sound-o'></i>";
if(file_exists("$page_path2".SUBFOLDER."/files/".$pp1['slika'].""))
$size=ceil(filesize("$page_path2".SUBFOLDER."/files/".$pp1['slika']."")/1024);
if(strlen($pp1['slika'])>0){
if($download==0)
{//($size Kb)
echo " 
<li$fr><a href='".$patH."/files/".$pp1['slika']."' target='_blank'>$tip &nbsp;&nbsp;$nazi</a></li>";
}elseif($download==1)
{
echo " 
<li$fr><a href='".$patH."/download.php?f=".$pp1['slika']."'><img src='".$patH."/images/icon/$tip' alt='icon' class='iconsi' style='width:20px;position:relative;' /> &nbsp;&nbsp;$nazi</a></li>";
}
}
$g++;
}
echo "</ul></div>";
}
}
function read_files_pdf($kol,$i,$idpage,$patH,$page_path2,$download=0)
{
global $lang;

$pp=mysql_query("SELECT * FROM files WHERE $kol='$i' AND akt='Y' ORDER BY -pozicija DESC");
if (mysql_num_rows($pp)>0) {
$g=0;
echo "<ul class='pdf'>";
while(@$pp1=mysql_fetch_array($pp)){
//if($g%2==0)
//$fr=" class='iright'"; else $fr="";
$nazi=$pp1["naslov$lang"];
if(substr($pp1['slika'],-3)=="pdf") $tip="pdf.png";
if(substr($pp1['slika'],-3)=="xls") $tip="excel.png";
if(substr($pp1['slika'],-4)=="xlsx") $tip="excel.png";
if(substr($pp1['slika'],-3)=="doc") $tip="word.png";
if(substr($pp1['slika'],-4)=="docx") $tip="word.png";
if(substr($pp1['slika'],-3)=="zip") $tip="zip.png";
if(substr($pp1['slika'],-3)=="swf") $tip="swf.png";
if(substr($pp1['slika'],-3)=="avi") $tip="video.png";
if(substr($pp1['slika'],-3)=="mpg") $tip="video.png";
if(substr($pp1['slika'],-3)=="wmv") $tip="video.png";
if(file_exists("$page_path2".SUBFOLDER."/files/".$pp1['slika'].""))
$size=ceil(filesize("$page_path2".SUBFOLDER."/files/".$pp1['slika']."")/1024);
if(strlen($pp1['slika'])>0){
if($download==0)
{//($size Kb)
echo " 
<li$fr><a href='".$patH."/files/".$pp1['slika']."' target='_blank'>$nazi
</a></li>";
}elseif($download==1)
{
echo " 
<li$fr><a href='".$patH."/download.php?f=".$pp1['slika']."'>$nazi</a></li>";
}
}
$g++;
}
echo "</ul>";
}
}
function read_files_left($kol,$i,$idpage,$patH,$page_path2)
{ 
global $lang;
$pp=mysql_query("SELECT * FROM files WHERE idstrane='$i' AND id_page=$idpage AND akt='Y'");
$g=0;
while(@$pp1=mysql_fetch_array($pp)){
if($g%2==0)
echo "<div style='width:100%;height:5px;float:left;'></div>";
preg_match("/::$lang::(.*)::$lang::/", $pp1[naslov], $matches);
$nazi=$matches[1];
if(substr($pp1['opis'],-3)=="pdf") $tip="pdf.png";
if(substr($pp1['opis'],-3)=="xls") $tip="excel.png";
if(substr($pp1['opis'],-3)=="doc") $tip="word.png";
if(substr($pp1['opis'],-3)=="zip") $tip="zip.png";
if(substr($pp1['opis'],-3)=="swf") $tip="swf.png";
if(substr($pp1['opis'],-3)=="avi") $tip="video.png";
if(substr($pp1['opis'],-3)=="mpg") $tip="video.png";
if(substr($pp1['opis'],-3)=="wmv") $tip="video.png";

if(file_exists("$page_path2/private/files/".$pp1['opis'].""))
$size=ceil(filesize("$page_path2/private/files/".$pp1['opis']."")/1024);
if(strlen($pp1['opis'])>0){
echo "<table style='float:left;width:100%;' class='files' cellspacing='0'> 
<tr ><td style='width:30px;'><img src='".$patH."images/$tip' alt='' width='40' /></td><td><a href='".$patH."download.php?down=".$pp1['opis']."'  style='text-align:left;font-size:11px;'>
&raquo; $nazi
</a></td></tr></table>";
}
$g++;
}
}
function read_galery($id,$idp,$wi,$he,$ur)
{
global $patH;
global $path1;
global $lang;
global $page_path2;
$page_path2=$page_path2."/private";
if(empty($wi)) $wid=90; else $wid=$wi;
if(empty($he)) $heig=80; else $heig=$he;
if($id)
$im=mysql_query("SELECT * FROM galerija WHERE katid='$id'  AND akt='Y' AND id_page='$idp' ORDER BY pozicija, id ASC");
else
$im=mysql_query("SELECT * FROM galerija WHERE id_page='$idp' AND akt='Y' ORDER BY pozicija, id ASC");
$l=0;
while($p1=mysql_fetch_array($im))
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
global $patH;
global $path1;
global $lang;
global $page_path2;
$page_path2=$page_path2."/private";
if(empty($wi)) $wid=90; else $wid=$wi;
if(empty($he)) $heig=80; else $heig=$he;
$im=mysql_query("SELECT * FROM slike_paintb WHERE $kol='$id' AND akt='Y' AND id_page='$idp' ORDER BY pozicija, id ASC");
$l=0;
$num=mysql_num_rows($im);
while($p1=mysql_fetch_array($im))
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
global $patH;
global $path1;
global $lang;
global $page_path2;
$page_path2=$page_path2."/private";
if(empty($wi)) $wid=74; else $wid=$wi;
if(empty($he)) $heig=50; else $heig=$he;
$im=mysql_query("SELECT * FROM slike_paintb WHERE $kol='$id' AND id_page='$idp' ORDER BY pozicija, id ASC");
$i=1;
$widd=$wid+10;
$widd1=$wid+2;
while($p1=mysql_fetch_array($im))
{
$b=$i%$bruredu;

?>
<div style='float:left;width:<?php echo $widd?>px;text-align:center;font-size:1px;'>
<div style='border:1px solid #999;width:<?php echo $widd1?>px;'>
<?php 
if(strlen($p1[slika])>3){
$page_path2=$page_path2."/private";
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
global $patH;
global $path1;
global $lang;
global $page_path2;
$page_path2=$page_path2.SUBFOLDER;
$pic=$page_path2.GALFOLDER.$slika;
if(strlen($slika)>2){
$size = GetImageSize($pic);
$width  = $size[0];
$height = $size[1];
if($width>$height){
$wd=$width/$height;
$width1=$wid;
$height1=$width1/$wd;
}elseif($width<=$height){
$hd=$height/$width;
$height1=$heig;
$width1=$heig/$hd;
}
return $width1."-".$height1;
 }
}
function image_size1($wid,$heig,$slika,$fold=""){
global $patH;
global $path1;
global $lang;

$pic=".".SUBFOLDER.GALFOLDER."/".$slika;
if(strlen($slika)>0 and is_file($pic)){
$size = GetImageSize($pic);
$width  = $size[0];
$height = $size[1];
 
if($height>$width){
$hd=$height/$width;
$width1=$heig/$hd;
$height1=$heig;
}
 
if($width>=$height){
$wd=$width/$height;
$width1=$wid;
$height1=$wid/$wd;
} 
 
if($height1>$heig)
{

$height1=$heig;
if($height>=$width){
$hd=$height/$width;
$width1=$height1/$hd;
}
if($height<=$width){
$wd=$width/$height;
$width1=$height1*$wd;
}
} 
 
return $width1."-".$height1;
 
}
}
function image_size2($wid,$heig,$slika,$fold){
global $patH;
global $page_path2;

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
function image_size3($wid,$heig,$slika,$fold=""){

$pic=".".SUBFOLDER.GALFOLDER."/".$slika;
if(strlen($slika)>0 and is_file($pic)){
 

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
$ku=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id_parent='$nd'");

  while($ku1=mysql_fetch_array($ku)){
$nn2 .=", ".$ku1[id];
$num=mysql_query("SELECT * FROM proizvodi_new WHERE katid = '$ku1[id]'");
$num1=mysql_num_rows($num);
$nums .=",".$num1;

//////// ispis podkategorija /////////
//echo $ku1[ime];
$kd=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id_parent='$ku1[id]'");
$br1 =mysql_num_rows($kd);
  while($kd1=mysql_fetch_array($kd)){
// echo $kd1[id]."--";
 $nn3 .=", ".$kd1[id];
 $num=mysql_query("SELECT * FROM proizvodi_new WHERE katid='$kd1[id]'");
$numi1 =mysql_num_rows($num);
 
//echo "--".$numi1;
$numi11 .=", ".$numi1;

  }
  } 
  $numg=mysql_query("SELECT * FROM proizvodi_new WHERE katid='$nd'");
$numg1 =mysql_num_rows($numg);
$nums_exp=explode(",",$nums);
$nums_exp1=explode(",",$numi11);
$num1=array_sum($nums_exp);
$vuv=array_sum($nums_exp1);
echo $vuv+$num1+$numg1;
} 

function find($nn1,$v,$v1,$v2){

  global $nn;
  global $num2;
  
$ku=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id_parent='$nn1'");

  while($ku1=mysql_fetch_array($ku)){
  
 
$nn2 .=", ".$ku1[id];
$num=mysql_query("SELECT * FROM proizvodi_new WHERE katid = '$ku1[id]'");
$num1=mysql_num_rows($num);
//////// ispis podkategorija /////////
//echo $ku1[ime];
$kd=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id_parent='$ku1[id]'");
$br1 =mysql_num_rows($kd);
  while($kd1=mysql_fetch_array($kd)){
// echo $kd1[id]."--";
 $nn3 .=", ".$kd1[id];
 $num=mysql_query("SELECT * FROM proizvodi_new WHERE katid='$kd1[id]'");
$numi1 =mysql_num_rows($num);
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
 echo "<option  style='color:black;font-weight:normal;' $su value=$ku1[id]>$ku1[ime] ($num2)</option>";
 } 
if($v==1){ 
echo "<div style='float:left;width:50%;'>";
echo "
<img src='images/B2.jpg'>
<a href=$PHP_SELF?id_kat=$ku1[id] class='link11'>$ku1[ime]</a> <span style='font-size:11px;color:#999;'>($num2)</span>";
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
$kor=mysql_query("SELECT * FROM $tab WHERE id='$key'");
$kor1=mysql_fetch_array($kor);
//$num=mysql_num_rows($kor);
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
<td><a href='$PHP_SELF?idpro=$kor1[id]' class='reg2' style='color:white;'>".stripslashes($kor1[naslov])."</a></td>
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
$kor=mysql_query("SELECT * FROM $tab WHERE id='$key'");
$kor1=mysql_fetch_array($kor);
//$num=mysql_num_rows($kor);
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

function kategorije($idkat,$tab,$podkat)
{
$ss=mysql_query("SELECT * FROM $tab WHERE id='$idkat'");
$ss1=mysql_fetch_array($ss);
$in=$ss1[id];
if($podkat==1){
$sa=mysql_query("SELECT * FROM $tab WHERE id_parent='$ss1[id]'");
while($sa1=mysql_fetch_array($sa)){
$in .=",".$sa1[id];
$sg=mysql_query("SELECT * FROM $tab WHERE id_parent='$sa1[id]'");
while($sg1=mysql_fetch_array($sg)){
$in .=",".$sg1[id];
$st=mysql_query("SELECT * FROM $tab WHERE id_parent='$sg1[id]'");
while($sg1=mysql_fetch_array($st)){
$in .=",".$st1[id];
}
}
}
}
return $in;
}

function kategorije1($idkat,$tabela)
{



$sa=mysql_query("SELECT * FROM $tabela WHERE id_parent='$idkat'");
$c=0;
while($sa1=mysql_fetch_array($sa)){
if($c==0) $za=""; else $za=",";
$in .="$za".$sa1[id];
$sg=mysql_query("SELECT * FROM $tabela WHERE id_parent='$sa1[id]'");
while($sg1=mysql_fetch_array($sg)){
$in .=",".$sg1[id];
$st=mysql_query("SELECT * FROM $tabela WHERE id_parent='$sg1[id]'");
while($sg1=mysql_fetch_array($st)){
$in .=",".$st1[id];
}
}
$c++;
}
if(empty($in)) $za=""; else $za=",";
return $idkat."$za".$in;
}
function kategorije2($idkat)
{

$ss=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$idkat'");
$ss1=mysql_fetch_array($ss);
$ins=$ss1[id];

$sa=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$ss1[id_parent]'");
while($sa1=mysql_fetch_array($sa)){
$ins .=",".$sa1[id];
$sg=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$sa1[id_parent]'");
while($sg1=mysql_fetch_array($sg)){
$ins .=",".$sg1[id];
$st=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$sg1[id_parent]'");
while($sg1=mysql_fetch_array($st)){
$ins .=",".$st1[id];
}
}
}
return $ins;
}

function kategorije3($idkat,$patH)
{
$sa=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$idkat'");
$sa1=mysql_fetch_array($sa);
if($sa1[nivo]==1)
$insa= "<a href='$patH/videos/$sa1[ime1]__$sa1[id]/' class='sc1'>$sa1[ime]</a>&raquo; ";
elseif($sa1[nivo]==2)
{
$sg=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$sa1[id_parent]'");
$sg1=mysql_fetch_array($sg);
$insa= "<a href='$patH/videos/$sg1[ime1]__$sg1[id]/' class='sc1'>$sg1[ime]</a>&raquo; <a href='$patH/videos/$sg1[ime1]__$sg1[id]/$sa1[ime1]__$sa1[id]/' class='sc1'>$sa1[ime]</a>&raquo; ";
}
elseif($sa1[nivo]==3)
{
$sg=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$sa1[id_parent]'");
$sg1=mysql_fetch_array($sg);
$sb=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$sg1[id_parent]'");
$sb1=mysql_fetch_array($sb);
$insa= "<a href='$patH/videos/$sb1[ime1]__$sb1[id]/' class='sc1'>$sb1[ime]</a>&raquo; <a href='$patH/videos/$sb1[ime1]__$sb1[id]/$sg1[ime1]__$sg1[id]/' class='sc1'>$sg1[ime]</a>&raquo; <a href='$patH/videos/$sb1[ime1]__$sb1[id]/$sg1[ime1]__$sg1[id]/$sa1[ime1]__$sa1[id]/' class='sc1'>$sa1[ime]</a>&raquo; ";
}


return $insa;
}
function kategorije4($idkat)
{
$sa=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$idkat'");
$sa1=mysql_fetch_array($sa);
if($sa1[nivo]==1)
$insak= " $sa1[ime] ";
elseif($sa1[nivo]==2)
{
$sg=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$sa1[id_parent]'");
$sg1=mysql_fetch_array($sg);
$insak= " $sg1[ime], $sa1[ime], ";
}
elseif($sa1[nivo]==3)
{
$sg=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$sa1[id_parent]'");
$sg1=mysql_fetch_array($sg);
$sb=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id='$sg1[id_parent]'");
$sb1=mysql_fetch_array($sb);
$insak= " $sb1[ime], $sg1[ime], $sa1[ime], ";
}


return $insak;
}
function kategorije5($idkat)
{
$in="";
//echo kategorije1($likat1['id'], "kateg_proizvoda_new")."<br>";
$sa=mysql_query("SELECT * FROM kateg_proizvoda_new WHERE id_parent='$idkat'");
$c=0;
while($sa1=mysql_fetch_array($sa)){
if($c==0) $za=""; else $za=",";
$in .="$za".$sa1[id];
$c++;
}
if(empty($in)) $za=""; else $za=",";
return $idkat."$za".$in;
}
function back_category($kateg, $tabela)
{
global $patH;
$niz=array();
$ar=mysql_query("SELECT * FROM $tabela WHERE id=$kateg");
$ar1=mysql_fetch_array($ar);
//$niz[0]=$kateg;
$niz[1]="<a href='$patH/videos/$ar1[ime1]/' title='$ar1[ime]'>$ar1[ime]</a>";
if($ar1[id_parent]>0)
{
$zr=mysql_query("SELECT * FROM $tabela WHERE id=$ar1[id_parent]");
$zr1=mysql_fetch_array($zr);
$niz[2]="<a href='$patH/videos/$zr1[ime1]/' title='$zr1[ime]'>$zr1[ime]</a>";
}
if($zr1[id_parent]>0)
{
$cr=mysql_query("SELECT * FROM $tabela WHERE id=$zr1[id_parent]");
$cr1=mysql_fetch_array($cr);
$niz[3]="<a href='$patH/videos/$cr1[ime1]/' title='$cr1[ime]'>$cr1[ime]</a>";
}
$fir_kateg=array_reverse($niz);
$fkateg=implode(" &raquo; ",$fir_kateg)." &raquo;";
/*foreach($fir_kateg as $key => $val)
{

$fkateg[]=$fir_kateg[$key];
}*/
return $fkateg;
}
function format_ceneED($cc,$idv)
{
global $settings;
$cc=$cc*$idv;
$vas=" RSD";
$cc1=sprintf("%4.2f",$cc);
$cc2=number_format ($cc1, 2, ".", ",");
return $cc2.$vas;
}
function format_ceneS($cc,$idv)
{
global $settings;
if($idv>0)
$cc=$cc*$settings['evro_iznos'];
if($idv>0) $vas=" RSD"; else $vas=" &euro;";
$cc1=sprintf("%4.2f",$cc);
$cc2=number_format ($cc1, 2, ".", ",");
return $cc2.$vas;
}
function format_ceneS1($cc,$idv)
{
global $settings;
if($idv>0)
$cc=$cc*$settings['evro_iznos'];
 
$cc1=sprintf("%4.2f",$cc);
$cc2=number_format ($cc1, 2, ".", "");
return $cc2;
}
function format_ceneSS($cc,$idv)
{
global $settings;
if($idv>0)
$cc=$cc*$settings['evro_iznos'];

return $cc;
}
function format_ceneS2($cc,$idv)
{
global $settings;
if($idv>0)
$cc=$cc*$settings['evro_iznos'];
 $vas=" RSD"; 
$cc1=sprintf("%4.2f",$cc);
$cc2=number_format ($cc1, 2, ".", ",");
return $cc2.$vas;
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
//$kor=mysql_query("SELECT * FROM proizvodi_new WHERE id='$id'");
//$kor1=mysql_fetch_array($kor);

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
		$records = @mysql_query('SHOW FIELDS FROM `'.$table.'`');
		if ( @mysql_num_rows($records) == 0 )
			return false;
			$n=0;
		while ( $record = mysql_fetch_assoc($records) ) {
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
		$x = mysql_list_fields($database_conn, $table);


for ($i = 0; $i < 1; $i++) {
  $prim ="(`".mysql_field_name($x, $i)."`)";
}

		$structure .= "PRIMARY KEY". $prim."\n";
		$structure = @str_replace(",\n$", null, $structure);

		// Save all Column Indexes
	//	$structure .= $this->getSqlKeysTable($table);
		$structure .= "\n)";

		//Save table engine
		$records = @mysql_query("SHOW TABLE STATUS LIKE '".$table."'");
		
		if ( $record = @mysql_fetch_assoc($records) ) {
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
	mysql_query("$str");
	
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
		

		$records = mysql_query('SHOW FIELDS FROM `'.$table.'`');
		$num_fields = @mysql_num_rows($records);
		if ( $num_fields == 0 )
			return false;
		// Field names
		$selectStatement = "SELECT ";
		$insertStatement = "INSERT INTO `$fix$table` (";
		$hexField = array();
		for ($x = 0; $x < $num_fields; $x++) {
			$record = @mysql_fetch_assoc($records);
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

		$records = @mysql_query($selectStatement);
		$num_rows = @mysql_num_rows($records);
		$num_fields = @mysql_num_fields($records);
		// Dump data
		if ( $num_rows > 0 ) {
			$data .= $insertStatement;
			for ($i = 0; $i < $num_rows; $i++) {
				$record = @mysql_fetch_assoc($records);
				$data .= ' (';
				for ($j = 0; $j < $num_fields; $j++) {
					$field_name = @mysql_field_name($records, $j);
					if ( $hexField[$j] && (@strlen($record[$field_name]) > 0) )
						$data .= "0x".$record[$field_name];
					else
						$data .= "'".@str_replace('\"','"',@mysql_escape_string($record[$field_name]))."'";
					$data .= ',';
				}
				$data = @substr($data,0,-1).")";
				$data .= ( $i < ($num_rows-1) ) ? ',' : ';';
			
				//if data in greather than 1MB save
		
			}
			 mysql_query($data);
		
		}
	}
		function getTableData1($table,$fix,$idpage,$hexValue = false) {	

		$records = mysql_query('SHOW FIELDS FROM `'.$table.'`');
		$num_fields = @mysql_num_rows($records);
		if ( $num_fields == 0 )
			return false;
		// Field names
		$selectStatement = "SELECT ";
		$insertStatement = "INSERT INTO `$table` (";
		$hexField = array();
		for ($x = 0; $x < $num_fields; $x++) {
			$record = @mysql_fetch_assoc($records);
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

		$records = @mysql_query($selectStatement);
		$num_rows = @mysql_num_rows($records);
		$num_fields = @mysql_num_fields($records);
		// Dump data
		if ( $num_rows > 0 ) {
			$data .= $insertStatement;
			for ($i = 0; $i < $num_rows; $i++) {
				$record = @mysql_fetch_assoc($records);
				$data .= ' (';
				for ($j = 0; $j < $num_fields; $j++) {
					$field_name = @mysql_field_name($records, $j);
					if ( $hexField[$j] && (@strlen($record[$field_name]) > 0) )
						$data .= "".$record[$field_name];
						else
					{
					
					if($j>0 and $j!=$num_fields-1)
					{
						$data .= "'".@str_replace('\"','"',@mysql_escape_string($record[$field_name]))."'";
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
		
			 mysql_query($data);
		
		}
	}
		function getTableData2($table,$fix,$idpage,$hexValue = false) {	
$fix1 .=$fix."_";
		$records = mysql_query('SHOW FIELDS FROM `'.$table.'`');
		$num_fields = @mysql_num_rows($records);
		if ( $num_fields == 0 )
			return false;
		// Field names
		$selectStatement = "SELECT ";
		$insertStatement = "INSERT INTO `$fix1$table` (";
		$hexField = array();
		for ($x = 0; $x < $num_fields; $x++) {
			$record = @mysql_fetch_assoc($records);
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

		$records = @mysql_query($selectStatement);
		$num_rows = @mysql_num_rows($records);
		$num_fields = @mysql_num_fields($records);
		// Dump data
		if ( $num_rows > 0 ) {
			$data .= $insertStatement;
			for ($i = 0; $i < $num_rows; $i++) {
				$record = @mysql_fetch_assoc($records);
				$data .= ' (';
				for ($j = 0; $j < $num_fields; $j++) {
					$field_name = @mysql_field_name($records, $j);
					if ( $hexField[$j] && (@strlen($record[$field_name]) > 0) )
						$data .= "".$record[$field_name];
						else
					{
					
					if($j!=$num_fields-1)
					{
						$data .= "'".@str_replace('\"','"',@mysql_escape_string($record[$field_name]))."'";
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
		
		
		
		} 	 mysql_query($data);
	}


function del_slike($kolona,$idupisa,$jezik){
global $patH;
global $page_path2;

$pic=$page_path2."/galerija/$slika";
	$sel=mysql_query("SELECT * FROM slike_paintb WHERE $kolona='$idupisa' AND jezik='$jezik'");
while($sel1=@mysql_fetch_array($sel)){
$sl="slika";
$el=mysql_query("SELECT * FROM slike_paintb WHERE slika='$sel1[$sl]'");
if(strlen($sel1[$sl])>2 and mysql_num_rows($el)==1){
unlink("$page_path2/galerija/$sel1[$sl]");
unlink("$page_path2/galerija/thumb/$sel1[$sl]");
}
}
}
function del_files($kolona,$idupisa,$jezik){	
$sel=mysql_query("SELECT * FROM files WHERE $kolona='$idupisa' AND jezik='$jezik'");
while($sel1=@mysql_fetch_array($sel)){
$sl="opis";
$el=mysql_query("SELECT * FROM files WHERE opis='$sel1[opis]'");
if(strlen($sel1[opis])>2 and mysql_num_rows($el)==1){
unlink("$page_path2/files/$sel1[$sl]");
}
}
}
function del_galerije($id_page,$tabela){
global $patH;
global $page_path2;

$pic=$page_path2."/galerija/$slika";
	$sel=mysql_query("SELECT * FROM $tabela WHERE id_page='$id_page'");
while($sel1=mysql_fetch_array($sel)){
$sl="slika1";
$el=mysql_query("SELECT * FROM $tabela WHERE slika1='$sel1[$sl]'");
if(strlen($sel1[$sl])>2 and mysql_num_rows($el)==1){
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
 function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return urldecode(str_replace(":443","",$pageURL));
}
function iframeYT($ytcode, $width, $height, $autopl="") {
if($autopl==1) $autoplay="?autoplay=1";
if($ytcode!="") 
 $text= '<iframe src="http://www.youtube.com/embed/'.$ytcode.$autoplay.'" width="'.$width.'" height="'.$height.'" style="padding-right:5px;padding-bottom:5px;padding-top:5px;" frameborder="0"></iframe>';
 else $text="No video";
    return $text;
    
}
function youtubeVideo($text, $width, $height) {
if(mb_eregi("vimeo.com",$text) or mb_eregi("www.youtu",$text) or  mb_eregi("http://youtu.be",$text)){
 if(mb_eregi("vimeo",$text)){
 $idv = preg_replace ( '/[^0-9]/', '', $text );
 $text='<iframe src="http://player.vimeo.com/video/'.$idv.'?byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
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
        '<iframe src="http://www.youtube.com/embed/$1" width="'.$width.'" height="'.$height.'" style="padding-right:5px;padding-bottom:5px;padding-top:5px;" frameborder="0"></iframe><br />',
        $text);
        }
    return $text;
    }else return "";
}
function youtubeURL($text) {
if(mb_eregi("vimeo.com",$text) or mb_eregi("www.youtu",$text) or  mb_eregi("http://youtu.be",$text)){
 if(mb_eregi("vimeo",$text)){
 $idv = preg_replace ( '/[^0-9]/', '', $text );
 $text='http://player.vimeo.com/video/'.$idv.'';
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
        'http://www.youtube.com/embed/$1',
        $text);
        }
    return $text;
    }else return "";
}

function youtube_id_from_url($url) {
    $pattern = 
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return @$matches[1];
    }
    return false;
}

function isValidYoutubeURL($yid) {
$url = "http://www.youtube.com/watch?v=$yid";

    // Let's check the host first
    $parse = parse_url($url);
    $host = $parse['host'];
    if (!in_array($host, array('youtube.com', 'www.youtube.com'))) {
        return false;
    }

    $ch = curl_init();
    $oembedURL = 'www.youtube.com/oembed?url=' . urlencode($url).'&format=json';
    curl_setopt($ch, CURLOPT_URL, $oembedURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Silent CURL execution
    $output = curl_exec($ch);
    unset($output);

    $info = curl_getinfo($ch);
    curl_close($ch);

    if ($info['https_code'] !== 404)
        return true;
    else 
        return false;
}

function isEmbeddableYoutubeURL($url) {

    // Let's check the host first
    $parse = parse_url($url);
    $host = $parse['host'];
    if (!in_array($host, array('youtube.com', 'www.youtube.com'))) {
        return false;
    }

    $ch = curl_init();
    $oembedURL = 'www.youtube.com/oembed?url=' . urlencode($url).'&format=json';
    curl_setopt($ch, CURLOPT_URL, $oembedURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($output);

    if (!$data) return false; // Either 404 or 401 (Unauthorized)
    if (!$data->{'html'}) return false; // Embeddable video MUST have 'html' provided 

    return true;
}
function getVimeoThumb($id) {
if($id!="")
{
    $data = @file_get_contents("http://vimeo.com/api/v2/video/$id.json");
    $data = json_decode($data);
    return $data[0]->thumbnail_medium;
}
}
function VimeoDuration($id) {
if($id!="")
{
    $data = @file_get_contents("http://vimeo.com/api/v2/video/$id.json");
    $data = json_decode($data);
    return $data[0]->duration;
}
}
function parse_vimeo($link){
 
        $regexstr = '~
            # Match Vimeo link and embed code
            (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
            (?:                         # Group vimeo url
                https?:\/\/             # Either http or https
                (?:[\w]+\.)*            # Optional subdomains
                vimeo\.com              # Match vimeo.com
                (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
                \/                      # Slash before Id
                ([0-9]+)                # $1: VIDEO_ID is numeric
                [^\s]*                  # Not a space
            )                           # End group
            "?                          # Match end quote if part of src
            (?:[^>]*></iframe>)?        # Match the end of the iframe
            (?:<p>.*</p>)?              # Match any title information stuff
            ~ix';
 
        preg_match($regexstr, $link, $matches);
 if($matches[1]=="")
 {
 $must=explode("/",$link);
 $must1=array_reverse($must);
 if($must1[0]>0)
 $matches[1]=$must1[0];
 else
 $matches[1]=$must1[1];
 }
        return $matches[1];
 
    }
 function iframeVI($ytcode, $width, $height, $autopl="") {
 
if($autopl==1) $autoplay="?autoplay=1";
if($ytcode!="") 
 $text= '<iframe src="//player.vimeo.com/video/'.$ytcode.$autoplay.'" width="'.$width.'" height="'.$height.'" style="padding-right:5px;padding-bottom:5px;padding-top:5px;" frameborder="0"></iframe>';
 else $text="No video";
    return $text;
    
}   
function getDuration($yid){
 $url = "http://www.youtube.com/watch?v=$yid";
        parse_str(parse_url($url,PHP_URL_QUERY),$arr);
        $video_id=$arr['v']; 


        $data=@file_get_contents('http://gdata.youtube.com/feeds/api/videos/'.$video_id.'?v=2&alt=jsonc');
        if (false===$data) return false;

        $obj=json_decode($data);

        return @$obj->data->duration;
    }

function getVimeoInfo($link)
 {
    if (preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $link, $match)) 
    {
        $id = $match[1];
    }
    else
    {
        $id = substr($link,10,strlen($link));
    }

    if (!function_exists('curl_init')) die('CURL is not installed!');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/$id.php");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = unserialize(curl_exec($ch));
    $output = $output[0];
    curl_close($ch);
    return $output;
}
function save_image_local($thumbnail_url)
    {

         //for save image at local server
         $filename = time().'_hbk.jpg';
         $fullpath = '../../app/webroot/img/videos/image/'.$filename;

         file_put_contents ($fullpath,file_get_contents($thumbnail_url));

        return $filename;
    }
 function header_404()
{
global $page_path2;

  header("Status: 404 Not Found");
  @include("404.html");
  echo "<title>Izbrana stranica ne postoji</title>";
  exit();
}
function ae_detect_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}
function base_ret($base)
{
$baser=explode("/", strip_tags($base));
$baser=array_filter($baser);
//$baser=implode("/",$baser);
return $baser;
}
function base_ret_rev($base)
{
$baser=explode("/", strip_tags($base));
$baser=array_filter($baser);
$baser=array_reverse($baser);
//$baser=implode("/",$baser);
return $baser;
}
function check_image($slika)
{
$form_slika=array("jpg","jpeg","JPG","JPEG","gif","GIF","png","PNG");
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
function ifempty($val,$ns="")
{
if($val!="") $val=$val; else 
if($ns==1)
$val=0;
else
$val="";
return trim($val);
}
function datef($tip="",$hi="")
{
if($hi==1) $his=" H:i";
else
if($hi==2) $his=" H:i:s";
else
$his="";
if($tip=="us")
$datume=date("Y-m-d$his");
else
if($tip=="")
$datume=date("d-m-Y$his");
}

function send_email($tip="",$to, $from_email, $replyto_email, $subject, $from_name, $html_text, $alt_text)
{
global $host_smtp;
global $port_smtp;
global $password_smtp;
global $username_smtp;
$mail             = new phpmailer();
if($tip=="smtp")
{
$mail->IsSMTP();  
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = "$host_smtp"; // sets the SMTP server
$mail->Port       = "$port_smtp";  // set the SMTP port for the GMAIL server
$mail->Username   = "";       // SMTP account username
$mail->Password   = $pass_smtp;        // SMTP account password
}
elseif($tip=="mail" or $tip=="")
$mail->Mailer   = "mail";
$mail->From=$from_email;
$mail->FromName = $from_name;
$mail->AddReplyTo($replyto_email);
$mail->Subject = "$subject";
 
$mail->Body=$html_text;
$mail->AltBody = $alt_text;
    
$mail->AddAddress($to);
 
 
if($_SERVER["SERVER_NAME"]!="localhost")
{
 if($mail->Send()) return 1; else return 0;
}     
}

/************************ login funcition **************/

 
function meta_tags_new($title, $desc, $key)
{
$vrati .=PHP_EOL.'<title>'.strip_tags($title).'</title>'.PHP_EOL.'
<meta name="description" content="'.strip_tags($desc).'" />'.PHP_EOL.'
<meta name="Keywords" content="'.strip_tags($key).'" />'.PHP_EOL.'';
return $vrati;
}
/******************* end login function ******************/
function tagovi($tag)
{
$tagovi=explode(",", $tag);
return $tagovi;
}
function sharebutton()
{
?>
<div   style="float:right;margin-bottom:2px;">

<span class='st_facebook_hcount' displayText='Facebook'></span>
<span class='st_googleplus_hcount' displayText='Google +'></span>
<span class='st_twitter_hcount' displayText='Tweet'></span>
<span class='st_pinterest_hcount' displayText='Pinterest'></span>
<?php 
if($kdkd>0)
{
?>
<span class='st_instagram_hcount' displayText='Instagram Badge' st_username='saleksandrou'></span>
<?php 
}
?>
</div>
<?php 
}
function sharebuttons()
{
?>
<div class="social-likes" data-url="<?php echo curPageURL()?>" data-title="fany video" style="float:right;margin-bottom:-2px;">

	<div class="facebook" title="Share link on Facebook">Facebook</div>
	<div class="twitter" title="Share link on Twitter">Twitter</div>
	<div class="plusone" title="Share link on Google+">Google+</div>
	<div class="pinterest" title="Share image on Pinterest" data-media="">Pinterest</div>

</div>
<?php 
}
function sharebuttonl()
{
?>
<div   style="float:right;margin:2px 0px 0px 0px;">

<span class='st_facebook_hcount' displayText='Facebook'></span>
<span class='st_googleplus_hcount' displayText='Google +'></span>
<span class='st_twitter_hcount' displayText='Tweet'></span>
<span class='st_pinterest_hcount' displayText='Pinterest'></span>
<?php 
if($kdkd>0)
{
?>
<span class='st_instagram_hcount' displayText='Instagram Badge' st_username='saleksandrou'></span>
<?php 
}
?>
</div>
<?php 
}
function sharebutton1()
{
?>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<div class="addthis_sharing_toolbox"></div>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e6e52ce4fc756a1"></script>

<?php 
}
function num_years($birth)
{
$birthdate = new DateTime($birth);
$today     = new DateTime();
$interval  = $today->diff($birthdate);
$interval->format('%y years');
return $interval;
}


/************ add del column in table *******************/
function checkFieldExists($tableName,$columnName)
{

 
   $sql = "show columns from $tableName";
   $data = mysql_query($sql);
   while($data_row=mysql_fetch_array($data)){
      $column = $data_row['Field'];
      if($column== $columnName)
      {
         return true;
      }
   }
   return false;

} //end of function  
 

function alter($lang,$page_add_array,$tips,$lang_old="")
{
foreach($page_add_array as $key=>$value)
{
$row="";
$drop="";
$field_name=array("");
$resulta = mysql_query("SELECT * FROM $key limit 1");
  while($row=mysql_fetch_array($resulta))
   {
    $field_name=array_keys($row);
    
   }
 //array_shift($field_name);
$gova=mysql_num_rows($resulta); 
$p=0;
 foreach($value as $keys=>$values)
{

if($p==0)  $zap=""; else $zap=", ";

 
if($values=="varchar") $tip="VARCHAR(150)"; else $tip="TEXT";

/*if($gova>0)
{
if($tips=="add")
{    
if(!in_array($keys.$lang, $field_name))          
{
$row .=$zap."ADD COLUMN $keys$lang $tip NULL";

$p++;
}
}
if($tips=="del")
{
if(in_array($keys.$lang, $field_name))
{
$drop .=$zap."DROP  `$keys$lang`";
$p++;
}
}
}
else
{
*/
if($tips=="add")
{   
if(!checkFieldExists($key,$keys.$lang))           
{
$row .=$zap."ADD COLUMN $keys$lang $tip NULL";

$p++;
}
}
if($tips=="del")
{
if(checkFieldExists($key,$keys.$lang))
{

$drop .=$zap."DROP  `$keys$lang`";
$p++;
}
}
if($tips=="ren" and $lang!=$lang_old)
{
if(checkFieldExists($key,$keys.$lang_old))
{

$ren .=$zap."CHANGE `$keys$lang_old` `$keys$lang` $tip NULL";
$p++;
}
}
 
 
}
echo $row;
 
if($drop!="" and $tips=="del")
{
//echo $key."===".$drop."<br>";
if(!mysql_query("ALTER TABLE `$key` $drop")) echo mysql_error();
}
if($row!="" and $tips=="add")
{
if(!mysql_query("ALTER TABLE $key $row AFTER id")) echo mysql_error();
}
if($ren!="" and $tips=="ren")
{
if(!mysql_query("ALTER TABLE `$key` $ren")) echo mysql_error();
}

}
}
$cur_link=curPageURL();

function fajlovi($ul, $boja, $dirk, $col, $zz1, $id_page,$lod="",$load_name="",$nono="")
{
?>
<ul  class='ul divu <?php echo $boja ?>' id="polje<?php echo $ul?>"><?php //echo $zz1[include_file_vrh]?>
<?php 
$dir="../include-pages/$dirk";
$exo=explode(",",$zz1["include_file_$col"]);
//$files = scandir($dir);
//$count_dir=count($files)-2;

if(isset($_POST["include_$col"])) 
$exo=$_POST["include_$col"];


if(implode("",$exo)!="")
{
foreach($exo as $key => $value)
{
/*$teva=preg_replace("/text[1-9]+.php/","text.php",$value);
if($teva=="text.php")
{
$ima=mysql_num_rows(mysql_query("SELECT * FROM pages_text_include WHERE  id_page='$id_page' AND include_file_$col='$value'"));
$imas="($ima)";
}else $imas="";*/

if(mb_eregi("text-",$value))
{
$la=mysql_query("SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysql_fetch_array($la))
 {
$jezici[]=$la1['jezik']; 
 }
$firstlang=$jezici[0];
$id_text=preg_replace('#[^0-9]#i', '', $value);
$ima=mysql_query("SELECT * FROM pages_text_lang WHERE  id_text='$id_text' AND lang='$firstlang'");
$ima1=mysql_fetch_assoc($ima);
 
if($id_get>0) $id_get=$id_get; else $id_get=$id_text;
$value="<a href='index.php?base=admin&page=page_edit_content&id=$id_text' target='_blank'>".$ima1['naslov']."</a>";
echo "<li$zakla><label style='display:block'><input type='checkbox' name='include_".$col."[]' value='text-$id_get' checked /> $value</label></li>";
}else
{
//if($nono==1) $disme="disabled"; else $disme="";
 
echo "<li$zakla><label style='display:block'><input type='checkbox' name='include_".$col."[]' value='$value' checked /> $value</label></li>";
}


}
}
  
if ($handle = opendir($dir) and $nono!=1) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {
 
if(!in_array($entry,$exo) and $entry!="text.php")
{

echo "<li><label style='display:block'><input type='checkbox' name='include_".$col."[]' value='$entry' /> $entry</label></li>";
}

        }
    }

    closedir($handle);
}
if($lod!="" and !in_array($lod,$exo))
{
$mikis=explode("-",$lod);

echo "<li><label style='display:block'><input type='checkbox' name='include_".$col."[]' value='$lod' /> <a href='index.php?base=admin&page=page_edit_content&id=$mikis[1]' target='_blank'>$load_name</a></label></li>";
}
?>
</ul>
<?php 
}

function fajlovi_tekst($id, $id_page,  $zz1, $col, $ie_page=0)
{
?>
<ul  class='divu' id="polje<?php echo $ul?>"><?php //echo $zz1[include_file_vrh]?>
<?php 
 
$exo=explode(",",$zz1);



if(implode("",$exo)!="")
{
foreach($exo as $key => $value)
{
$teva=preg_replace("/text[1-9]+.php/","text.php",$value);
if($teva!="text.php") 
{
$disab="disabled";
$boja=' style="color:#999;"';
}
else{
$disab="";
$boja="";
}
 
$ima=mysql_num_rows(mysql_query("SELECT * FROM pages_text_include WHERE id_tekst='$id' AND id_page='$id_page' AND include_file_$col='$value'"));
if($ima>0) $sel="checked"; else $sel="";
echo "<li><label style='display:block'><input type='checkbox' name='include_".$col."[]' value='$value' $disab $sel /> <span$boja>$value</span></label></li>";


}
}
  


?>
</ul>
<?php 
}
function hashlink($id,$niza="",$k,$filt)
{
$giza=$niza;
if(isset($niza) and $niza!="")
{
if($niza[$filt]!="")
{
$niz=explode("-",$niza[$filt]);
if(in_array($id,$niz))
{
$na=array_search($id,$niz);
unset($niz[$na]);
$niza[$filt] =implode("-",$niz);
} else
{
$niz[]=$id;
$niza[$filt] =implode("-",$niz);
}

} 
if($niza["p"]!="" and mb_eregi("-",$niza["p"]))
{
$fus=explode("-",$niza["p"]);
$niza["p"]=$fus[1];
}
$niza=array_filter($niza);
$ret ="&".http_build_query($niza);
 
 
 
}
else
$ret ="&$filt=$id";

if(!isset($niza[$filt]) and isset($niza) and $giza[$filt]!=$id)
$ret ="&".http_build_query($niza)."&$filt=$id";

return $ret;
}
 function hashlink1($id,$niz="", $niz1="", $k)
{
if(isset($niz) and $niz!="" and $k==1)
{
if(in_array($id,$niz))
{
$na=array_search($id,$niz);
unset($niz[$na]);
$vrati =implode("-",$niz);
} else
{
$niz[]=$id;
$vrati =implode("-",$niz);
}
}elseif($k==1)
$vrati =$id;

if($vrati!="")
$ret="&brend=$vrati";
else
$ret="";


if(isset($niz1) and $niz1!="" and $k==2)
{
if(in_array($id,$niz1))
{
$na=array_search($id,$niz1);
unset($niz1[$na]);
$vrati1 =implode("-",$niz1);
} else
{
$niz1[]=$id;
$vrati1 =implode("-",$niz1);
}
}elseif($k==2)
$vrati1 =$id;

if($vrati1!="")
$ret1="&filt=$vrati1";
else
$ret1="";

 

if($k==2 and count($niz)>0)
$ret ="&brend=".implode("-",$niz);

if($k==1 and count($niz1)>0)
$ret1 ="&filt=".implode("-",$niz1);

return $ret.$ret1;
}
function klase($tip,$data)
{
echo "<ul  class='divu' style='margin-top:0px;padding-top:0px;'>"; 
echo "<li><label style='display:block'><input type='radio' name='klasa_$tip' value='' /> Nijedna</label></li>";
for($i=1;$i<9;$i++)
{
if($data["class_$tip"]=="$tip$i") $che="checked"; else $che="";
echo "<li><label style='display:block'><input type='radio' name='klasa_$tip' value='$tip$i' $che id='$tip$i' /> ".$tip."$i</label></li>";
}
echo "</ul>";
}

function strip_html_tags( $text )
{
// Remove invisible content
    $text = preg_replace(
        array(
            //ADD a (') before @<head ON NEXT LINE. Why? see below
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );
    return strip_tags( $text );
}
?>
