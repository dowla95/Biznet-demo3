<?php 
if(isset($sarray['va'])) 
{ 
if($sarray['va']==2) 
{ 
setcookie("valuta", "", time()-60*60*24*30, "/"); 
$sirt=preg_replace("/(^|\?)va=2*/","",curPageURL()); 
} 
elseif($sarray['va']==1) 
{ 
setcookie("valuta", 2, time()+60*60*24*30, "/"); 
$sirt=preg_replace("/(^|\?)va=1*/","",curPageURL()); 
} if(isset($sarray['pron']) and $sarray['pron']>0)
header("location: ". $patH1."/?word=".strip_tags($sarray['word'])."&pron=".strip_tags($sarray['pron'])."");
else
header("location: ". $sirt); 
}
if(isset($_COOKIE['valuta']))  
{ 
$idvalute=""; 
$valut="€"; 
} 
else  
{ 
$idvalute=1; 
$valut="RSD"; 
} 
if(isset($_SESSION['userid']) and $_SESSION['userid']>0) 
{ 
$us=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id='$_SESSION[userid]'"); 
$us1=mysqli_fetch_assoc($us);
}
/* provera postojanja emaila ili nicka */
if(isset($_POST['check_vr']) and $_POST['check_vr']!=''){
$kolona=strip_tags($_POST['kolona']);
$vred=strip_tags(trim($_POST['check_vr']));
if(isset($_SESSION['userid'])) $iskljuci=" AND user_id!=".$_SESSION['userid']; else $iskljuci="";
$mm=mysqli_num_rows(mysqli_query($conn, "SELECT $kolona FROM users_data WHERE $kolona=".safe($vred)."$iskljuci"));
if($mm>0 and $kolona=='email')
$msgr='Email već postoji u bazi!';
elseif($mm>0)
$msgr='Nick već postoji u bazi!';
else
$msgr='';
$ende=0;
}
if((isset($_POST['reg_cand']) or isset($_POST['change_cand'])) and isset($_FILES['avatar']['tmp_name']) and $_FILES['avatar']['tmp_name']!="")
{
$folder='temp/'.session_id();
if(!is_dir($page_path2.SUBFOLDER."/".$folder)) {
mkdir($page_path2.SUBFOLDER."/".$folder, 0777, true);
mkdir($page_path2.SUBFOLDER."/".$folder."/thumb", 0777, true);
}
$iimesl=explode('.', $_FILES['avatar']['name']);
$ext= end($iimesl);
$ext=strtolower($ext);
$formati=array("jpg","jpeg","gif","png");
if(!in_array($ext, $formati)) {
$msgr='Slika nije odgovarajuceg formata';
$ende=0;
} else {
$slika =UploadSlika($_FILES['avatar']['name'],$_FILES['avatar']['tmp_name'],$_FILES['avatar']['type'],"$page_path2/$folder/",1,1);

$msgr="<input type='hidden' value='$slika' name='avatarce' class='avatarce'>";
$ende=1;
}
//exit();
} else
/* registracija korisnika */
if(isset($_POST['reg_cand']))
{
$ende=0;
$fax=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($_POST['email'])."");
$fx1=mysqli_fetch_assoc($fax);
if(mb_eregi('-',$_POST['nickname'])) {
$prim=str_replace("----","-",$_POST['nickname']);
$prim=str_replace("---","-",$prim);
$prim=str_replace("--","-",$prim);

$pr=explode("-",$prim);
if($pr[0]=='')
array_shift($pr);
$brib=count($pr);
if($pr[$brib]=='')
array_pop($pr);
$nick= implode("-",$pr);
} else $nick=$_POST['nickname'];


$nax=mysqli_query($conn, "SELECT * FROM users_data WHERE nickname=".safe($nick)."");
$nx1=mysqli_fetch_assoc($nax);

if($nick=="" or $_POST['ime']=="" or $_POST['email']=="" or $_POST['password']=="" or $_POST['password1']=="" or $_POST['pbroj']=="" or $_POST['telefon']=="" or $_POST['grad']=="" or $_POST['ulica_broj']=="" or ($_POST['firma-lice']=='firma' and ($_POST['nazivfirme']=='' or $_POST['pib']=='')))
$msgr=$arrwords['niste_ispunili'];
else 
if($_POST["uslovi"]!=1) 
{
$msgr=$arrwords2['uslovi_cekiranje1']; 
} 
else 
if($_POST["password"]!=$_POST["password1"]) 
{ 
$msgr=$arrwords2['sifre_nejednake']; 
} 
else
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false) 
{ 
$msgr=$arrwords['email_novalid']; 
} 
else 
if($fx1['user_id']>0) 
{ 
$msgr=$arrwords['email_postoji']; 
} 
else 
if($nx1['user_id']>0)
{
$msgr=$arrwords['nick_postoji'];
}
else
{ 
if(isset($_POST['avatarce']) and $_POST['avatarce']!='')
$iavatar=", avatar='".$_POST['avatarce']."'"; else $iavatar="";

if($_POST['firma-lice']=='firma') $firma=1; else $firma=0;

if(isset($_POST['vesti']) and $_POST['vesti']>0) $ivesti=1; else $ivesti=0; 
//$br1=md5(md5(strip_tags($_POST['password']).time())); 
$password_crypted = tep_encrypt_password(strip_tags($_POST['password'])); 
$date_birth=$post_niz['year']."-".$post_niz['month']."-".$post_niz['day']; 
$randi=gen_rand(); 

if(isset($_POST['nazivfirme']) and strlen($_POST['nazivfirme'])>2)
$nazivfirme=", nazivfirme=".safe($_POST['nazivfirme']);
else
$nazivfirme=", nazivfirme=NULL";

if(isset($_POST['pib']) and strlen($_POST['pib'])>2)
$pib=", pib=".safe($_POST['pib']);
else
$pib=", pib=NULL";

$ime=$_POST['ime'];
if(!mysqli_query($conn, "INSERT INTO users_data SET firma=$firma, tr=".safe($_POST['racun']).", ime=".safe($ime).$nazivfirme.", email=".safe($_POST['email']).", nickname=".safe($nick).$pib.", password=".safe($password_crypted).", telefon=".safe($_POST['telefon'])."$iavatar, grad=".safe($_POST['grad']).", postanski_broj=".safe($_POST['pbroj']).", ulica_broj=".safe($_POST['ulica_broj']).", datum='".date("Y-m-d")."', vesti='$ivesti', randkod='$randi'")) echo mysqli_error();
$zid=mysqli_insert_id($conn);


if(isset($_POST['avatarce']) and $_POST['avatarce']!='') {
if(!is_dir($page_path2.'/avatars/'.$zid)) {
mkdir($page_path2.'/avatars/'.$zid, 0777, true);
mkdir($page_path2.'/avatars/'.$zid.'/thumb', 0777, true);
}
if(is_file($page_path2.'/temp/'.session_id()."/".$_POST['avatarce'])) {
@rename($page_path2.'/temp/'.session_id()."/".$_POST['avatarce'], $page_path2.'/avatars/'.$zid."/".$_POST['avatarce']);
@rename($page_path2.'/temp/'.session_id()."/thumb/".$_POST['avatarce'], $page_path2.'/avatars/'.$zid."/thumb/".$_POST['avatarce']);
}
}

if($ivesti==1) 
@mysqli_query($conn, "INSERT INTO subscribers SET email=".safe($_POST['email']).", akt=1, time='".time()."'"); 
$msgr=$arrwords2['registracija_uspesna']; 
$ende=1; 
$green="_green";
$subject=$arrwords2['subject_mail']." - ".date("Y-m-d"); 
$from_name=$domen;  
$for_admin="<br><b>Podaci novo registrovanog korisnika:</b> <br>"; 
$for_admin .=" 
Ime: $_POST[ime]<br> 
Email: $_POST[email]<br> 
Grad: $_POST[grad]<br> 
"; 
$texte=html2plain($for_admin,10000000);
$linka="<a href='".$patH1."/".$all_links[10]."/?activate=".$randi."'>".$patH1."/".$all_links[10]."/?activate=".$randi."</a>"; 
$akti_tekst=sprintf($arrwords2['reg_send_tekst'], $_POST['ime'], $domen, $linka, $patH1, $domen); 
$akti_tekst1=strip_html_tags($akti_tekst); 
//echo $akti_tekst;  
send_email("mail", $_POST['email'], $settings["from_email"], $settings["from_email"], $subject, $from_name, $akti_tekst, $akti_tekst1);  send_email("mail", $settings["email_zaemail"], $settings["from_email"], $settings["from_email"], "New user - $_POST[ime]", $from_name, $for_admin, $texte); 
} 
} 
else
if(isset($_POST['change_cand']) and $_SESSION['userid']>0)
{
if($_POST['email']!="")
{
$fax=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($_POST['email'])." AND NOT user_id=$_SESSION[userid]");
$fx1=mysqli_fetch_assoc($fax);
}

if($_POST['ime']=="" or $_POST['email']=="" or $_POST['pbroj']=="" or $_POST['grad']=="" or $_POST['ulica_broj']=="" or $_POST['telefon']=="" or ($_POST['firma-lice']=='firma' and ($_POST['nazivfirme']=='' or $_POST['pib']=='')))
$msgr=$arrwords['niste_ispunili'];
else
if($_POST["password"]!=$_POST["password1"])
{
$ende=0;
$msgr=$arrwords2['sifre_nejednake'];
}
else
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false)
{
$ende=0;
$msgr=$arrwords['email_novalid'];
}
else
if($fx1['user_id']>0)
{
$ende=0;
$msgr=$arrwords['email_postoji'];
}
else
{
$password_crypted = tep_encrypt_password(strip_tags($_POST['passwordR']));
if($_POST["passwordR"]!="" and $_POST["passwordR1"]!="")
$novi_pass=", password=".safe($password_crypted);
else
$novi_pass="";

if(isset($_POST['avatarce']) and $_POST['avatarce']!='' and !isset($_POST['avatar_del'])) {
if(!is_dir($page_path2.'/avatars/'.$_SESSION['userid'])) {
mkdir($page_path2.'/avatars/'.$_SESSION['userid'], 0777, true);
mkdir($page_path2.'/avatars/'.$_SESSION['userid'].'/thumb', 0777, true);
}
if(is_file($page_path2.'/temp/'.session_id()."/".$_POST['avatarce'])) {
@rename($page_path2.'/temp/'.session_id()."/".$_POST['avatarce'], $page_path2.'/avatars/'.$_SESSION['userid']."/".$_POST['avatarce']);
@rename($page_path2.'/temp/'.session_id()."/thumb/".$_POST['avatarce'], $page_path2.'/avatars/'.$_SESSION['userid']."/thumb/".$_POST['avatarce']);
}
@unlink($page_path2.'/avatars/'.$_SESSION['userid']."/".$_POST['avatar_curent']);
@unlink($page_path2.'/avatars/'.$_SESSION['userid']."/thumb/".$_POST['avatar_curent']);
$avatar=", avatar='".$_POST['avatarce']."'";
}
else if(isset($_POST['avatar_del'])) {
@unlink($page_path2.'/avatars/'.$_SESSION['userid']."/".$_POST['avatar_curent']);
$avatar=", avatar=NULL";
} else $avatar="";
if($_POST['firma-lice']=='firma' and isset($_POST['nazivfirme']) and $_POST['nazivfirme']!='')
$zafirmu=", nazivfirme=".safe($_POST['nazivfirme']).", pib=".safe($_POST['pib']);
else
$zafirmu=", nazivfirme=NULL, pib=NULL";
if($_POST['firma-lice']=='firma') $firma=1; else $firma=0;
//$br1=md5(md5(strip_tags($_POST['password']).time()));
if(isset($_POST['vesti']) and $_POST['vesti']>0) $ivesti=1; else $ivesti=0;
if(!mysqli_query($conn, "UPDATE users_data SET firma=$firma, ime=".safe($_POST['ime']).", tr=".safe($_POST['racun']).", email=".safe($_POST['email'])."$avatar$zafirmu, telefon=".safe($_POST['telefon']).", grad=".safe($_POST['grad']).", postanski_broj=".safe($_POST['pbroj']).", ulica_broj=".safe($_POST['ulica_broj']).", datum='".date("Y-m-d")."', vesti='$ivesti'$novi_pass WHERE user_id=$_SESSION[userid]")) echo mysqli_error();
//$nus=mysqli_num_rows(mysqli_query($conn, "UPDATE subscribers WHERE email=".safe($_POST['email'])."")); //ovako je bilo
$nus=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($_POST['email'])." AND vesti=1")); // a ovo sam dodao jer je prijavljivalo gresku,prijavljuje gresku i na izvornom sajtu xxxxxxxx
$mus=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM subscribers WHERE email=".safe($_POST['email'])." AND akt=0"));
if($nus==1 and $ivesti==1)
mysqli_query($conn, "INSERT INTO subscribers SET email=".safe($_POST['email']).", akt=1, time='".time()."'");
elseif($nus==0)
mysqli_query($conn, "DELETE FROM subscribers WHERE email=".safe($_POST['email'])."");

$msgr=$arrwords2['uspesna_izmena'];
$ende=1;
}
}

if(isset($_POST['ocena'])) {
$oce=explode("-",$_POST['ocena']);
if(isset($_SESSION['ocenjeno'.$oce[1]]))
echo "Već ste ocenili ovaj proizvod!";
else {

$fax=mysqli_query($conn, "SELECT * FROM pro WHERE id=".$oce[1]);
$fx1=mysqli_fetch_assoc($fax);
if(strlen($fx1['ocena'])>2)
{
$soce=explode("-",$fx1['ocena']);
$ocenaplus =$soce[0]*1;
$ocenaplus +=$oce[0];
$ocenacount=$soce[1]*1;
$ocenacount +=1;
$zajedno="$ocenaplus-$ocenacount";
} else
$zajedno=$oce[0]."-1";
mysqli_query($conn, "UPDATE pro SET ocena='$zajedno' WHERE id=".$oce[1]);
$_SESSION['ocenjeno'.$oce[1]]=1;
echo "Hvala Vam što ste ocenili ovaj proizvod!";
}
}

if(isset($_POST['add_email'])) 
{ 
if($_POST['email']=="") 
echo "0##Niste upisali email adresu ! ! !";
else 
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false) 
echo "0##Email adresa nije validna";
else 
{ 
$zizi=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM subscribers WHERE email=".safe(strip_tags($_POST['email']))."")); 
if($zizi>0) 
echo '0##Email koji ste upisali već postoji u našoj bazi!';
else 
{
mysqli_query($conn, "INSERT INTO subscribers SET email=".safe(strip_tags($_POST['email'])).", time='".time()."'"); 
echo '1##Email je uspisan u našu bazu. Hvala Vam! :)';
} 
} 
}
if(isset($_POST['iskljucipopup']) and $_POST['iskljucipopup']==1)
{
setcookie(
  "iskljucipopup",
  "1",
  time() + (24 * 60 * 60)
);
}



if(isset($_POST['obavestime']) and strlen($_POST['obavestime'])>4) {
$ni=mysqli_query($conn, "SELECT * FROM obavestenja_proizvod WHERE email=".safe($_POST['obavestime'])." AND pro=".safe($_POST['pro']));
$nin=@mysqli_num_rows($ni);
if (!mb_eregi("^[A-Z0-9._%-]+[@][A-Z0-9._%-]+[.][A-Z]{2,6}$", $_POST['obavestime']))
{
echo "Email adresa nije validna!";

} else
if($nin>0)
echo "Već ste pohvali zahtev da dobijete obaveštenje za ovaj proizvod!";
else
{
mysqli_query($conn, "INSERT INTO obavestenja_proizvod SET email=".safe($_POST['obavestime']).", pro=".safe($_POST['pro']).", datum='".date("Y-m-d H:i:s")."'");



$aaa=sprintf($langa['obavestmsg'][0], $_POST['obavestime'],  $_POST['link'], $_POST['naziv'], $patH1, $domen);
$aaa1=strip_html_tags($aaa);
$subject="Zahtev za obavestenjem - ".$_POST['naziv'];
$from_name=$domen." - ".$langa['from_site'][0];
send_email("mail", $settings['email_zaemail'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);

echo 1;
}
}

if(isset($_POST['tips']) and $_POST['tips']=="obavesti" and $_POST['id']>0) {
$fi=mysqli_query($conn, "SELECT *, p.id as id, o.id as ido FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id
INNER JOIN obavestenja_proizvod o ON o.pro=p.id
WHERE pl.lang='rs' AND o.id=".safe($_POST['id']));
$nin=mysqli_fetch_assoc($fi);

mysqli_query($conn, "UPDATE obavestenja_proizvod SET obavesten=1 WHERE id=".safe($_POST['id'])."");



$aaa=sprintf($langa['obavestOpis'],  "<a href='$patH1/proizvodi/$nin[ulink]/'><img src='$patH/galerija/thumb/$nin[slika]'></a>", "<a href='$patH1/proizvodi/$nin[ulink]/'>".$nin['naslov'].'</a>', "<a href='$patH1/proizvodi/$nin[ulink]/'>LINK</a>", "<a href='$patH1'> $domen</a>");
$aaa1=strip_html_tags($aaa);
$subject=$langa['obavestSubj']." ".$nin['naslov'];
$from_name=$domen." - ".$langa['from_site'][0];
send_email("mail", $nin['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);

echo 1;

}


if(isset($_POST['delnal']) and $_SESSION['userid']>0) 
{ 
$di=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".$_SESSION['userid'].""); 
$di1=mysqli_fetch_assoc($di); 
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/".$di1["civi1"])) 
{ 
unlink($page_path2.SUBFOLDER.GALFOLDER."/".$di1["civi1"]); 
unlink($page_path2.SUBFOLDER.GALFOLDER."/thumb/".$di1["civi1"]); 
} 
$uh=mysqli_query($conn, "SELECT * FROM users_slike WHERE user_id=$_SESSION[userid] ORDER BY id DESC"); 
while($uh1=mysqli_fetch_assoc($uh)) 
{ 
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/".$uh1["slika"])) 
{ 
unlink($page_path2.SUBFOLDER.GALFOLDER."/".$uh1["slika"]); 
unlink($page_path2.SUBFOLDER.GALFOLDER."/thumb/".$uh1["slika"]); 
} 
} 
mysqli_query($conn, "DELETE FROM users_data WHERE user_id=$_SESSION[userid]"); 
mysqli_query($conn, "DELETE FROM users_slike WHERE user_id=$_SESSION[userid]"); 
unset($_SESSION); 
header("location: $patH1"); 
}
if($_POST['posalji']) 
{
include("$page_path2/private/include/class.phpmailer.php");
//if($_POST[imes]=="" or $_POST[emails]=="" or $_POST[obraz]=="" or $_POST[telefon]=="" or $_POST['captcha']=="") 
//$msgr=$arrwords['prazna_polja'];else 
if($_SESSION["captcha"]!=$_POST["captcha"]) 
//$msgr=$arrwords['pogresan_kod']; 
{ 
?> 
<script> 
$( document ).ready(function() { 
alert("<?php echo $arrwords['pogresan_kod']; ?>"); 
});
</script> 
<?php 
} 
else 
/*if(filter_var(trim($_POST[emails]), FILTER_VALIDATE_EMAIL)===false)  
$msgr=$arrwords['email_novalid']; 
else*/ 
{ 
$vreme=date("d-m-Y H:i:s", time()); 
$zaslanje=" 
Poslato u $vreme<br><br> 
Poruka sa Vašeg sajta
<br><br> 
<br>Naslov: $_POST[imes] 
<br>Email: $_POST[emails] 
<br>Telefon: $_POST[telefon] 
<br>Poruka:<br>".nl2br($_POST['obraz'])." 
";
$mail = new phpmailer(); 
$mail->Mailer   = "mail"; 
$subject="Nova poruka sa sajta - ".date("d-m-Y-H:i"); 
$mail->From     = $settings['from_email']; 
$mail->FromName = $langa['from_site'][0]; 
$mail->Subject = "$subject"; 
$mail->AddReplyTo($_POST['emails'],$_POST['imes']); 
// $mail->Mailer   = "mail"; 
$mail->Body    = $zaslanje; 
$mail->AltBody = ""; 
if($settings['email_zaemail']!="") 
$mail->AddAddress($settings['email_zaemail']); 
//if($settings['email_zaemail1']!="") 
//$mail->AddAddress($settings['email_zaemail1']);
if($mail->Send()) $msgr=$arrwords['poslata_poruka']; 
?> 
<script> 
$( document ).ready(function() { 
alert("<?php echo $arrwords['poslata_poruka']; ?>"); 
});
</script> 
<?php 
} 
}
if($_POST['register']) 
{
$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$name_surname = ifempty($_POST['name_surname']); 
$name_surname_show = ifempty($_POST['name_show'],1); 
$korime=replace_implode2(ifempty($_POST['korime']),1,1); 
$email = ifempty($_POST['email']); 
$email_show = ifempty($_POST['email_show'],1); 
$password=ifempty($_POST['pass1']); 
$password1=ifempty($_POST['pass2']); 
$fb = ifempty($_POST['fb']); 
$fb_show = ifempty($_POST['fb_show'],1); 
$city = ifempty($_POST['city']); 
$city_show = ifempty($_POST['city_show'],1); 
$country = ifempty($_POST['country'],1); 
$country_show = ifempty($_POST['country_show'],1); 
$date_birth = ifempty($_POST['year'])."-".ifempty($_POST['month'])."-".ifempty($_POST['day']); 
$date_birth_show = ifempty($_POST['date_show'],1); 
$mf = ifempty($_POST['mf'],1); 
$mf_show = ifempty($_POST['mf_show'],1); 
$opis = ifempty($_POST['opis']); 
$opis_show = ifempty($_POST['opis_show'],1); 
$search_allow=ifempty($_POST['search_allow'],1); 
$message_allow=ifempty($_POST['message_allow'],1); 
$avatar=$_FILES['avatar']['name']; 
$opis = $_POST['opis']; 
$pro_email=mysqli_query($conn, "SELECT * FROM users WHERE email=".safe($email).""); 
$pro_kor_ime=mysqli_query($conn, "SELECT * FROM users WHERE username=".safe($kor_ime)." ");  
//echo "$key!=$number"; 
//echo "$ime || $prezime ||  $password || $passwordd1  || $telefon || $ulica || $posta || $grad || $zemlja || $email || $agencija"; 
if($password=="" || $password1=="" || $korime=="" || $email=="" || $number=="") 
// || count($_POST['drugi'])==0 
$msgr=$langa['regform'][28]; 
else if($key!=$number) 
$msgr=$langa['regform'][29]; 
elseif(filter_var(trim($email), FILTER_VALIDATE_EMAIL)===false)  
$msgr=$langa['regform'][16]; 
else if(mysqli_num_rows($pro_email)>0) 
$msgr=$langa['regform'][17]; 
else if($password!=$password1) 
$msgr=$langa['regform'][24]; 
else if(check_image($avatar)==0 and $avatar!="") 
$msgr=$langa['regform'][27]; 
else   
{
$br1=md5(md5($password.$vreme)); 
$password_crypted = tep_encrypt_password($password);
mysqli_query($conn, "INSERT INTO users SET 
username =".safe($korime,1).", 
email =".safe($email,1).",  
email_show =".safe($email_show,1).",  
password =".safe($password_crypted,1).", 
date ='".time()."', 
active='0', 
akt='N', 
agencija='1', 
potvrda =".safe($br1).",  
last_login='0', 
br_videa=0 
"); 
$zad_id=@mysqli_insert_id($conn); 
if($zad_id>0) 
{
if($_FILES['avatar']['tmp_name']) 
{ 
$slika =UploadSlika($_FILES['avatar']['name'],$_FILES['avatar']['tmp_name'],$_FILES['slika']['type'],"$page_path2/avatars/"); 
}else $slika="";
$kategice=""; 
if(count($_POST['prvi'])>0) 
{ 
foreach($_POST['prvi'] as $key=>$value) 
{ 
$kategice .=",$value"; 
} 
}  
if(count($_POST['drugi'])>0) 
{ 
foreach($_POST['drugi'] as $key=>$value) 
{ 
$kategice .=",$value"; 
} 
$kategice.=","; 
}
if(!mysqli_query($conn, "INSERT INTO adrese SET
name =".safe($name_surname,1).",  
male_female =".safe($mf,1).", 
country =".safe($country,1).", 
date_birth=".safe($date_birth,1).",  
fb =".safe($fb,1).",  
city =".safe($city,1).",  
name_show =".safe($name_surname_show,1).",  
male_female_show =".safe($mf_show,1).", 
country_show =".safe($country_show,1).", 
date_birth_show =".safe($date_birth_show,1).",  
fb_show =".safe($fb_show,1).",  
city_show =".safe($city_show,1).", 
id_user='$zad_id', 
search_allow=".safe($search_allow).", 
message_allow=".safe($message_allow).", 
opis_show='$opis_show', 
opis=".safe($opis).", 
avatar=".safe($slika).", 
kategorije=".safe($kategice)." 
")) echo mysqli_error();   
/*foreach($_POST[prvi] as $key=>$value) 
mysqli_query($conn, "INSERT INTO users_cat SET user_id='$zad_id', katid='$value'"); 
foreach($_POST[drugi] as $key=>$value) 
mysqli_query($conn, "INSERT INTO users_cat SET user_id='$zad_id', katid='$value'"); 
*/ 
$msgr=$langa['regform'][30];  
$disables="style='display:none;'";    
$link=$patH1."/sign-up/activate/".$br1."1/"; 
$aaa=sprintf($langa['regform'][31],$domen, $link, $link, $korime, $name_surname, $domen, ""); 
$aaa1=sprintf($langa['regform'][32],$domen, $link, $korime, $name_surname, $domen, "");
$subject=$langa['regform'][33]." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['regform'][34];
send_email("mail", $_POST['email'], "noreply@talent2star.com", "noreply@talent2star.com", $subject, $from_name, $aaa, $aaa1); 
}else echo mysqli_error(); 
}
}
/******************** change account settings **************/ 
if(($_POST['change_prof']==1 and $_SESSION['userid']>0) or ($_POST['idep']>0 and $ofi1['user_id']>0)) 
{
if($ofi1['user_id']>0 and $_POST['idep']>0) 
$idkorisnika=$_POST['idep']; 
else 
$idkorisnika=$_SESSION['userid']; 
$name_surname = ifempty($_POST['name_surname']); 
$name_surname_show = ifempty($_POST['name_show'],1); 
$korime=replace_implode2(ifempty($_POST['korime']),1,1); 
$email = ifempty($_POST['email']); 
$email_show = ifempty($_POST['email_show'],1); 
$password=ifempty($_POST['pass1']); 
$password1=ifempty($_POST['pass2']); 
$fb = ifempty($_POST['fb']); 
$fb_show = ifempty($_POST['fb_show'],1); 
$city = ifempty($_POST['city']); 
$city_show = ifempty($_POST['city_show'],1); 
$country = ifempty($_POST['country'],1); 
$country_show = ifempty($_POST['country_show'],1); 
$date_birth = ifempty($_POST['year'])."-".ifempty($_POST['month'])."-".ifempty($_POST['day']); 
$date_birth_show = ifempty($_POST['date_show'],1); 
$mf = ifempty($_POST['mf'],1); 
$mf_show = ifempty($_POST['mf_show'],1); 
$search_allow=ifempty($_POST['search_allow'],1); 
$opis = ifempty($_POST['opis']); 
$opis_show = ifempty($_POST['opis_show'],1); 
$message_allow=ifempty($_POST['message_allow'],1);
$avatar=$_FILES['avatar']['name']; 
$opis = $_POST['opis']; 
$pro_email=mysqli_query($conn, "SELECT * FROM users WHERE email=".safe($email)." AND NOT user_id='$idkorisnika'"); 
$pro_kor_ime=mysqli_query($conn, "SELECT * FROM users WHERE username=".safe($kor_ime)."  AND NOT user_id='$idkorisnika'");  
//echo "$key!=$number"; 
//echo "$ime || $prezime ||  $password || $passwordd1  || $telefon || $ulica || $posta || $grad || $zemlja || $email || $agencija"; 
if($korime=="" || $email=="") 
// || count($_POST['drugi'])==0 
$msgr=$langa['regform'][28];
elseif(filter_var(trim($email), FILTER_VALIDATE_EMAIL)===false)  
$msgr=$langa['regform'][16]; 
else if(mysqli_num_rows($pro_email)>0) 
$msgr=$langa['regform'][17]; 
else if($password!=$password1) 
$msgr=$langa['regform'][24]; 
else if(check_image($avatar)==0 and $avatar!="") 
$msgr=$langa['regform'][27]; 
else   
{  
$br1=md5(md5($password.$vreme)); 
$password_crypted = tep_encrypt_password($password); 
if($password!="" and $password1!="") 
$ipas=", password =".safe($password_crypted,1).""; 
if(!mysqli_query($conn, "UPDATE users SET 
username =".safe($korime,1).", 
email =".safe($email,1).",  
email_show =".safe($email_show,1)."  
$ipas  
WHERE user_id='$idkorisnika' 
")) echo mysqli_error();
//$zad_id=mysqli_insert_id($conn);
 if($_FILES['avatar']['tmp_name']) 
{ 
$slika =UploadSlika($_FILES['avatar']['name'],$_FILES['avatar']['tmp_name'],$_FILES['avatar']['type'],"$page_path2/avatars/"); 
@unlink("$page_path2/avatars/$_POST[stara]"); 
@unlink("$page_path2/avatars/thumb/$_POST[stara]"); 
}elseif($_POST['obrisi']==1)  
{ 
$slika=""; 
@unlink("$page_path2/avatars/$_POST[stara]"); 
@unlink("$page_path2/avatars/thumb/$_POST[stara]"); 
}elseif($_POST["stara"]!="") 
$slika=$_POST["stara"]; 
else $slika=""; 
$kategice=""; 
if(count($_POST['prvi'])>0) 
{ 
foreach($_POST['prvi'] as $key=>$value) 
{ 
$kategice .=",$value"; 
} 
} 
if(count($_POST['drugi'])>0) 
{  
foreach($_POST['drugi'] as $key=>$value) 
{ 
$kategice .=",$value"; 
} 
$kategice.=",";  
} 
if(!mysqli_query($conn, "UPDATE adrese SET 
name =".safe($name_surname,1).",  
male_female =".safe($mf,1).", 
country =".safe($country,1).", 
date_birth=".safe($date_birth,1).",  
fb =".safe($fb,1).",  
city =".safe($city,1).",  
name_show =".safe($name_surname_show,1).",  
male_female_show =".safe($mf_show,1).", 
country_show =".safe($country_show,1).", 
date_birth_show =".safe($date_birth_show,1).",  
fb_show =".safe($fb_show,1).",  
city_show =".safe($city_show,1).", 
search_allow=".safe($search_allow).", 
message_allow=".safe($message_allow).", 
opis_show='$opis_show', 
opis=".safe($opis).", 
avatar=".safe($slika).", 
kategorije=".safe($kategice)." 
WHERE id_user='$idkorisnika' 
")) echo mysqli_error();
/*$msgr=$langa['regform'][42]; 
mysqli_query($conn, "DELETE FROM users_cat WHERE user_id='$idkorisnika'"); 
foreach($_POST[prvi] as $key=>$value) 
mysqli_query($conn, "INSERT INTO users_cat SET user_id='$idkorisnika', katid='$value'"); 
foreach($_POST[drugi] as $key=>$value) 
mysqli_query($conn, "INSERT INTO users_cat SET user_id='$idkorisnika', katid='$value'"); 
*/
}
}
/***************** activate account ********************/ 
if(isset($sarray['activate']) and $sarray['activate']!="") 
{
$test=$sarray['activate'];        $ch=mysqli_query($conn, "SELECT * FROM users_data WHERE randkod=".safe($test,1)." AND akt='N'"); 
$ch1=mysqli_fetch_array($ch);         
if(mysqli_num_rows($ch)==1) 
{ 
mysqli_query($conn, "UPDATE users_data SET akt='Y' WHERE user_id='$ch1[user_id]'"); 
$linka="<a href='".$patH1."/".$all_links[10]."/?autolog=$ch1[randkod]'>".$patH1."/".$all_links[10]."/?autolog=$ch1[randkod]</a>"; 
$akti_tekst=sprintf($arrwords2['akti_tekst'], $ch1['ime'], $patH1."/".$all_links[10]."/", $linka, $patH1, $domen); 
$akti_tekst1=strip_html_tags($akti_tekst); 
send_email("mail", $ch1['email'], $settings["from_email"], $settings["from_email"], $langa['regform'][38], $from_name, $akti_tekst, $akti_tekst1);  $msl=$langa['regform'][35]; 
 $green="_green"; 
}else 
{ 
$msl=$langa['regform'][36]; 
} 
}
/***************** autolog ********************/ 
if(isset($sarray['autolog']) and $sarray['autolog']!="") 
{
$test=$sarray['autolog'];
$ch=mysqli_query($conn, "SELECT * FROM users_data WHERE randkod=".safe($test,1)." AND akt='Y'"); 
$ch1=mysqli_fetch_array($ch);         
if(mysqli_num_rows($ch)==1) 
{  
 $_SESSION['email'] = $ch1['email']; 
   $_SESSION['password'] = tep_encrypt_password($ch1['password']);  
    $_SESSION['korisnik'] =  $ch1['ime']; 
    $_SESSION['userid'] = $ch1['user_id'];    
   $_SESSION['username'] = $ch1['nickname']; 
header("location: $patH1/");  
}
else 
{ 
$msgr=$langa['regform'][37]; 
} 
}
/*************************** contact ***********************/ 
if($_POST['contact_send']) 
{
$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$korime=ifempty($_POST['korime']); 
$email = ifempty($_POST['email']); 
$tekst = ifempty($_POST['tekst']); 
if($korime=="" || $email=="" || $tekst=="" || $number=="") 
$msgr=$langa['regform'][28]; 
else if($key!=$number) 
$msgr=$langa['regform'][29]; 
elseif(filter_var(trim($email), FILTER_VALIDATE_EMAIL)===false)  
$msgr=$langa['regform'][16]; 
else   
{ 
$aaa=sprintf($langa['contform'][5],$domen, datef("",2), $korime, $email, $tekst); 
$subject=$langa['contform'][6]." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['contform'][6];
$send_email=send_email("mail", $Adminmail, $from_email, $_POST['email'], $subject, $from_name, $aaa, ""); 
if($send_email==1) 
$msgr=$langa['contform'][7]; 
else 
$msgr=$langa['regform'][39]; 
}  
} 
/********************** forgot password old version ****************************/
if($_POST['forgot_password_OLD'])
{
$email = ifempty($_POST['email']);
if($email=="")
$msgr=$arrwords['niste_ispunili'];
else
if(filter_var(trim($email), FILTER_VALIDATE_EMAIL)===false)
$msgr=$arrwords['email_novalid'];
else
{
$q=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($email)."");
if(mysqli_num_rows($q)==1){
$gigi=mysqli_fetch_assoc($q);
$vreme=time();
$email=$_POST['email'];
$nova=base64_encode(gen_rand().$vreme);
$nova1=strtolower(substr($nova,0,8));
$pas=tep_encrypt_password($nova1);
$subject=$arrwords2['nova_sifra2']." - ".$domen." - ".date("Y-m-d");
$from_name=$domen;
$aaa=sprintf($arrwords2['nova_sifra5'], $gigi['ime'], $nova1, $patH1, $domen);
$aaa1=strip_html_tags($aaa);
$send_email=send_email("mail", $_POST['email'], $settings["from_email"], $settings["from_email"],$subject, $from_name, $aaa, $aaa1);
if($send_email==1)
{
mysqli_query($conn, "UPDATE users_data SET password='$pas' WHERE email=".safe($_POST['email'],1)."");
$msgr=$arrwords2['nova_sifra'];
} else
$msgr=$arrwords2['nova_sifra3'];
} else $msgr=$arrwords2['nova_sifra4'];
}
}
/********************** forgot password  ****************************/
if($_POST['forgot_password']) 
{ 
$email = ifempty($_POST['email']);  
if($email=="") 
$msgr=$arrwords['niste_ispunili']; 
else 
if(filter_var(trim($email), FILTER_VALIDATE_EMAIL)===false)  
$msgr=$arrwords['email_novalid']; 
else 
{ 
$q=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($email).""); 
if(mysqli_num_rows($q)==1){ 
$gigi=mysqli_fetch_assoc($q); 
$vreme=time(); 
$email=$_POST['email']; 
$randi=gen_rand();
$linka="<a href='".$patH1."/".$all_links[19]."/?renew=".$randi."'>".$patH1."/".$all_links[19]."/?renew=".$randi."</a>";
$subject=$arrwords2['nova_sifra2']." - ".$domen." - ".date("Y-m-d"); 
$from_name=$domen;  
$aaa=sprintf($arrwords2['nova_sifra5'], $gigi['ime'], $linka, $patH1, $domen);
$aaa1=strip_html_tags($aaa); 
$send_email=send_email("mail", $_POST['email'], $settings["from_email"], $settings["from_email"],$subject, $from_name, $aaa, $aaa1);   
if($send_email==1) 
{ 
mysqli_query($conn, "UPDATE users_data SET renew='$randi', renew_time='".date("Y-m-d H:i:s")."' WHERE email=".safe($_POST['email'],1)."");
$msgr=$arrwords2['nova_sifra']; 
} else 
$msgr=$arrwords2['nova_sifra3']; 
} else $msgr=$arrwords2['nova_sifra4']; 
} 
}
mysqli_query($conn, "UPDATE users_data SET renew=NULL, renew_time=NULL WHERE (CURRENT_TIMESTAMP()-renew_time) >3600");
$istekao_link_za_sifru=0;
if(isset($sarray['renew']) and $sarray['renew']!=''){
$fax=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users_data WHERE renew=".safe($sarray['renew']).""));
if($fax<1) {
$msgr="Link za kreiranje nove šifre je istekao. Zahtevajte novi link <a href='".$patH1."/".$all_links[19]."/'>ovde</a>";
$istekao_link_za_sifru=1;
}
}
if(isset($_POST['renew-pass']) and strlen($_POST['renew-pass'])==15)
{
$fax=mysqli_query($conn, "SELECT * FROM users_data WHERE renew=".safe($_POST['renew-pass'])."");
$fx1=mysqli_fetch_assoc($fax);
if($fx1['user_id']>0) {
if($_POST['password']=="" or $_POST['password1']=="")
$msgr=$arrwords['niste_ispunili'];
else
if($_POST["password"]!=$_POST["password1"])
{
$msgr=$arrwords2['sifre_nejednake'];
} else {
$password_crypted = tep_encrypt_password(strip_tags($_POST['password']));
mysqli_query($conn, "UPDATE users_data SET password='$password_crypted' WHERE renew=".safe($_POST['renew-pass'])."");
$msgr="Nova šifra je uspešno postaljena. Možete se ulogovati <a href='".$patH1."/".$all_links[10]."/'>ovde</a>";
}
}
}
/******************* users login ***************************/ 
if(isset($_POST['sublogin'])){
   if(!$_POST['email'] || !$_POST['pass']) 
     $msgr=$langa['regform'][28];       
    else{
   $_POST['email'] = trim($_POST['email']);
   //$md5pass = md5($_POST['pass']); 
   $md5pass = trim($_POST['pass']);
   $result = confirmUser($_POST['email'], $md5pass);     if($result == 1 or $result == 2){ 
    $msgr=$langa['login'][7];
   }  
    else {
   $_POST['email'] = stripslashes($_POST['email']); 
   $_SESSION['email'] = $_POST['email']; 
   $_SESSION['panel'] = $_POST['panel']; 
   $_SESSION['password'] = tep_encrypt_password($md5pass);  
   $qi = "select * from users where email = '".$_SESSION['email']."'"; 
   $resulti = mysqli_query($conn, $qi,$conn); 
   $dbarrayi = mysqli_fetch_assoc($resulti); 
   $_SESSION['userid'] = $dbarrayi['user_id']; 
   $_SESSION['username'] = $dbarrayi['username']; 
  $ni = mysqli_query($conn, "select * from adrese where id_user = '".$dbarrayi['user_id']."'"); $ni1=mysqli_fetch_array($ni); 
   $_SESSION['name'] = $ni1['name']; 
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
 if($_SESSION['findurl']!=""){ 
 header("location: $_SESSION[findurl]"); 
 unset($_SESSION['findurl']); 
 } 
 else 
 header("location: $patH/users/$_SESSION[username]/"); 
} 
} 
}
/******************* new_video ***************************/ 
if($_POST['new_video'] and $_SESSION['userid']>0) 
{ 
$katid = $_POST['katid']; 
$akt = $_POST['akt']?$_POST['akt']:"N";   
$youtube = ifempty(trim($_POST['youtube'])); 
$title = ifempty(trim($_POST['title'])); 
$tags = ifempty(trim($_POST['tags'])); 
$desc = ifempty($_POST['desc']); 
if(preg_match("/vimeo.com/",$youtube)) 
{ 
$vimeo_id=parse_vimeo($youtube); 
if($vimeo_id=="") $vimeo_id="aa"; 
} 
else  
$youtube_id=youtube_id_from_url($youtube);  
if($katid>0) 
{ 
$chkat=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id_page='87' AND id_parent='$katid'"); 
$chkat1=mysqli_num_rows($chkat); 
}
if($katid=="" || $youtube=="" || $title=="" || $tags=="" || $desc=="") 
$msgr=$langa['regform'][28]; 
else 
if (!isValidYoutubeURL($youtube_id) and $youtube_id!="") 
$msgr=$langa['new_video'][14]; 
else 
if (getVimeoThumb($vimeo_id)=="" and $vimeo_id!="") 
$msgr=$langa['new_video'][14]; 
else 
if($chkat1>0) 
$msgr=$langa['new_video'][9]; 
else 
{ 
if($youtube_id!="") 
{ 
$image = file_get_contents("http://img.youtube.com/vi/$youtube_id/mqdefault.jpg");  
$slika="$youtube_id.jpg"; 
$file  = fopen("video_images/$youtube_id.jpg", 'w+'); 
  
}elseif($vimeo_id!="") 
{ 
$image = file_get_contents(getVimeoThumb($vimeo_id));  
$sihi=explode("/",getVimeoThumb($vimeo_id)); 
$sihi=array_reverse($sihi); 
$slika=$sihi[0]; 
$file  = fopen("video_images/$slika", 'w+'); 
}
fputs($file, $image);  
fclose($file);  
if($vimeo_id!="") 
$duration=VimeoDuration($vimeo_id); 
if($youtube_id!="") 
$duration=getDuration($youtube_id);
$all1=replace($title); 
$all1_exp=explode(" ",$all1); 
$title1=implode("-",$all1_exp); 
if(!mysqli_query($conn, "INSERT INTO video_page SET katid='$katid', naslov=".safe($title,1).", naslov1=".safe($title1,1).", slika1='".$slika."', youtube=".safe($youtube,1).", youtubeid=".safe($youtube_id?$youtube_id:$vimeo_id,1).", duration='$duration' ,datum='".date("Y-m-d")."', title=".safe($title,1).", keyt=".safe($tags,1).", desct=".safe($desc,1).", id_page=87, akt='Y', akt1='$akt', user_id='$_SESSION[userid]'")) echo mysqli_error(); 
if(mysqli_affected_rows()>0) 
{ 
$msgr=$langa['new_video'][10];
$_POST['akt']="";   
$_POST['youtube']=""; 
$_POST['title']=""; 
$_POST['tags']=""; 
$_POST['desc']=""; 
}else 
$msgr=$langa['new_video'][12]; 
} 
}
/******************* new_video ***************************/ 
if($_POST['edit_video'] and $_SESSION['userid']>0) 
{ 
$id = $_POST['idvid']; 
$akt = $_POST['akt']?$_POST['akt']:"N";   
$katid = $_POST['katid'];   
$youtube = ifempty(trim($_POST['youtube'])); 
$youtube_id=youtube_id_from_url($youtube); 
$title = ifempty(trim($_POST['title'])); 
$tags = ifempty(trim($_POST['tags'])); 
$desc = ifempty($_POST['desc']); 
if(preg_match("/vimeo.com/",$youtube)) 
{ 
$vimeo_id=parse_vimeo($youtube); 
if($vimeo_id=="") $vimeo_id="aa"; 
} 
else  
$youtube_id=youtube_id_from_url($youtube);  
if($katid>0) 
{ 
$chkat=mysqli_query($conn, "SELECT * FROM kateg_proizvoda_new WHERE id_page='87' AND id_parent='$katid'"); 
$chkat1=mysqli_num_rows($chkat); 
} 
if($katid=="" || $youtube=="" || $title=="" || $tags=="" || $desc=="") 
$msgr=$langa['regform'][28]; 
else 
if($chkat1>0) 
$msgr=$langa['new_video'][9]; 
else 
if (!isValidYoutubeURL($youtube_id) and $youtube_id!="") 
$msgr=$langa['new_video'][14]; 
else 
if (getVimeoThumb($vimeo_id)=="" and $vimeo_id!="") 
$msgr=$langa['new_video'][14]; 
else 
{ 
$cuv=mysqli_query($conn, "SELECT * FROM video_page WHERE id='$id'"); 
$cuv1=mysqli_fetch_array($cuv); 

if($youtube_id!=$cuv1['youtubeid'] and $youtube_id!="") 
{ 
if($cuv1['youtube']!="" and is_file("video_images/$cuv1[youtubeid].jpg")) 
{ 
if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM video_page WHERE youtubeid='$cuv1[youtubeid]'"))==1) 
unlink("video_images/$cuv1[youtubeid].jpg"); 
} 
$image = file_get_contents("http://img.youtube.com/vi/$youtube_id/mqdefault.jpg");  
$slika="$youtube_id.jpg"; 
$file  = fopen("video_images/$youtube_id.jpg", 'w+');  
fputs($file, $image);  
fclose($file);  
} 
if($vimeo_id!=$cuv1['youtubeid'] and $vimeo_id!="") 
{ 
if($cuv1['youtube']!="" and is_file("video_images/$cuv1[slika1]")) 
{ 
if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM video_page WHERE youtubeid='$cuv1[youtubeid]'"))==1) 
unlink("video_images/$cuv1[slika1]"); 
} 
$image = file_get_contents(getVimeoThumb($vimeo_id)); 
$sihi=explode("/",getVimeoThumb($vimeo_id)); 
$sihi=array_reverse($sihi); 
$slika=$sihi[0]; 
$file  = fopen("video_images/$slika", 'w+');  
fputs($file, $image);  
fclose($file);  
} 
if($vimeo_id!="") 
$duration=VimeoDuration($vimeo_id); 
if($youtube_id!="") 
$duration=getDuration($youtube_id); 
$all1=replace($title); 
$all1_exp=explode(" ",$all1); 
$title1=implode("-",$all1_exp); 
if(!mysqli_query($conn, "UPDATE video_page SET katid='$katid', naslov=".safe($title,1).", naslov1=".safe($title1,1).", slika1='".$slika."', youtube=".safe($youtube,1).", youtubeid=".safe($youtube_id?$youtube_id:$vimeo_id,1).", duration='$duration', title=".safe($title,1).", keyt=".safe($tags,1).", desct=".safe($desc,1).", akt1='$akt' WHERE user_id='$_SESSION[userid]' AND id='$id'")) echo mysqli_error(); 
$msgr=$langa['new_video'][11]; 
} 
}
/******************** send messages **********************/ 
if(isset($_POST['send_message']) and $_SESSION['userid']>0) 
{  
$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$naslov = ifempty($_POST['naslov']); 
$message = ifempty($_POST['poruka']); 
$sendto= strip_tags($_POST['sendto']);  
if($naslov=="" || $message==""/* || $number==""*/) 
$msgr=$langa['regform'][28]; 
//else if($key!=$number) 
//$msgr=$langa['regform'][29]; 
else   
{  
$curuser=$_SESSION['userid']; 
$recuser=$sendto; 
$ifi=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kontakt_users WHERE (rec_user_id =".safe($recuser,1)." AND user_id =".safe($curuser,1).") OR (user_id =".safe($recuser,1)." AND rec_user_id =".safe($curuser,1).")")); 
if($ifi==0) 
{ 
if(mysqli_query($conn, "INSERT INTO kontakt_users SET 
user_id =".safe($sendto,1).", 
rec_user_id =".safe($_SESSION['userid'],1)." 
")); 
$zid=mysqli_insert_id($conn); 
}else 
{ 
$gel=mysqli_query($conn, "SELECT * FROM kontakt_users WHERE (rec_user_id =".safe($recuser,1)." AND user_id =".safe($curuser,1).") OR (user_id =".safe($recuser,1)." AND rec_user_id =".safe($curuser,1).")");  
$gel1=mysqli_fetch_array($gel); 
$zid=$gel1['id']; 
} 
if(mysqli_query($conn, "INSERT INTO kontakt SET 
naslov =".safe($naslov).", 
poruka =".safe($message).",   
vreme='".time()."', 
id_conv='$zid', 
user_id='$curuser' 
")); 
if($zid>0) 
{ 
$zel=mysqli_query($conn, "SELECT *  FROM kontakt WHERE id_conv =".safe($zid,1)." ORDER BY id DESC");  
$zel1=mysqli_fetch_array($zel);
mysqli_query($conn, "UPDATE kontakt_users SET br_poruka=br_poruka+1, last_mess='$zel1[vreme]', del_us1='0', del_us2='0' WHERE id=$zid"); 
$sel=mysqli_query($conn, "SELECT * FROM kontakt_users WHERE id=".safe($zid).""); 
$se1=mysqli_fetch_array($sel); 
if($_SESSION['userid']==$se1['rec_user_id']) 
$slao=$se1['user_id']; 
else 
$slao=$se1['rec_user_id']; 
$gel=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".safe($slao).""); 
$ge1=mysqli_fetch_array($gel); 
}
$msgr=$langa['messag'][15]; 
$korime=$us1['ime'];  
$userlink="$patH1/$all_links[11]/".$us1['nickname']."/"; 
$aaa=sprintf($langa['messag'][19],$domen, $userlink, $korime, $domen, $patH1, $domen);
$aaa1=strip_html_tags($aaa);
$subject=$langa['messag'][21]." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1); 
}
} 
/**************** Blokiranje Korisnika **********************/ 
if($_POST['tip']=="blokiraj_korisnika" and $_SESSION['userid']>0) 
{   
 $se=mysqli_query($conn, "SELECT * FROM kontakt_blok WHERE bloker='$_SESSION[userid]' AND blokiran=".safe($_POST['id'])." AND tip=0"); 
if(mysqli_num_rows($se)==0) 
{ 
mysqli_query($conn, "INSERT INTO kontakt_blok SET bloker='$_SESSION[userid]', blokiran=".safe($_POST['id']).", tip=0"); 
mysqli_query($conn, "INSERT INTO shouts_blok SET bloker='$_SESSION[userid]', blokiran=".safe($_POST['id']).""); 
} 
else 
{ 
mysqli_query($conn, "DELETE FROM kontakt_blok WHERE bloker='$_SESSION[userid]' AND blokiran=".safe($_POST['id'])."  AND tip=0"); 
mysqli_query($conn, "DELETE FROM shouts_blok WHERE bloker='$_SESSION[userid]' AND blokiran=".safe($_POST['id']).""); 
} 
$gel=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".safe($_POST['id']).""); 
$ge1=mysqli_fetch_array($gel); 
$korime=$us1['ime'];  
$userlink="$patH1/$all_links[11]/".$us1['nickname']."/"; 
$fse=mysqli_query($conn, "SELECT * FROM kontakt_blok WHERE bloker='$_SESSION[userid]' AND blokiran=".safe($_POST['id'])." AND tip=0"); 
if(mysqli_num_rows($fse)==0) 
{ 
$poruka=$langa['messag'][24]; 
$naslov=$langa['messag'][25]; 
echo $langa['messag'][27]; 
}else 
{ 
$poruka=$langa['messag'][22]; 
$naslov=$langa['messag'][23]; 
echo $langa['messag'][26]; 
} 
$aaa=sprintf($poruka,$domen, $userlink, $korime, $patH1, $domen); 
 
$aaa1=strip_html_tags($aaa); 
$subject=$naslov." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);  
}
/**************** Svidjas mi se **********************/ 
if($_POST['tip']=="svidjas_mi_se" and $_SESSION[userid]>0) 
{   
 $se=mysqli_query($conn, "SELECT * FROM kontakt_blok WHERE bloker='$_SESSION[userid]' AND blokiran=".safe($_POST['id'])." AND tip=1"); 
 $fest=mysqli_num_rows($se); 
if($fest==0) 
mysqli_query($conn, "INSERT INTO kontakt_blok SET bloker='$_SESSION[userid]', blokiran=".safe($_POST['id']).", tip=1"); 
else 
mysqli_query($conn, "DELETE FROM kontakt_blok WHERE bloker='$_SESSION[userid]' AND blokiran=".safe($_POST['id'])." AND tip=1"); 
$gel=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".safe($_POST['id']).""); 
$ge1=mysqli_fetch_array($gel); 
$korime=$us1['ime'];  
$userlink="$patH1/$all_links[11]/".$us1['nickname']."/";
if($fest==0) 
{ 
$naslov=sprintf($langa['messag'][38],$korime); 
$poruka=$langa['messag'][39]; 
echo $langa['messag'][40];  
$aaa=sprintf($poruka, $userlink, $korime, $domen, $patH1, $domen); 
$aaa1=strip_html_tags($aaa); 
$subject=$naslov." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);  
}else 
echo $langa['messag'][41]; 
}
/**************** Pitaj za prijateljstvo **********************/ 
if($_POST['tip']=="pitaj_za_prijateljstvo" and $_SESSION['userid']>0) 
{   
 $se=mysqli_query($conn, "SELECT * FROM kontakt_blok_privremena WHERE bloker='$_SESSION[userid]' AND blokiran=".safe($_POST['id'])." AND tip=2"); 
 $fest=mysqli_num_rows($se); 
if($fest==0) 
mysqli_query($conn, "INSERT INTO kontakt_blok_privremena SET bloker='$_SESSION[userid]', blokiran=".safe($_POST['id']).", tip=2, randkod='".gen_rand()."'"); 
$gel=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".safe($_POST['id']).""); 
$ge1=mysqli_fetch_array($gel); 
$korime=$us1['ime'];  
$userlink="$patH1/$all_links[11]/".$us1['nickname']."/"; 
if($fest==0) 
{ 
$fel=mysqli_query($conn, "SELECT * FROM kontakt_blok_privremena WHERE bloker='$_SESSION[userid]' AND blokiran=".safe($_POST['id'])." AND tip=2"); 
$fe1=mysqli_fetch_array($fel); 
$naslov=sprintf($langa['messag'][43],$korime); 
$poruka=$langa['messag'][44]; 
echo $langa['messag'][45]; 
//$aaa=sprintf($poruka, $userlink, $korime, $domen, "$userlink?ok=$fe1[randkod]", "$userlink?no=$fe1[randkod]", $patH1, $domen); 
$aaa=sprintf($poruka, $userlink, $korime, $domen,  $patH1, $domen);  
$aaa1=strip_html_tags($aaa); 
$subject=$naslov." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['from_site'][0];
send_email("mail", $ge1['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);  
} else  
{ 
mysqli_query($conn, "DELETE FROM kontakt_blok_privremena WHERE bloker='$_SESSION[userid]' AND blokiran=".safe($_POST['id'])." AND tip=2"); 
mysqli_query($conn, "DELETE FROM kontakt_prijatelji WHERE bloker='".$_SESSION['userid']."' AND blokiran=".safe($_POST['id'])." AND tip=2"); 
mysqli_query($conn, "DELETE FROM kontakt_prijatelji WHERE blokiran='".$_SESSION['userid']."' AND bloker=".safe($_POST['id'])." AND tip=2"); 
echo $langa['messag'][372]; 
} 
//echo $langa['messag'][450]; 
} 
/**************** Prihvaceno prijateljstvo **********************/ 
if($sarray['ok']!="" and isset($_SESSION['userid'])) 
{ 
$oks=strip_tags($sarray['ok']); 
$se=mysqli_query($conn, "SELECT * FROM kontakt_blok_privremena WHERE randkod=".safe($oks)."  AND tip=2");
$fest=mysqli_num_rows($se); 
$se1=mysqli_fetch_assoc($se); 
$gel=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".safe($se1['bloker']).""); 
$ge1=mysqli_fetch_array($gel);  
if(!isset($_SESSION['userid'])) 
{ 
$_SESSION['forredi']="$patH1/$all_links[11]/$ge1[nickname]/?ok=$oks"; 
header("Location: $patH1/$all_links[10]/"); 
exit(); 
}
if($fest==1) 
{ 
mysqli_query($conn, "INSERT INTO kontakt_prijatelji SET bloker='".$_SESSION['userid']."', blokiran=".safe($se1['bloker']).", tip=2"); 
mysqli_query($conn, "INSERT INTO kontakt_prijatelji SET blokiran='".$_SESSION['userid']."', bloker=".safe($se1['bloker']).", tip=2"); 
mysqli_query($conn, "DELETE FROM kontakt_blok_privremena WHERE randkod=".safe($oks)." AND blokiran=".safe($_SESSION['userid'])." AND tip=2"); 
$korime=$us1['ime'];  
$userlink="$patH1/$all_links[11]/".$us1['nickname']."/";    
$naslov=sprintf($langa['messag'][46],$korime); 
$poruka=$langa['messag'][47]; 
$mesme= $langa['messag'][48]; 
$klasa="info_box_green"; 
$aaa=sprintf($poruka, $userlink, $korime, $userlink, $korime, $patH1, $domen);  
$aaa1=strip_html_tags($aaa); 
$subject=$naslov." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);  
} else  
{ 
$mesme= $langa['messag'][49]; 
$klasa="info_box"; 
} 
}
/**************** Odbijeno prijateljstvo **********************/ 
if($sarray['no']!="" and isset($_SESSION['userid'])) 
{ 
$oks=strip_tags($sarray['no']); 
$se=mysqli_query($conn, "SELECT * FROM kontakt_blok_privremena WHERE randkod=".safe($oks)."  AND tip=2"); 
$fest=mysqli_num_rows($se); 
$se1=mysqli_fetch_assoc($se); 
$gel=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".safe($se1['bloker']).""); 
$ge1=mysqli_fetch_array($gel);  
if(!isset($_SESSION['userid'])) 
{ 
$_SESSION['forredi']="$patH1/$all_links[11]/$ge1[nickname]/?no=$oks"; 
header("Location: $patH1/$all_links[10]/"); 
exit(); 
}  
if($fest==1) 
{
mysqli_query($conn, "DELETE FROM kontakt_blok_privremena WHERE randkod=".safe($oks)." AND blokiran=".safe($_SESSION['userid'])." AND tip=2"); 
$korime=$us1['ime'];  
$userlink="$patH1/$all_links[11]/".$us1['nickname']."/";
$naslov=sprintf($langa['messag'][50],$korime); 
$poruka=$langa['messag'][51]; 
$mesme= $langa['messag'][52]; 
$klasa="info_box"; 
$aaa=sprintf($poruka, $userlink, $korime, $userlink, $korime, $patH1, $domen);  
$aaa1=strip_html_tags($aaa); 
$subject=$naslov." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);  
} else  
{ 
$mesme= $langa['messag'][49]; 
$klasa="info_box"; 
} 
}
/**************** Chat zahtev **********************/ 
if($_POST['tip']=="chat_zahtev" and $_SESSION['userid']>0) 
{   
$se=mysqli_query($conn, "SELECT * FROM shouts_blok WHERE blokiran='$_SESSION[userid]' AND bloker=".safe($_POST['id']).""); 
$fest=mysqli_num_rows($se); 
$gse=mysqli_query($conn, "SELECT * FROM shouts_konv WHERE akt=1  AND us1=$_SESSION[userid] AND us2=0 AND mz=".safe($_POST['id']).""); 
$gest=mysqli_num_rows($gse); 
$cse=mysqli_query($conn, "SELECT * FROM shouts_konv WHERE akt=1  AND ((us1=$_SESSION[userid] AND us2=".safe($_POST['id']).") or (us2=$_SESSION[userid] AND us1=".safe($_POST['id'])."))"); 
$cest=mysqli_num_rows($cse); 
if($cest>0) 
echo $langa['ohes'][4]; 
else 
if($fest>0) 
echo $langa['messag'][231]; 
else 
if($gest>0) 
echo $langa['messag'][232]; 
else 
{ 
mysqli_query($conn, "INSERT INTO shouts_konv SET akt=1, us1=$_SESSION[userid], us2=0, mz=".safe($_POST['id']).""); 
$gel=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".safe($_POST['id']).""); 
$ge1=mysqli_fetch_array($gel); 
$korime=$us1['ime'];  
$userlink="$patH1/$all_links[11]/".$us1['nickname']."/"; 
$naslov=sprintf($langa['ohes'][1],$korime); 
$poruka=$langa['ohes'][3]; 
echo $langa['ohes'][2];
$aaa=sprintf($poruka, $ge1['ime'], $userlink, $korime, $domen, $patH1, $domen); 
$aaa1=strip_html_tags($aaa); 
$subject=$naslov." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);  
}
}
/************* Brisanje konverzacije **********************/ 
if($_POST['tip']=="brisip1" and $_SESSION['userid']>0){ 
$curuser=$_SESSION['userid']; 
$recuser=$_POST[id]; 
$se=mysqli_query($conn, "SELECT * FROM kontakt_users WHERE id=$_POST[id]"); 
$se1=mysqli_fetch_assoc($se);  
if($se1['del_us1']==0 and $se1['del_us2']==0) 
{ 
mysqli_query($conn, "UPDATE kontakt_users SET del_us1='$_SESSION[userid]' WHERE id=".safe($_POST['id']).""); 
mysqli_query($conn, "UPDATE kontakt SET del_us1='$_SESSION[userid]' WHERE id_conv=".safe($_POST['id']).""); 
} 
elseif($se1['del_us1']>0 and $se1['del_us2']==0) 
mysqli_query($conn, "UPDATE kontakt_users SET del_us2='$_SESSION[userid]' WHERE id=".safe($_POST['id'])."");   
elseif($se1['del_us1']==0 and $se1['del_us2']>0) 
mysqli_query($conn, "UPDATE kontakt_users SET del_us1='$_SESSION[userid]' WHERE id=".safe($_POST['id'])."");  
$fe=mysqli_query($conn, "SELECT * FROM kontakt_users WHERE id=$_POST[id]"); 
$fe1=mysqli_fetch_assoc($fe);  
if($fe1['del_us1']>0 and $fe1['del_us2']>0) 
{ 
mysqli_query($conn, "DELETE FROM kontakt WHERE id_conv=".safe($_POST['id']).""); 
mysqli_query($conn, "DELETE FROM kontakt_users WHERE id=".safe($_POST['id']).""); 
}
}
/************* Brisanje poruke **********************/ 
if($_POST['tip']=="brisiporuku" and $_SESSION['userid']>0){ 
$se=mysqli_query($conn, "SELECT * FROM kontakt WHERE id=".safe($_POST['id']).""); 
$se1=mysqli_fetch_assoc($se); 
if($se1['del_us1']==0 and $se1['del_us2']==0) 
//mysqli_query($conn, "UPDATE kontakt_users SET br_poruka=br_poruka-1 WHERE id=".safe($se1[id]).""); 
mysqli_query($conn, "UPDATE kontakt SET del_us1='$_SESSION[userid]' WHERE id=".safe($_POST['id']).""); 
else 
mysqli_query($conn, "DELETE FROM kontakt WHERE id=".safe($_POST['id']).""); 
}
/******************** send abuse **********************/ 
if($_POST['send_abuse'] and isset($_SESSION['userid'])) 
{  
$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$naslov = ifempty($_POST['naslov']); 
$message = ifempty($_POST['poruka']); 
$idd = @preg_replace('#[^0-9]#i', '',$_GET['sendto']); 
$ze=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$idd"); 
$ze1=mysqli_fetch_array($ze);   
if($naslov=="" || $message==""/* || $number==""*/) 
$msgr=$langa['regform'][28]; 
else   
{
$msgr=$langa['messag'][33]; 
$korime=$ze1['ime'];  
$userlink="$patH1/$all_links[11]/".$ze1['nickname']."/"; 
$aaa=sprintf($langa['messag'][35], $userlink, $korime, $naslov, $domen, $patH1, $domen); 
$aaa1=strip_html_tags($aaa); 
$subject=$langa['messag'][34]." - ".$domen; 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1); 
}
}

if(isset($_POST['iduKom']) and $_POST['iduKom']>0) {

$uzk=mysqli_query($conn, "SELECT * FROM komentari WHERE id=".$_POST['iduKom']."");
$uzk1=mysqli_fetch_assoc($uzk);

$status = array(
		'ime'=>$uzk1['ime'],
		'email'=>$uzk1['email'],
    'komentar'=>$uzk1['komentar']
	);
}
/******************** send komentar za proizvod **********************/ 
if(isset($_POST['send_komentar']) and !mb_eregi('pop3.printemailtext.com', $_POST['email']) and !mb_eregi('pop.printemailtext.com', $_POST['email'])) 
{ 
$tipVrati='error';
$capcha_greska = 0;
  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
      {
 //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LczURcUAAAAAJPa4yrrqp6B1sQM3tfKgGXEXaK2&response='.$_POST['g-recaptcha-response']);
 $verifyResponse = file_get_contents_curl('https://www.google.com/recaptcha/api/siteverify?secret='.$settings['recaptcha_skriveni'].'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

        if($responseData->success){} else
        $capcha_greska = 1;

      }


$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$naslov = ifempty($_POST['ime']); 
$message = ifempty($_POST['poruka']); 
$sendto= strip_tags($_POST['email']);  
if($message=="" or $naslov=="" or (empty($_POST['g-recaptcha-response']) and !isset($_SESSION['userids'])))
$msgr=$arrwords['niste_ispunili1']; 
elseif($capcha_greska==1)
$msgr="Proverite da li ste čekirali da niste robot i da li ste sve precizno ispunili!";
else 
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false) 
$msgr=$arrwords['email_novalid']; 
else 
if(mb_eregi('http', $_POST['poruka'])) 
$msgr="Koristite nedozvoljeni sadržaj u komentaru!"; 
else 
{
if(isset($_POST['id_parent']) and $_POST['id_parent']>0)
$idparent="id_parent=".safe($_POST['id_parent']).", ";
else
$idparent="";
if(!mysqli_query($conn, "INSERT INTO komentari SET 
komentar =".safe($message).",   
akt=0, 
id_pro=$_POST[idpro],
$idparent
ime='$naslov', 
email='$sendto'
")) echo mysqli_error(); 
$zid=mysqli_insert_id($conn); 
if($zid>0) 
{ 
$sz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide 
        FROM pro p 
        INNER JOIN prol pt ON p.id = pt.id_text 
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$_POST[idpro]"); 
$sz1=mysqli_fetch_array($sz); 
if($sz1['tip']==4) 
$zalink=$all_links[2]; 
else 
$zalink=$all_links[3]; 


$msgr=$langa['profme'][14]; 
$tipVrati='success';

$userlink="$patH1/$zalink/".$sz1['ulink']."/"; 
$userlink=str_replace("https://www.amazonka.rs/https://www.amazonka.rs","https://www.amazonka.rs",$userlink);
$aaa=sprintf($langa['messag'][53], $naslov,  $userlink, $sz1['naslov'], $patH1, $domen); 
$aaa1=strip_html_tags($aaa);  
$subject=$langa['messag'][54]." - ".$sz1['naslov']; 
$from_name=$domen." - ".$langa['from_site'][0];   
send_email("mail", $settings['email_zaemail'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1); 

}  
}
$status = array(
		'type'=>$tipVrati,
		'message'=>$msgr
	);
}
/******************** send komentar za blog **********************/ 
if(isset($_POST['send_komentar1']) and !mb_eregi('pop3.printemailtext.com', $_POST['email']) and !mb_eregi('pop.printemailtext.com', $_POST['email']))
{   
$tipVrati='error';
 $capcha_greska = 0;
  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
      {
 //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LczURcUAAAAAJPa4yrrqp6B1sQM3tfKgGXEXaK2&response='.$_POST['g-recaptcha-response']);
 $verifyResponse = file_get_contents_curl('https://www.google.com/recaptcha/api/siteverify?secret='.$settings['recaptcha_skriveni'].'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

        if($responseData->success){} else
        $capcha_greska = 1;

      }

$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$naslov = ifempty($_POST['ime']); 
$message = ifempty($_POST['poruka']); 
$sendto= strip_tags($_POST['email']);  

if($message=="" or $naslov=="" or (empty($_POST['g-recaptcha-response']) and !isset($_SESSION['userids'])))
$msgr=$arrwords['niste_ispunili1']; 
elseif($capcha_greska==1)
$msgr="Proverite da li ste čekirali da niste robot i da li ste sve precizno ispunili!";
else 

if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false) 
$msgr=$arrwords['email_novalid']; 
else 
if(mb_eregi('http', $_POST['poruka'])) 
$msgr="Koristite nedozvoljeni sadržaj u komentaru!"; 
else 
{
if(isset($_POST['id_parent']) and $_POST['id_parent']>0)
$idparent="id_parent=".safe($_POST['id_parent']).", ";
else
$idparent="";

if(!mysqli_query($conn, "INSERT INTO komentari SET 
komentar =".safe($message).",   
akt=0, 
tip=1, 
id_pro=$_POST[idpro], 
$idparent
ime='$naslov', 
email='$sendto'
")) echo mysqli_error(); 
$zid=mysqli_insert_id($conn); 
if($zid>0) 
{ 
$sz=mysqli_query($conn, "SELECT p.*, pt.* 
        FROM pages_text p 
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text         
        WHERE pt.lang='$lang'  AND p.akt='Y'  AND p.id=$_POST[idpro]");          
$sz1=mysqli_fetch_array($sz); 
$zalink=$patH1."/".$page1["ulink"]."/".$sz1["ulink"]; 

$msgr=$langa['profme'][14]; 
$tipVrati='success';

$userlink="$patH1/$zalink/".$sz1['ulink']."/"; 
$userlink=str_replace("https://www.amazonka.rs/https://www.amazonka.rs","https://www.amazonka.rs",$userlink);
$aaa=sprintf($langa['messag'][53], $naslov,  $userlink, $sz1['naslov'], $patH1, $domen);  
$aaa1=strip_html_tags($aaa); 
$subject=$langa['messag'][54]." - ".$sz1['naslov']; 
$from_name=$domen." - ".$langa['from_site'][0];
send_email("mail", $settings['email_zaemail'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1); 
}  
} 
$status = array(
		'type'=>$tipVrati,
		'message'=>$msgr
	);
}
/******************** IZMENA komentara **********************/ 
if(isset($_POST['izmena_komentara']) and $_POST['izmena_komentara']>0) 
{ 
$tipVrati='error';
$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number']; 
$naslov = ifempty($_POST['ime']); 
$message = ifempty($_POST['poruka']); 
$sendto= strip_tags($_POST['email']); 
if($message=="" or $naslov=="") 
$msgr=$arrwords['niste_ispunili1'];  else 
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false) 
$msgr=$arrwords['email_novalid']; 
else 
{
if(!mysqli_query($conn, "UPDATE komentari SET 
komentar =".safe($message).", 
ime='$naslov', 
email='$sendto' 
WHERE id=$_POST[izmena_komentara] 
")) echo mysqli_error();

 $msgr="Izmena je izvrsena!"; 
$tipVrati='success';

}
$status = array(
		'type'=>$tipVrati,
		'message'=>$msgr
	);
} 
if(isset($_POST['tip']) and $_POST['tip']=="akomentar" and isset($_SESSION['userids'])) 
{   
$gel=mysqli_query($conn, "SELECT * FROM komentari WHERE id=".safe(strip_tags($_POST['id'])).""); 
$ge1=mysqli_fetch_array($gel); 
if($ge1['akt']==0) $nak=1; else $nak=0; 
mysqli_query($conn, "UPDATE komentari SET akt=$nak WHERE id=".safe(strip_tags($_POST['id'])).""); 
}
/*$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0'; 
if($pageWasRefreshed ) { 
 echo "Yes"; 
} else { 
   echo "No"; 
} 
*/ 
if((isset($_POST['dod']) and $_POST['dod']=="on" and isset($_SESSION['userid'])) or (isset($_SESSION['userid']) and $_SESSION['userid']>0)) 
{ 
$gel=mysqli_query($conn, "SELECT * FROM users_online WHERE user_id=".$_SESSION['userid'].""); 
$ge1=mysqli_fetch_array($gel); 
if($ge1['user_id']>0) 
{ 
//if(!mysqli_query($conn, "UPDATE users_online SET vreme='".time()."' WHERE user_id=".$_SESSION['userid']."")) echo mysqli_error(); 
if(!mysqli_query($conn, "UPDATE users_online SET vreme=NOW() WHERE user_id=".$_SESSION['userid']."")) echo mysqli_error(); 
} 
else 
{   
if(!mysqli_query($conn, "INSERT INTO users_online SET vreme=NOW(), user_id=".$_SESSION['userid']."")) echo mysqli_error(); 
} 
}  /******************** kontak forma send messages **********************/ 
if($_POST['kontakt_send'] and isset($_SESSION['userid'])) 
{  
$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$naslov = ifempty($_POST['name']); 
$sendto = ifempty($_POST['email']); 
$subject= strip_tags($_POST['subject']); 
$message ="<b>$subject</b><br>Ime: $naslov<br>Email: $sendto<br><br>"; 
$message .= $_POST['message'];  
if($naslov=="" || $message=="" or $sendto=="" or $subject==""/* || $number==""*/) 
$msre=$langa['regform'][28]; 
else   
{ 
$aaa1=strip_html_tags($message); 
$zasend=$subject." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $sendto, $zasend, $from_name, $message, $aaa1); 
$msre=$langa['messag'][15];  
$grin="_green"; 
} 
}
/**************** Slanje poklona **********************/ 
if(isset($_POST["send_gift"]) and $_SESSION['userid']>0) 
{     
$gel=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".safe($_POST['sendto']).""); 
$ge1=mysqli_fetch_array($gel); 
$pok=mysqli_query($conn, "SELECT * FROM slike WHERE id=".safe($_POST['gift']).""); 
$pok1=mysqli_fetch_array($pok); 
$sok=mysqli_query($conn, "SELECT * FROM slike_lang WHERE id_slike=".safe($_POST['gift']).""); 
$sok1=mysqli_fetch_array($sok); 
$poklon="<b>$sok1[lang]</b><br><img src='$patH".SUBFOLDER.GALFOLDER."/$pok1[slika]' />";  
$korime=$us1['ime'];  
$userlink="$patH1/$all_links[11]/".$us1['nickname']."/"; 
mysqli_query($conn, "INSERT INTO pokloni_poslati SET poslao='$_SESSION[userid]', primio=".safe($_POST['sendto']).", poklon=$_POST[gift]"); 
$naslov=$langa['messag'][57]; 
$poruka=$langa['messag'][58]; 
$msgr=$langa['messag'][59]; 
$aaa=sprintf($poruka,$ge1['ime'], $userlink, $korime, $domen, $poklon, $patH1, $domen); 
 $grin="_green"; 
$aaa1=strip_html_tags($aaa); 
$subject=$naslov." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);  
} 
if(isset($sarray['hide']) and $sarray['hide']>0 and isset($_SESSION['userid'])) 
{ 
mysqli_query($conn, "UPDATE kontakt_blok SET sakrij=1 WHERE tip=1 AND bloker=".safe(strip_tags($sarray['hide']))." AND blokiran=$us1[user_id]"); 
header("location:$search_values[0]"); 
} 
if(isset($sarray['show']) and $sarray['show']>0 and isset($_SESSION['userid'])) 
{ 
mysqli_query($conn, "UPDATE kontakt_blok SET sakrij=0 WHERE tip=1 AND bloker=".safe(strip_tags($sarray['show']))." AND blokiran=$us1[user_id]"); 
header("location:$search_values[0]"); 
}
/*************** Del kom *********************/ 
if(isset($_POST['tip']) and $_POST['tip']=="del_kom" and $_POST['id']>0  and isset($_SESSION['userids'])) 
{ 
if(!mysqli_query($conn, "DELETE FROM komentari WHERE id=".strip_tags($_POST['id'])."")) echo mysqli_error(); 
} 
/******************** send porudzbine **********************/
$load_nestpay_form=0;
if(isset($_POST['naruci_log']) and !isset($_SESSION[$sid])) 
{ 
$msgr="Vaša porudžbina je već prosleđena i korpa je ispražnjena!"; 
$hider="style='display:none;'"; 
} 
else 
if(isset($_POST['naruci_log']) and isset($_SESSION[$sid]) and count($_SESSION[$sid])>0)
{
$capcha_greska = 2;
  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
      {
function get_page($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');
    $return = curl_exec($curl);
    curl_close($curl);
    return $return;
}
 //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LczURcUAAAAAJPa4yrrqp6B1sQM3tfKgGXEXaK2&response='.$_POST['g-recaptcha-response']);
 $verifyResponse = get_page('https://www.google.com/recaptcha/api/siteverify?secret='.$settings['recaptcha_skriveni'].'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success){} else
        $capcha_greska = 1;
      }
if(isset($_SESSION['userid']) and $_SESSION['userid']>0 and $_POST['naruci_log']==1 and $_POST['opsti_uslovi']=="")
$msgr=$arrwords['niste_ispunili'];
else
if(($_POST['ime']=="" or $_POST['email']=="" or $_POST['posta']=="" or $_POST['adresa']=="" or $_POST['telefon']=="" or $_POST['grad']=="" or $_POST['nacin']=="" or $_POST['opsti_uslovi']=="") and $_POST['naruci_log']==2) 
$msgr=$arrwords['niste_ispunili']; 
else
if(isset($_POST['g-recaptcha-response']) && empty($_POST['g-recaptcha-response']) and $_POST['naruci_log']==2)
$msgr="Čekirajte da niste robot!";
elseif($capcha_greska==1 and $_POST['naruci_log']==2)
$msgr="Proverite da li ste čekirali da niste robot i da li ste sve precizno ispunili u tom delu!";
else if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false and $_POST['naruci_log']==2) 
$msgr=$arrwords['email_novalid']; 
else 
{ 
$addItems=""; 
$addTrans=""; // placanje karticom
if(isset($_POST['nacin']) and $_POST['nacin']==4)
{
if(isset($_SESSION['userid']) and $_SESSION['userid']>0)
{
$ze=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid]");
$ze1=mysqli_fetch_array($ze);
$ime=$ze1['ime'];
$posta=$ze1['postanski_broj'];
$grad=$ze1['grad'];
$pib=$ze1['pib'];
$adresa=$ze1['ulica_broj'];
$email=$ze1['email'];
$telefon=$ze1['telefon'];
$usid=$_SESSION['userid'];
}
else
{
$ime=$_POST['ime'];
$posta=$_POST['posta'];
$grad=$_POST['grad'];
$pib=$_POST['pib'];
$adresa=$_POST['adresa'];
$email=$_POST['email'];
$telefon=$_POST['telefon'];
$usid=0;
} $ukupno=0;
$arti=array();
foreach($_SESSION[$sid] as $key => $value)
{
$cena_sum=0;
$sum=0;
if($key>0)
{
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
$az1=mysqli_fetch_assoc($az);
/*if($az1['cena1']>0 and $az1['akcija']==1)
$cenar=$az1['cena1'];
else*/
$cenar=$az1['cena'];
$cena_sum =roundCene($cenar,1)*$value;
$ukupno +=roundCene($cenar,1)*$value;
$sum =$value;
$arti[]=$key."-".$value;
}
}
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0) {
$ukupno_promo=$ukupno-$_SESSION['promo-kod']['vrednost_koda'];
$ukupno_promo=sprintf("%4.2f",$ukupno_promo);
$idpromo=$_SESSION['promo-kod']['id'];
}
else {
$ukupno_promo=0;
$idpromo=0;
}
$ukupno=sprintf("%4.2f",$ukupno);
$kod_kupovine=implode("#",$arti); $driv=mysqli_query($conn, "SELECT * FROM privremena WHERE sid='".$sid."' AND kod_kupovine='$kod_kupovine' AND status=0 AND datum='".date("Y-m-d")."'");
$driv1=mysqli_num_rows($driv);
if($driv1==0)
{
$priv=mysqli_query($conn, "SELECT * FROM privremena ORDER BY id DESC");
$priv1=mysqli_fetch_array($priv);
 $trid=explode("-",$priv1['trackid']);
 $ntrid=end($trid)*1+1;
 $TrackId = "ABizNet-$ntrid";
	  $sql = "insert into privremena(usid, ime, mejl, telefon, adresa, grad, pib, sid, trackid,kod_kupovine, vreme, datum, poruka, nacin_kupovine, trantype, iznos, ukupnosve, iznos_sa_kodom, idpromo)
	          values('$usid', ".safe($ime).", ".safe($email).", ".safe($telefon).", ".safe($adresa).", ".safe($grad).", ".safe($pib).", '".$sid."', '$TrackId', '$kod_kupovine', '".time()."', '".date("Y-m-d")."', ".safe($_POST['poruka']).", ".safe(preg_replace('/\d/', '', $_POST['isporuka'])).", trantype='PreAuth', ".safe($ukupno).", ".safe($ukupno).", ".safe($ukupno_promo).", ".safe($idpromo).")";
if(!mysqli_query($conn, $sql)) echo mysqli_error();
$zid=mysqli_insert_id($conn);
if($zid>0)
{
foreach($_SESSION[$sid] as $key => $value)
{
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
$az1=mysqli_fetch_assoc($az);
mysqli_query($conn, "INSERT INTO privremena_pro SET sid='".$sid."', trackid='$TrackId', idpro='$key', naziv='$az1[naslov]', cena='".roundCene($az1['cena'],1)."', kolicina='$value'");
}
$load_nestpay_form=1;  }
}
else if($driv1>0)
{
$priv=mysqli_query($conn, "SELECT * FROM privremena WHERE sid='".$sid."' AND kod_kupovine='$kod_kupovine' AND status=0 AND datum='".date("Y-m-d")."' ORDER BY id DESC");
$priv1=mysqli_fetch_array($priv);
$TrackId = $priv1['trackid']; 
$load_nestpay_form=1;
} if($load_nestpay_form==1) {
 $domen="$patH1/intesa";
     $orgClientId  =   "13IN060589";
      $orgOid =    $TrackId;
      $storeK="AOou04453";
    if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0)
      $orgAmount =  $ukupno_promo;
      else
      $orgAmount =  $ukupno;
      $orgOkUrl =  "$domen/Receipt.php";
      $orgFailUrl =  "$domen/Receipt.php";
      $orgTransactionType = "PreAuth";
      $orgInstallment = "";
      $orgRnd =  microtime();
 $orgRnd=str_replace(" ","",$orgRnd);
      $orgCurrency = "941";
$instalment='';
    $clientId  =  str_replace("|", "\\|", str_replace("\\", "\\\\", $orgClientId));
      $oid =   str_replace("|", "\\|", str_replace("\\", "\\\\", $orgOid));
      $amount = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgAmount));
      $okUrl =  str_replace("|", "\\|", str_replace("\\", "\\\\", $orgOkUrl));
      $failUrl = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgFailUrl));
      $transactionType = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgTransactionType));
      $installment = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgInstallment));
      $rnd = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgRnd));
$currency =   str_replace("|", "\\|", str_replace("\\", "\\\\", $orgCurrency));
   $storeKey =  str_replace("|", "\\|", str_replace("\\", "\\\\", $storeK)); $plainText = $clientId . "|" . $oid . "|" . $amount . "|" . $okUrl . "|" . $failUrl . "|" .$transactionType . "||" . $rnd . "||||" . $currency . "|" . $storeKey;
 $hashValue = hash('sha512', $plainText);
 $hash = base64_encode (pack('H*',$hashValue));
 $sakrij="";
 }
}
else
if($_POST['naruci_log']==2) 
{ 
$ime=$_POST['ime']; 
$posta=$_POST['posta']; 
$grad=$_POST['grad']; 
$pib=$_POST['pib']; 
$adresa=$_POST['adresa']; 
$email=$_POST['email']; 
$telefon=$_POST['telefon']; 
}
elseif($_POST['naruci_log']==1 and $_SESSION['userid']>0) 
{ 
$ze=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid]"); 
$ze1=mysqli_fetch_array($ze); 
$ime=$ze1['ime']; 
$posta=$ze1['postanski_broj']; 
$grad=$ze1['grad']; 
$pib=$ze1['pib']; 
$adresa=$ze1['ulica_broj']; 
$email=$ze1['email']; 
$telefon=$ze1['telefon'];  
}
if(isset($_POST['nacin']) and $_POST['nacin']!=4)
{
if(isset($_SESSION['userid']) and $_SESSION['userid']>0) 
$iuser="user_id=".$_SESSION['userid'].","; 
if(!mysqli_query($conn, "INSERT INTO porudzbine SET $iuser ime=".safe($ime).", adresa=".safe($adresa).", posta=".safe($posta).", grad=".safe($grad).", telefon=".safe($telefon).", email=".safe($email).", pib=".safe($pib).", nacin_placanja=".safe($_POST['nacin']).", nacin_isporuke=".safe(preg_replace('/\d/', '', $_POST['isporuka'])).", poruka=".safe($_POST['poruka']).", vreme='".time()."'")) echo mysqli_error();
$zid=mysqli_insert_id($conn) ; 
if($zid>0) 
{ 
$green="_green";  
$msgr=$langa['messag'][33];  $zasend='	 
<table style="width:100%;border-collapse:collapse;font-family:arial" border="1" cellpadding="4"> 
<tr><td>Broj porudzbine: </td><td align="left">'.$zid.'</td></tr> 
<tr><td>Datum porudzbine: </td><td align="left">'.date("d.m.Y H:s").'</td></tr> 
<tr><td>Ime i prezime: </td><td align="left">'.$ime.'</td></tr> 
<tr><td>Adresa (ulica i broj): </td><td align="left">'.$adresa.'</td></tr> 
<tr><td>Grad i br. poste: </td><td align="left">'.$grad.' ('.$posta.')</td></tr> 
<tr><td>Email adresa: </td><td align="left">'.$email.'</td></tr>
<tr><td>PIB: </td><td align="left">'.$pib.'</td></tr>
<tr><td>Telefon: </td><td align="left">'.$telefon.'</td></tr> 
<tr><td colspan="2">Poruka:<br>'.$_POST['poruka'].' </td></tr> 
</table> 
<br> 
<table style="width:100%;border-collapse:collapse;font-family:arial" border="1" cellpadding="4"> 
<thead> 
 <tr><td colspan="6"><b>Poručeni proizvodi</b></td></tr>
<tr class="cart_menu"> 
<td class="image" align="left">Slika</td> 
<td class="description" align="left">Proizvod</td> 
<td class="price">Cena</td> 
<td class="quantity">Količina</td> 
<td class="total">Svega</td> 
</tr> 
</thead> 
<tbody>'; 
if(isset($_SESSION[$sid])) 
{ 
$ukupno=0; 
foreach($_SESSION[$sid] as $key => $value)  
{ 
$cena_sum=0;  
$sum=0; 
if($key>0) 
{ 
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p 
        INNER JOIN prol pt ON p.id = pt.id_text 
        $inner_plus        
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");  
 $az1=mysqli_fetch_assoc($az);        
$cenar=$az1['cena'];
$cena_sum =roundCene($cenar,1);
$ukupno +=roundCene($cenar,1)*$value;
$sum =$value;
if($az1['tip']==4) $zalink=$all_links[2];
elseif($az1['tip']==6) $zalink=$all_links[48];
else $zalink=$all_links[3];
if(!mysqli_query($conn, "INSERT INTO poruceno SET id_porudzbine=$zid, id_pro=$az1[ide], naziv=".safe($az1['naslov']).", cena='".$az1['cena']."', kolicina=$value")) echo mysqli_error();   
$zasend .='<tr> 
<td class="cart_product"> 
<a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'/"> 
<img src="'.$patH.GALFOLDER.'/thumb/'.$az1['slika'].'" title="'.$az1['titleslike'].'"> 
</a> 
</td> 
<td class="cart_description"> 
<h4><a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'/">'.$az1['naslov'].'</a></h4> 
<p>Web ID: '.$az1['ide'].'</p> 
</td> 
<td class="cart_price text-center">
<p>'.format_ceneS($cena_sum,1).'</p>
</td> 
<td class="product-quantity"> 
<div class="quantity buttons_added"> 
<input size="2" class="input-text qty text" title="Kolicina" value="'.$value.'" readonly min="1" step="1"> 
</div> 
</td> 
<td class="cart_total text-center"> 
<p class="cart_total_price">'.formatCene($value*$cena_sum,1).'</p>
</td> 
</tr>'; 
/*if($az1['tip']==4) $catirG="Mobilni telefoni"; if($az1['tip']==6) $catirG="Televizori"; else $catirG="Oprema";
$addItems .=" _gaq.push(['_addItem', '$zid', '".$az1['ide']."','".str_replace("'","",$az1['naslov'])."','$catirG','".$az1['cena']."','$value' ]);\n\r";*/
} 
} 
}
$limdo=(int)$settings['limit_dostava'];
$dostava=(int)$settings['cena_dostave'];
if($ukupno<$limdo) $uku=str_replace(" RSD", "", formatCene($ukupno+$dostava,1));
else $uku=str_replace(" RSD", "", formatCene($ukupno,1));
if($_POST['nacin']==1) $inacin='Plaćanje gotovinski/pouzećem'; 
else 
if($_POST['nacin']==2) {
$inacin='Uplata na račun';
$racun='<p>Podaci za uplatu:<br>
<table style="background:url(https://amazonka.rs/slike/nalog-za-uplatu.jpg); width:794px; height:366px; background-repeat:no-repeat;overflow:hidden;position:relative;">
<tr>
<td style="padding-left:30px;padding-top:50px;height:20px;width:50%;">'.$arrwords['podaci_uplatioca'].'</td>
<td style="padding-left:250px;padding-top:40px;height:20px;;">='.$uku.'</td>
</tr>
<tr>
<td>&nbsp;</td>
<td style="padding-left:40px;padding-top:18px;height:10px">'.$arrwords['tekuci_racun'].'</td>
</tr>
<tr>
<td style="padding-left:30px;padding-top:5px;height:10px;">'.$arrwords['narudzbina_preko_sajta'].$zid.'</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td style="padding-left:130px;padding-top:0px;height:10px">'.$zid.'</td>
</tr>
<tr style="vertical-align:top;">
<td style="padding-left:30px;padding-top:19px;">'.$arrwords['podaci_firme'].'</td>
<td>&nbsp;</td>
</tr>
</table>
';
}
elseif($_POST['nacin']==4) $inacin='Platna kartica';
else $racun=''; 
$zasend .='
<tr> 
    <td colspan="3"> 
    <h4>Nacin placanja:</h4> 
    </td> 
    <td colspan="2"> 
    <p class="ukupno" style="font-size:13px;">'.$inacin.'</p> 
    </td> 
</tr>
<tr> 
    <td colspan="3"> 
    <h4>Nacin isporuke:</h4> 
    </td> 
    <td colspan="2"> 
    <p class="ukupno" style="font-size:13px;">'.preg_replace('/\d/', '', $_POST['isporuka']).'</p>
    </td> 
</tr>
<tr> 
    <td colspan="3"> 
    <h4>UKUPAN IZNOS:</h4> 
    </td> 
    <td colspan="2"> 
    <p class="ukupno" style="font-size:16px;"><b>';
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0)
  $zasend .="<span style='color:green;'>".formatCene($ukupno,1,$_SESSION['promo-kod']['vrednost_koda'])."</span><br>"."<span style='font-size:12px;'>(<del>".formatCene($ukupno,1)."</del>)</span>";
  else
  $zasend .=formatCene($ukupno,1);
  $zasend .='</b></p>
    </td> 
</tr>';
if($ukupno<$limdo) {
$uku=$ukupno+$dostava;
$zasend .='
<tr>
<td colspan="3">Troškovi dostave</td>
<td colspan="2">'.formatCene($dostava,1).'</td>
</tr>
<tr>
<td colspan="3"><h3>UKUPNO ZA PLAĆANJE</h3></td>
<td colspan="2"><h3>'.formatCene($uku,1).'</h3></td>
</tr>
';
}

/*if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']!="")
$zasend .='<tr>
    <td colspan="4">
    <h4>UKUPAN IZNOS sa promo kodom:</h4>
    </td>
    <td colspan="2">
    <p class="ukupno" style="font-size:16px;"><b>'.format_ceneS($ukupno,1,$_SESSION['promo-kod']['vrednost_koda']).'</b></p>
    </td>
</tr>';*/
$zasend .='<tr>
    <td colspan="5"> 
    <h5>NAPOMENA:</h5> 
	'.$racun.' 
    <p>Cene su prikazane u dinarima (RSD) sa uračunatim PDV-om. Plaćanje je isključivo u dinarima.</p> 
    </td> 
</tr>
					</tbody> 
				</table>'; 
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0)
$ukupno_za_an=formatCene($ukupno,1,$_SESSION['promo-kod']['vrednost_koda']);
else
$ukupno_za_an=formatCene($ukupno,1);
if($ukupno>0 or $ukupno_za_an>0)
$addTrans .=" _gaq.push(['_addTrans', '$zid', 'Amazonka', '".$ukupno_za_an."', '0.00', '0.00', '".preg_replace('/[^a-zA-Z]+/', '', $grad)."', '', 'RS']);\n\r";
$_SESSION['addItems']=$addItems; 
$_SESSION['addTrans']=$addTrans; 
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0) {
$idpromo=$_SESSION['promo-kod']['id'];
$ukupno_promo=sprintCene($ukupno,1, $_SESSION['promo-kod']['vrednost_koda']);
}
else {
$idpromo=0;
$ukupno_promo=0;
}
mysqli_query($conn, "UPDATE porudzbine SET iznos='".sprintCene($ukupno,1)."', iznos_sa_kodom='".$ukupno_promo."' , iznos_evra='".$settings['evro_iznos']."', idpromo='$idpromo' WHERE id=$zid");
if($idpromo>0)
mysqli_query($conn, "UPDATE promo_kodovi SET iskoriscen=iskoriscen+1 WHERE id=$idpromo");
unset($_SESSION[$sid]);
unset($_SESSION['promo-kod']);
unset($_SESSION['izf']);
$hider="style='display:none;'";  
//echo $zasend;
$aaa=sprintf($langa['messag'][35], $zid, $patH1, $domen, $zasend, $patH1, $domen); 
$aaa1=strip_html_tags($aaa); 
$subject=sprintf($langa['messag'][34],$zid)." - ".$domen; 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $email, $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1); 
send_email("mail", $settings["email_zaemail"], $settings["from_email"], $settings["from_email"], "$subject", $from_name, $aaa, $aaa1);  
//header("location: $patH1/$all_links[34]/"); 
?> 
<script type="text/javascript">  
window.location.assign("<?php echo $patH1?>/<?php echo $all_links[34]?>/");
</script> 
<?php 
}
}
} 
}
?>