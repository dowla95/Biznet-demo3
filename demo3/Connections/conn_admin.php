<?php 
include("configs.php");
$conn = new mysqli($hostname_conn, $username_conn, $password_conn,$database_conn);
mysqli_query($conn, "SET NAMES utf8");
mysqli_query($conn, "SET CHARACTER SET utf8");
mysqli_query($conn, "SET COLLATION_CONNECTION='utf8_unicode_ci'");

$sett=mysqli_query($conn, "SELECT * FROM settings");
while($sett1=mysqli_fetch_assoc($sett))
{
$polje=$sett1['fields'];
$settings[$polje]=$sett1['vrednosti'];
}

$page_add_array=array(
"page"=>array("naslov"=>"varchar","naziv"=>"varchar","podnaslov"=>"varchar","ulink"=>"varchar","h1"=>"varchar","title"=>"varchar","keywords"=>"varchar","description"=>"text"),
"pages_text"=>array("naslov"=>"varchar","opis"=>"text","opis1"=>"text","ulink"=>"varchar","h2"=>"varchar","title"=>"varchar","keyword"=>"varchar","description"=>"text","altslike"=>"varchar","titleslike"=>"varchar","altslike1"=>"varchar","titleslike1"=>"varchar","altslike2"=>"varchar","titleslike2"=>"varchar","altslike3"=>"varchar","titleslike3"=>"varchar"),
"slike"=>array("naslov"=>"varchar","link"=>"varchar","alt"=>"varchar","opis"=>"varchar"),
"slike_paintb"=>array("naslov"=>"varchar","link"=>"varchar","opis"=>"text"),
"categories_galery"=>array("naziv"=>"varchar","title"=>"varchar","keywords"=>"varchar","description"=>"text"),
"files"=>array("naslov"=>"varchar","opis"=>"text"),
"files_paintb"=>array("naslov"=>"varchar","opis"=>"text"),
"galerija"=>array("naslov"=>"varchar","opis"=>"text"),
"stavke"=>array("naziv"=>"varchar")
);



function langdir()
{
global $conn;
$lniz=array();
 $svlang=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' ORDER BY pozicija ASC");
while($svlang1=@mysqli_fetch_array($svlang))
{
$zupa=$svlang1['id'];
$lniz[$zupa]=$svlang1['jezik'];
}  
return $lniz;
}

$lniz=langdir();
/* jeziku u panelu po defaultu za ispise iz baze */
$amlang="rs";

$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jezici[]=$la1['jezik']; 
 }
$firstlang=$jezici[0]; 
include("$page_path2".SUBFOLDERS."/language/$firstlang.php");
include("$page_path2/".SUBFOLDER."admin/language/srb.php");
include($page_path2."/".SUBFOLDER."include/functions.php");

$stav = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND id_cat=8 ORDER BY -position DESC");
$drz_arr[]="---";        
while($stav1=mysqli_fetch_assoc($stav))
{
$drz_arr[]=$stav1['naziv'];
}

$staV = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND id_cat=17 ORDER BY -position DESC");
$drz_arr1[]="---";        
while($staV1=mysqli_fetch_assoc($staV))
{
$drz_arr1[]=$staV1['naziv'];
}                
//$drz_arr=array("---", "Austrija", "Nemačka", "Francuska", "Italija", "SAD", $arrwords2['orijent4']);
//$drz_arr1=array("---", "Srbija", "Hrvatska", "Bosna i Hercegovina", "Crna Gora", "Makedonija", $arrwords2['orijent5']);
$or_arr=array("---", $arrwords2['orijent1'], $arrwords2['orijent2'], $arrwords2['orijent3'], $arrwords2['orijent4']);  
$tra_arr=array("---", $arrwords2['tmuski'], $arrwords2['tzenski'], 
$arrwords2['tnebitno']);

$sta_arr=array("---", $arrwords2['sta1'], $arrwords2['sta2'], 
$arrwords2['sta3'], $arrwords2['sta4']);
$ovde_arr=array("---", $arrwords2['ovde1'], $arrwords2['ovde2'], 
$arrwords2['ovde3'], $arrwords2['ovde4'], $arrwords2['ovde5']);


$allpage = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang'");
$all_links=array();
while($allpage1=mysqli_fetch_assoc($allpage))
{
$all_links[$allpage1['id']]=$allpage1['ulink'];
}
$modulArr=array();
$md=mysqli_query($conn, "SELECT * FROM moduli");
while($md1=mysqli_fetch_assoc($md)){
$modulArr[$md1['upotreba']]=$md1['status'];
}
$deli="http://www.obrenovac.biz";
$podes=mysqli_query($conn, "SELECT * FROM izgled");
while($podes1=mysqli_fetch_assoc($podes))
{
$polj=$podes1['polje'];
$settingsc[$polj]=$podes1['vrednost'];
}
$uvoz="http://www.obrenovac.biz/dev/admin";