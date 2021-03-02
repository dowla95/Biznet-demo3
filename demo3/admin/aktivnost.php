<?php 
session_start();
include("../Connections/conn_admin.php");
 
if(isset($_POST['tabela']) and $_POST['id']>0 and $_SESSION[userids]>0)
{
$tab_kol=explode("-",$_POST[tabela]);
$upit=mysqli_query($conn, "SELECT * FROM ".$tab_kol[0]." WHERE $_POST[kolona]=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1[$tab_kol[1]]==1) $akti=0; else $akti=1;
mysqli_query($conn, "UPDATE ".$tab_kol[0]." SET ".$tab_kol[1]."='$akti' WHERE $_POST[kolona]=$_POST[id]");
}

if(($_POST['tip']=="delete_categories" or $_POST['tip']=="delete_page") and $_SESSION['userids']>0)
{
$katke=kategorije($_POST['id'],"page",1);

/*$texi=mysqli_query($conn, "SELECT * FROM pages_text WHERE id_page IN($katke)");
while($texi1=mysqli_fetch_assoc($texi))
{
$fxi=mysqli_query($conn, "SELECT * FROM files WHERE idupisa='$texi1[id]'");
while($fxi1=mysqli_fetch_assoc($fxi))
{
@unlink("..".FILFOLDER."/$fxi1[slika]");
mysqli_query($conn, "DELETE FROM files_lang WHERE id_fajla='$fxi1[id]'");
}
$sxi=mysqli_query($conn, "SELECT * FROM slike WHERE idupisa='$texi1[id]'");
while($sxi1=mysqli_fetch_assoc($sxi))
{
@unlink("..".GALFOLDER."/$sxi1[slika]");
@unlink("..".GALFOLDER."/thumb/$sxi1[slika]");
mysqli_query($conn, "DELETE FROM slike_lang WHERE id_slike='$sxi1[id]'");
}
@unlink("..".GALFOLDER."/thumb/$texi1[slika]");
@unlink("..".GALFOLDER."/$texi1[slika]");
mysqli_query($conn, "DELETE FROM files WHERE idupisa='$texi1[id]'");
mysqli_query($conn, "DELETE FROM slike WHERE idupisa='$texi1[id]'");
mysqli_query($conn, "DELETE FROM pages_text_lang WHERE id_text='$texi1[id]'");
mysqli_query($conn, "DELETE FROM pages_text_kat WHERE id_text='$texi1[id]'");
}
mysqli_query($conn, "DELETE FROM pages_text WHERE id_page IN ($katke)");*/
mysqli_query($conn, "DELETE FROM page WHERE id IN ($katke)"); 
mysqli_query($conn, "DELETE FROM pagel WHERE id_page IN ($katke)");
if($_POST[tip]=="delete_categories")
mysqli_query($conn, "DELETE FROM categories WHERE id='$_POST[id]'");
}

if($_POST['tip']=="promo_kodovi_del" and $_SESSION['userids']>0)
mysqli_query($conn, "DELETE FROM promo_kodovi WHERE id='$_POST[id]'");

if($_POST['tip']=="delete_tekst" and $_SESSION['userids']>0)
{
$katke=$_POST['id'];

$texi=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$katke");
while($texi1=mysqli_fetch_assoc($texi))
{
$fxi=mysqli_query($conn, "SELECT * FROM files WHERE idupisa='$texi1[id]'");
while($fxi1=mysqli_fetch_assoc($fxi))
{
@unlink("..".FILFOLDER."/$fxi1[slika]");
mysqli_query($conn, "DELETE FROM files_lang WHERE id_fajla='$fxi1[id]'");
}
$sxi=mysqli_query($conn, "SELECT * FROM slike WHERE idupisa='$texi1[id]'");
while($sxi1=mysqli_fetch_assoc($sxi))
{
@unlink("..".GALFOLDER."/$sxi1[slika]");
@unlink("..".GALFOLDER."/thumb/$sxi1[slika]");
mysqli_query($conn, "DELETE FROM slike_lang WHERE id_slike='$sxi1[id]'");
}
@unlink("..".GALFOLDER."/thumb/$texi1[slika]");
@unlink("..".GALFOLDER."/$texi1[slika]");
mysqli_query($conn, "DELETE FROM files WHERE idupisa='$texi1[id]'");
mysqli_query($conn, "DELETE FROM slike WHERE idupisa='$texi1[id]'");
mysqli_query($conn, "DELETE FROM pages_text_lang WHERE id_text='$texi1[id]'");
mysqli_query($conn, "DELETE FROM pages_text_kat WHERE id_text='$texi1[id]'");
}
mysqli_query($conn, "DELETE FROM pages_text WHERE id=$katke"); 
 
}
if($_POST['tip']=="delete_pro" and $_SESSION['userids']>0)
{

$sxi=mysqli_query($conn, "SELECT * FROM slike WHERE idupisa='$_POST[id]'");
while($sxi1=mysqli_fetch_assoc($sxi))
{
@unlink("..".GALFOLDER."/$sxi1[slika]");
@unlink("..".GALFOLDER."/thumb/$sxi1[slika]");
mysqli_query($conn, "DELETE FROM slike_lang WHERE id_slike='$sxi1[id]'");
}

mysqli_query($conn, "DELETE FROM pro WHERE id=$_POST[id]"); 
mysqli_query($conn, "DELETE FROM prol WHERE id_text=$_POST[id]");

mysqli_query($conn, "DELETE FROM slike WHERE idupisa='$_POST[id]'");
mysqli_query($conn, "DELETE FROM komentari WHERE id_user1='$_POST[id]'");
}

if($_POST['tip']=="obavestenja_proizvod" and $_SESSION['userids']>0)
{
mysqli_query($conn, "DELETE FROM obavestenja_proizvod WHERE id=$_POST[id]");

}

if($_POST['tip']=="delete_menus" and $_SESSION['userids']>0)
{ 
mysqli_query($conn, "DELETE FROM menus_list WHERE id_model=$_POST[id]");
mysqli_query($conn, "DELETE FROM categories_group WHERE id=$_POST[id]");
} 

if($_POST['tip']=="delete_models" and $_SESSION['userids']>0)
{ 
mysqli_query($conn, "DELETE FROM page_models WHERE id_model=$_POST[id]");
mysqli_query($conn, "DELETE FROM categories_group WHERE id=$_POST[id]");
} 

if($_POST['tip']=="delete_stavke" and $_SESSION['userids']>0)
{
$oho=mysqli_query($conn, "SELECT * FROM stavke WHERE id_cat=$_POST[id]");
while($oho1=mysqli_fetch_assoc($oho))
{ 
mysqli_query($conn, "DELETE FROM stavkel WHERE id_page='$oho1[id]'");
}
mysqli_query($conn, "DELETE FROM stavke WHERE id_cat='$_POST[id]'");
mysqli_query($conn, "DELETE FROM categories_group WHERE id='$_POST[id]'");
}

if($_POST['tip']=="delete_oglas" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM slike_paintb WHERE idupisa=$_POST[id] AND tip=1");
while($upit1=mysqli_fetch_assoc($upit))
{
@unlink("..".GALFOLDER."/$upit1[slika]");
}
mysqli_query($conn, "DELETE FROM slike_paintb WHERE idupisa=$_POST[id] AND tip=1");
mysqli_query($conn, "DELETE FROM content_oglas WHERE ido=$_POST[id]");
mysqli_query($conn, "DELETE FROM oglas_number_rooms WHERE ido=$_POST[id]");
$it=mysqli_query($conn, "SELECT * FROM oglasi WHERE id=$_POST[id]");
$it1=mysqli_fetch_assoc($it);
@unlink("..".GALFOLDER."/$it1[slika]");
mysqli_query($conn, "DELETE FROM comments WHERE id_pro=$_POST[id] AND tip=1");
mysqli_query($conn, "DELETE FROM rezervacije WHERE id_ap=$_POST[id]");
mysqli_query($conn, "DELETE FROM oglasi WHERE id=$_POST[id]");
mysqli_query($conn, "DELETE FROM settings_show WHERE idupisa=$_POST[id] AND tip=1");
}
if($_POST['tip']=="delete_users" and $_SESSION['userids']>0)
{
$it=mysqli_query($conn, "SELECT * FROM porudzbine WHERE user_id=$_POST[id]");
while($it1=mysqli_fetch_assoc($it))
{
mysqli_query($conn, "DELETE FROM poruceno WHERE id_porudzbine=$it1[id]");
}
mysqli_query($conn, "DELETE FROM users_data WHERE user_id=$_POST[id]");
mysqli_query($conn, "DELETE FROM porudzbine WHERE user_id=$_POST[id]");
}
if($_POST['tip']=="delete_rezerv" and $_SESSION['userids']>0)
{
mysqli_query($conn, "DELETE FROM porudzbine WHERE id=$_POST[id]");
mysqli_query($conn, "DELETE FROM poruceno WHERE id_porudzbine=$_POST[id]");
}
if($_POST['tip']=="subscribers" and $_SESSION['userids']>0)
{

mysqli_query($conn, "DELETE FROM subscribers WHERE id=$_POST[id]");

}
if($_POST['tip']=="status_porudzbine" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM porudzbine WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['status']==1) $akti=0; else $akti=1; 
if($akti==1) $dater="'".date("Y-m-d")."'"; else $dater="NULL";
mysqli_query($conn, "UPDATE porudzbine SET status=$akti, datum_isporuke=$dater WHERE id=$_POST[id]");
}
if($_POST['tip']=="delete_koment" and $_SESSION['userids']>0)
{
mysqli_query($conn, "DELETE FROM comments WHERE id=$_POST[id]");
}
if($_POST['tip']=="delete_admin" and $_SESSION['userids']>0)
{
mysqli_query($conn, "DELETE FROM users_admin WHERE user_id=$_POST[id]");
}
if($_POST['tip']=="akti_lang" and $_SESSION['userids']>0)
{
mysqli_query($conn, "UPDATE language SET akt='N'");
 foreach($_POST['id'] as $key=>$value)
 {

mysqli_query($conn, "UPDATE language SET akt='Y' WHERE id=$value");
}
}
if($_POST['tip']=="def_lang" and $_SESSION['userids']>0)
{
mysqli_query($conn, "UPDATE language SET instal='0'");
mysqli_query($conn, "UPDATE language SET instal='1' WHERE id=$_POST[id]");
}
if($_POST['tip']=="oglasi" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM oglasi WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt1']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE oglasi SET akt1=$akti WHERE id=$_POST[id]");
}
if($_POST['tip']=="akti" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM oglasi WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt']=="Y") $akti="N"; else $akti="Y"; 
mysqli_query($conn, "UPDATE oglasi SET akt='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="akti_ppp" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM page WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE page SET akt='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="akti_page" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt']=="Y") $akti="N"; else $akti="Y"; 
mysqli_query($conn, "UPDATE pages_text SET akt='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="akti_pro" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM pro WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE pro SET akt='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="mega" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM stavke WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['mega_menu']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE stavke SET mega_menu='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="lager_pro" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM pro WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['lager']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE pro SET lager='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="istakni_kat1" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM stavkel WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['istakni']==1) $akti=0; else $akti=1;
mysqli_query($conn, "UPDATE stavkel SET istakni='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="istakni_kat2" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM stavkel WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['istakni']==1) $akti=0; else $akti=1;
mysqli_query($conn, "UPDATE stavkel SET istakni='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="istakni_kat3" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM stavkel WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['istakni']==1) $akti=0; else $akti=1;
mysqli_query($conn, "UPDATE stavkel SET istakni='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="proizvodi" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM proizvodi WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt']=="Y") $akti="N"; else $akti="Y"; 
mysqli_query($conn, "UPDATE proizvodi SET akt='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="akti_koment" and $_SESSION[userids]>0)
{
$upit=mysqli_query($conn, "SELECT * FROM comments WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt']=="Y") $akti="N"; else $akti="Y"; 
mysqli_query($conn, "UPDATE comments SET akt='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="akti_us" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt']=="Y") $akti="N"; else $akti="Y"; 
//mysqli_query($conn, "UPDATE oglasi SET akt='$akti' WHERE user_id=$_POST[id]");
mysqli_query($conn, "UPDATE users_data SET akt='$akti' WHERE user_id=$_POST[id]");
}

if($_POST['tip']=="akti_subs" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM subscribers WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
 
if($upit1['akt']==1) $akti=0; else $akti=1; 

mysqli_query($conn, "UPDATE subscribers SET akt='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="akti_us_admin" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM users_admin WHERE user_id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt']=="Y") $akti="N"; else $akti="Y"; 
mysqli_query($conn, "UPDATE users_admin SET akt='$akti' WHERE user_id=$_POST[id]");
}
if($_POST['tip']=="paket" and $_SESSION['userids']>0)
{
$paki=explode("-",$_POST['id']);
$paket=$paki[0]; 
$id=$paki[1]; 
//if($paket==0)
  
$ipoz=", pozicija=NULL";
mysqli_query($conn, "UPDATE oglasi SET paket='$paket'$ipoz WHERE id=$id");
}
if($_POST['tip']=="oglasik" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM oglasi_kandidati WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt1']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE oglasi_kandidati SET akt1=$akti WHERE id=$_POST[id]");
}
if($_POST['tip']=="oglasi_konurisanje" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM oglasi WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt2']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE oglasi SET akt2=$akti WHERE id=$_POST[id]");
}
if($_POST['tip']=="sms" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM oglasi WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['sms']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE oglasi SET sms=$akti WHERE id=$_POST[id]");
}
if($_POST['tip']=="coment" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['coment']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE pages_text SET coment=$akti WHERE id=$_POST[id]");
}
if($_POST['tip']=="comentf" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['comentf']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE pages_text SET comentf=$akti WHERE id=$_POST[id]");
}
if($_POST['tip']=="show_image" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM slike_paintb WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['akt']=="Y") $akti="N"; else $akti="Y"; 
mysqli_query($conn, "UPDATE slike_paintb SET akt='$akti' WHERE id=$_POST[id]");
}
if($_POST['tip']=="izdvojeni_desno" and $_SESSION['userids']>0)
{
$upit=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['izdvojeni_desno']==1) $akti=0; else $akti=1; 
mysqli_query($conn, "UPDATE pages_text SET izdvojeni_desno=$akti WHERE id=$_POST[id]");
}
if(($_POST['tip']=="prijave_na_oglas" or $_POST['tip']=="prijave_na_oglas1") and $_SESSION['userids']>0)
{

$upit=mysqli_query($conn, "SELECT * FROM $_POST[tip] WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['izdvojeno']==1) $akti=0; else $akti=1;  echo $akti;
mysqli_query($conn, "UPDATE $_POST[tip] SET izdvojeno=$akti WHERE id=$_POST[id]");
}

if($_POST['tip']=="blokiraj_korisnika" and $_SESSION['userids']>0)
{
 $se=mysqli_query($conn, "SELECT * FROM kontakt_blok WHERE bloker='$_SESSION[userids]' AND blokiran=".safe($_POST['id'])."");
if(mysqli_num_rows($se)==0)
mysqli_query($conn, "INSERT INTO kontakt_blok SET bloker='$_SESSION[userids]', blokiran=".safe($_POST['id'])."");
else
mysqli_query($conn, "DELETE FROM kontakt_blok WHERE bloker='$_SESSION[userids]' AND blokiran=".safe($_POST['id'])."");
 
}
if($_POST['tip']=="omoguci_odgovore_kandidata_naprijavu" and $_SESSION['userids']>0)
{

$upit=mysqli_query($conn, "SELECT * FROM prijave_na_oglas WHERE id=$_POST[id]");
$upit1=mysqli_fetch_assoc($upit);
if($upit1['omoguci_kandidatu']==1) $akti=0; else $akti=1;  echo $akti;
mysqli_query($conn, "UPDATE prijave_na_oglas SET omoguci_kandidatu=$akti WHERE id=$_POST[id]");
}

if($_POST['tab']=="language")
{
$la=mysqli_query($conn, "SELECT * FROM language WHERE id='$_POST[id]'");
$la1=mysqli_fetch_array($la);
@unlink("$page_path2".SUBFOLDER."/images/icon/$la1[slika]");
mysqli_query($conn, "DELETE FROM language WHERE jezik='$la1[jezik]' LIMIT 1");
mysqli_query($conn, "DELETE FROM language2 WHERE jezik='$la1[jezik]' LIMIT 1");
 
//alter($la1['jezik'],$page_add_array,"del");
}
?>