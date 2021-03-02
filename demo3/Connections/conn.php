<?php 
include("configs.php");
$conn = @new mysqli($hostname_conn, $username_conn, $password_conn,$database_conn);
if ($conn->connect_error) {
    die('Doslo je do greske. Navratite kasnije ');
}

$conn->query("SET NAMES utf8");
$conn->query("SET CHARACTER SET utf8");
$conn->query("SET COLLATION_CONNECTION='utf8_unicode_ci'");

include($page_path2.SUBFOLDER."/include/functions.php"); 
if(isset($_POST['uris']))
$search_values=explode("?",strip_tags($_POST['uris']));
else
$search_values=explode("?",strip_tags(curPageURL()));
$nodom=str_replace("$patH1/","",$search_values[0]);
$sodom_ex=$nodom_ex=explode("/",$nodom);
$nodom_ex_r=array_reverse($nodom_ex);
if($nodom_ex_r[0]=="" or mb_eregi("/\?",$nodom))
array_shift($nodom_ex_r);
if(!preg_match("/.php/",$nodom_ex_r[0]) and !preg_match("/.html/",$nodom_ex_r[0])) $ici="/"; else $ici="";
$my_lang=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' ORDER BY pozicija");
while($mylang=mysqli_fetch_assoc($my_lang))
{
$jezici[]=$mylang['jezik'];
if($nodom_ex[0]==$mylang['jezik'])
{
$lang=$mylang['jezik'];
$langu=$mylang['jezik'];
array_shift($nodom_ex);
}
}
$fullink=implode("/",$nodom_ex);
if($lang=="")
{
$lang=$jezici[0];
$patH1=$patH1;
}else
$patH1=$patH1."/$lang";
if(isset($_GET['lang']) and $_GET['lang']!="")
$lang=strip_tags($_GET['lang']);
$allpage = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$lang'");
$all_links=array();
while($allpage1=mysqli_fetch_assoc($allpage))
{
$all_links[$allpage1['id']]=$allpage1['ulink'];
}
//print_r($all_links);
if($sodom_ex[0]!="") 
{
$page = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$lang' AND  ulink=".safe($sodom_ex[0])."");
$page1=mysqli_fetch_assoc($page);
if($page1['id']>0)
$ceolink=1;
}
else
{
$page=mysqli_query($conn, "SELECT  *, case when ulink IS NULL or ulink = ''
            then 'empty'
            else ulink
       end as ulink  FROM pagel WHERE lang='$lang'");
$page1=mysqli_fetch_assoc($page);
}

if($page1['id']>0 and $sodom_ex[1]!="")
{
$sub_er=explode("://", curPageURL());

if(mb_eregi("///",curPageURL()) or mb_eregi("//",$sub_er[1]))
{
header("location:$patH1/$sodom_ex[0]/$sodom_ex[1]/",TRUE,301);
echo "location:$patH1/$sodom_ex[0]/$sodom_ex[1]/";
exit();
}
/*else
if(count($sodom_ex)==4 and $sodom_ex[2]!="" and $page1['id']==3)
{
header("location:$patH1/$sodom_ex[0]/$nodom_ex_r[0]/",TRUE,301);
exit();
}*/
$spage = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$lang' AND  ulink=".safe($sodom_ex[1])." AND p.id_parent=$page1[id_page]");
$spage1=mysqli_fetch_assoc($spage);
$titles=$spage1['title']?$spage1['title']:$page1['naziv']." / ".$spage1['naziv'];
$keywords=$spage1["keywords"];
$descripts=$spage1["description"];
}

if($page1['id']>0 and mb_eregi(".html",$nodom_ex_r[0]))
{

if(isset($spage1['id_page'])) $ipagers=$spage1['id_page']; else $ipagers=$page1['id_page'];

$pate = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt='Y' AND p.id_page=$ipagers AND ulink=".safe(str_replace(".html","",$nodom_ex_r[0]))."");
$pate1=mysqli_fetch_array($pate);
if($pate1['id']>0)
{

$titles=$pate1['title']?$pate1['title']:$pate1['naslov'];
$keywords=$pate1["keywords"];
$descripts=$pate1["description"];
$and_tekst=" AND p.id=$pate1[id]";
$idup=$pate1['id'];

}

}
else
if($page1['id']>0 and $sodom_ex[1]!="" and empty($spage1['id']))
{


$pate = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt='Y' AND p.id_page=$page1[id_page] AND ulink=".safe($nodom_ex_r[0])."");
$pate1=mysqli_fetch_array($pate);
if($pate1['id']>0)
{
$titles=$pate1['title']?$pate1['title']:$pate1['naslov'];
$keywords=$pate1["keywords"];
$descripts=$pate1["description"];
$and_tekst=" AND p.id=$pate1[id]";

$idup=$pate1['id'];

}  
if(empty($pate1['id'])){
$dztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id_page=$page1[id_page] AND ulink=".safe($nodom_ex_r[0])."");
$dztz1=mysqli_fetch_array($dztz);
$titles=$dztz1['title']?$dztz1['title']:$dztz1['naslov'];
$keywords=$dztz1["keywords"];
if(empty($dztz1["description"])) $descripts=$titles; else $descripts=$dztz1["description"];
if(isset($dztz1['brend']) and $dztz1['brend']>0){
$brend=mysqli_query($conn, "SELECT * FROM stavkel WHERE id_page=$dztz1[brend] AND lang='$lang'");
$brend1=mysqli_fetch_assoc($brend);
$slbrend=mysqli_query($conn, "SELECT slika FROM stavke WHERE id=$brend1[id_page]");
$slbrend1=mysqli_fetch_assoc($slbrend);
}
}

if(isset($sodom_ex[1]) and mb_eregi("brend-",$sodom_ex[1])) {
$bap=mysqli_query($conn,"SELECT *, s.id as id FROM stavke s
INNER JOIN stavkel sl ON sl.id_page=s.id
WHERE s.id_cat=27 AND s.akt=1 AND sl.naziv='".str_replace("brend-","",$sodom_ex[1])."'");
$bap1=mysqli_fetch_assoc($bap);
$titles="Brend ".$bap1['naziv']." proizvodi";
$keywords="";
$descripts="";
}
else
if(empty($pate1['id']) and empty($dztz1['id'])){
if($sodom_ex[3]!="" and !mb_eregi("#",$sodom_ex[3]))
$uzmis=$sodom_ex[3];
else
if($sodom_ex[2]!="" and !mb_eregi("#",$sodom_ex[2]))
$uzmis=$sodom_ex[2];
else
$uzmis=$sodom_ex[1];
       $ztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$lang' AND  p.akt=1 AND  ulink=".safe($uzmis)." AND p.id_cat=32");
$ztz1=mysqli_fetch_array($ztz);

$katImpl="";
//if($sodom_ex[3]=="" or $sodom_ex[2]=="")
//$katSvi=$katImpl=kategorije($ztz1['ide'], 'stavke',1);
$subkategorije=kategorije($ztz1['ide'],'stavke',1);

$katSvi=$katImpl=katProArr($subkategorije, 'stavke',1);
//else $katSvi=$ztz1['ide'];

$titles=$ztz1['title']?$ztz1['title']:$ztz1['naziv'];
$keywords=$ztz1["keywords"];
$descripts=$ztz1["descriptions"];
}
}
else
if($page1['id']>0 and empty($spage1['id']))
{
$titles=$page1["title"]?$page1["title"]:$page1["h1"];
if($titles=="") $titles=$page1["naziv"];
$keywords=$page1["keywords"];
$descripts=$page1["description"]?$page1["description"]:$page1["h1"];
if($page1['ulink']==$all_links[11] or $page1['ulink']==$all_links[12])
{
$prof=mysqli_query($conn, "SELECT * FROM users_data WHERE nickname=".safe(strip_tags($nodom_ex_r[0]))." AND akt='Y' AND akt1='1'");
$prof1=mysqli_fetch_assoc($prof);
}
}
$arrayV = array(); 
$arrayD = array();
$arrayM = array();
$arrayL = array();
$arrayR = array();
$arrayF = array();
$arrayT = array();
if($page1['id']>0)
{ 
//if(isset($spage1['id']) and $spage1['id']>0)
//$fper=mysqli_query($conn, "SELECT * FROM page WHERE id='$spage1[id_page]'");
//else
$fper=mysqli_query($conn, "SELECT * FROM page WHERE id='$page1[id_page]'");
$fper1=mysqli_fetch_assoc($fper);
if($dztz1['id']>0 and $fper1['model1']>0) $modelcic=$fper1['model1']; else
$modelcic=$fper1['model'];
$iper=mysqli_query($conn, "SELECT * FROM page_models WHERE id_model='$modelcic'");
$iper1=mysqli_fetch_assoc($iper);
if($iper1['include_file_vrh']!="")
$arrayV = explode(",",$iper1['include_file_vrh']);
if($iper1['include_file_dole']!="")
$arrayD = explode(",",$iper1['include_file_dole']);
if($iper1['include_file_middle']!="")
$arrayM = explode(",",$iper1['include_file_middle']);
if($iper1['include_file_left']!="")
$arrayL = explode(",",$iper1['include_file_left']);
if($iper1['include_file_right']!="")
$arrayR = explode(",",$iper1['include_file_right']);
if($iper1['include_file_footer']!="")
$arrayF = explode(",",$iper1['include_file_footer']);
if($iper1['include_file_top']!="")
$arrayT = explode(",",$iper1['include_file_top']);
$class_left=$iper1['class_left'];
$class_middle=$iper1['class_middle'];
$class_right=$iper1['class_right'];
if($iper1['katu_pod']>0)
{
$ziper=mysqli_query($conn, "SELECT * FROM page_settings WHERE id_page='$iper1[katu_pod]'");
$ziper1=mysqli_fetch_assoc($ziper);
if($ziper1['include_file_vrh']!="")
$arrayV = explode(",",$ziper1['include_file_vrh']);
if($ziper1['include_file_dole']!="")
$arrayD = explode(",",$ziper1['include_file_dole']);
if($ziper1['include_file_middle']!="")
$arrayM = explode(",",$ziper1['include_file_middle']);
if($ziper1['include_file_left']!="")
$arrayL = explode(",",$ziper1['include_file_left']);
if($ziper1['include_file_right']!="")
$arrayR = explode(",",$ziper1['include_file_right']);
if($ziper1['include_file_footer']!="")
$arrayF = explode(",",$ziper1['include_file_footer']);
if($ziper1['include_file_top']!="")
$arrayT = explode(",",$ziper1['include_file_top']);
$class_left=$ziper1['class_left'];
$class_middle=$ziper1['class_middle'];
$class_right=$ziper1['class_right'];
}
$contD=count($arrayD);
$contV=count($arrayV);
$contM=count($arrayM);
$contL=count($arrayL);
$contR=count($arrayR);
$contT=count($arrayT);
$contF=count($arrayF);
} 
include("$page_path2".SUBFOLDERS."/language/$lang.php");
/*if($lang=='slo')
$patH1=$patH1;
  else
$patH1=$patH1."/".$lang;
 */
$base_arr=base_ret($_GET['base']);
$base_arr_r=base_ret_rev(curPageURL());
//echo $base_arr_r[0];
$strana = $_SERVER['PHP_SELF'];
$exp_str=explode("/",$strana);
$rev_str=array_reverse($exp_str);
$file_exp=explode(".php",$rev_str[0]);
$file_p="$file_exp[0]".".php";
$sett=mysqli_query($conn, "SELECT * FROM settings");
while($sett1=mysqli_fetch_assoc($sett))
{
$polje=$sett1['fields'];
$settings[$polje]=$sett1['vrednosti'];
}
$settb=mysqli_query($conn, "SELECT * FROM settings2");
while($settb1=mysqli_fetch_assoc($settb))
{
$polje=$settb1['fields'];
$settingsb[$polje]=$settb1['vrednosti'];
}
$podes=mysqli_query($conn, "SELECT * FROM izgled");
while($podes1=mysqli_fetch_assoc($podes))
{
$polj=$podes1['polje'];
$settingsc[$polj]=$podes1['vrednost'];
}
define("EVRO",$settings['evro_iznos']); 
$ge=array("");
$geti=array("");
putenv ("TZ=Europe/Belgrade");
$or_arr=array("---", $arrwords2['orijent1'], $arrwords2['orijent2'], $arrwords2['orijent3'], $arrwords2['orijent4']);  
$tra_arr=array("---", $arrwords2['tmuski'], $arrwords2['tzenski'], 
$arrwords2['tnebitno']);
$sta_arr=array("---", $arrwords2['sta1'], $arrwords2['sta2'], 
$arrwords2['sta3'], $arrwords2['sta4']);
$ovde_arr=array("---", $arrwords2['ovde1'], $arrwords2['ovde2'], 
$arrwords2['ovde3'], $arrwords2['ovde4'], $arrwords2['ovde5']);
include($page_path2."/".SUBFOLDERS."include/login_check.php");
if($page1['show_for_users']==1 and  !isset($_SESSION['userid']))
{
$_SESSION['forredi']=curPageURL();
header("location: $patH1/".$all_links[10]."/");
}
if(isset($_SESSION['userid']) and $_SESSION['userid']>0)
{
$blo=mysqli_query($conn, "SELECT * FROM kontakt_blok WHERE bloker='$_SESSION[userid]' OR blokiran='$_SESSION[userid]'");
$oht=$oht1=array();
while($blo1=mysqli_fetch_assoc($blo))
{
$oht[$blo1['tip']][$blo1['bloker']]=$blo1['blokiran'];
$oht1[$blo1['tip']][$blo1['blokiran']]=$blo1['bloker'];
}
$blo=mysqli_query($conn, "SELECT * FROM kontakt_blok_privremena WHERE bloker='$_SESSION[userid]' or blokiran='$_SESSION[userid]'");
$zoht=$zoht1=array();
while($blo1=mysqli_fetch_assoc($blo))
{
$zoht[$blo1['tip']][$blo1['bloker']]=$blo1['blokiran'];
$zoht1[$blo1['tip']][$blo1['blokiran']]=$blo1['bloker'];
}
$blo=mysqli_query($conn, "SELECT * FROM kontakt_prijatelji WHERE bloker='$_SESSION[userid]' OR blokiran='$_SESSION[userid]'");
$poht=$oht1=array();
while($blo1=mysqli_fetch_assoc($blo))
{
$poht[$blo1['tip']][$blo1['bloker']]=$blo1['blokiran'];
$poht1[$blo1['tip']][$blo1['blokiran']]=$blo1['bloker'];
}
}
$search_values=explode("?",strip_tags(curPageURL()));
if($search_values[1])
{
$search_values[1]=urldecode($search_values[1]);
parse_str($search_values[1],$sarray);
parse_str($search_values[1],$sarrayP);
}
if(!isset($_SESSION['userid']) and $page1['show_for_users']==1)
header("location: $patH1/$all_links[10]/");
if(empty($dztz1['id']) and empty($pate1['id']) and empty($page1['id']))
$nstop=100;
if(isset($ztz1['ide']) and $ztz1['ide']>0){

$brend_kat_arr=array(0);
$vi=mysqli_query($conn, "SELECT * FROM brend_kategorije WHERE kategorija IN($subkategorije)");
while($vi1=mysqli_fetch_assoc($vi)){
$brend_kat_arr[]=$vi1['brend'];
}

$stavke_kat_arr=array(0);
$vi=mysqli_query($conn, "SELECT * FROM stavke_kategorije WHERE kategorija IN($subkategorije)");
while($vi1=mysqli_fetch_assoc($vi)){
$stavke_kat_arr[]=$vi1['stavka'];
}
}
$modulArr=array();
$md=mysqli_query($conn, "SELECT * FROM moduli");
while($md1=mysqli_fetch_assoc($md)){
$modulArr[$md1['upotreba']]=$md1['status'];
}

$filtAll=array();
$ff=mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang'");
while($ff1=mysqli_fetch_assoc($ff)){
$filtAll[$ff1['id_page']]=$ff1;
}

if(isset($_POST['uris']))
{
$koren=explode("#",$_POST['uris']);
$zapagin=$koren[0];
$sodom=explode("/",$koren[0]);
$sodomR=array_reverse($sodom);
unset($sodomR[0]);
if($sodomR[1]!="" or $sodomR[2]!="" or $sodomR[3]!="")
{

$uzmis=$sodomR[1];
$ztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND  p.akt=1 AND  ulink=".safe($uzmis)." AND p.id_cat=32");
$ztz1=mysqli_fetch_array($ztz);

if(isset($sodom_ex[1]) and mb_eregi("brend-",$sodom_ex[1])) {
$katSvi=$subkategorije="";
} else {
$subkategorije=kategorije($ztz1['ide'],'stavke',1);

$katSvi=$katImpl=katProArr($subkategorije, 'stavke',1);
}
if(isset($ztz1['ide']) and $ztz1['ide']>0){
$brend_kat_arr=array(0);
$vi=mysqli_query($conn, "SELECT * FROM brend_kategorije WHERE kategorija IN($subkategorije)");
while($vi1=mysqli_fetch_assoc($vi)){
$brend_kat_arr[]=$vi1['brend'];
}

$stavke_kat_arr=array(0);
$vi=mysqli_query($conn, "SELECT * FROM stavke_kategorije WHERE kategorija IN($subkategorije)");
while($vi1=mysqli_fetch_assoc($vi)){
$stavke_kat_arr[]=$vi1['stavka'];
}
}
}
}
else
$zapagin=curPageURL();
$brendd=array();
$brend=mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang'");
while($brends=mysqli_fetch_assoc($brend)){
$brendd[$brends['id_page']]=$brends;
}
$noaNiz=array('1'=>'akcija', '2'=>'novo', '3'=>'izdvojeni', '4'=>'naslovna', '5'=>'vegan');
if(isset($_COOKIE['valuta']))
$idvalute="";
else
$idvalute=1;
$valke=$_GET['va']?$_GET['va']:$idvalute;
$mlista="";
$inner_plus1="";

if(isset($_POST['hashe']) and $_POST['hashe']!="")
{
$arr=array();
$hash=str_replace("#","",$_POST['hashe']);
parse_str($hash, $hashA);
unset($hashA[0]);
}
$hashAP=$hashA;

if($hashA['filt1']!="")
{

$na=explode("-",$hashA['filt1']);
foreach($noaNiz as $k => $v) {
if(in_array($k,$na))
$inner_plus1 .=" AND p.$v=1";
}
}
if($hashA['brend']!="")
{
$inner_plus1 .=" AND brend IN(".str_replace("-",",",$hashA['brend']).")";
}
if($hashA['price']!="")
{
$ecena=explode("-",$hashA['price']);
$cena1=$ecena[0]*1;
$cena2=$ecena[1]*1;
if($valke>0)
{
$cena1=($cena1/EVRO);
$cena2=($cena2/EVRO);
}
$inner_plus1 .=" AND cena BETWEEN $cena1 AND $cena2";
}
//$mlista .=$inner_plus1;
if($katImpl!="")
$inner_plus1 .=" AND p.id IN($katImpl)";
else
if($ztz1['ide']>0)
{
$inner_plus1 .=" AND p.id=".$ztz1['ide'];
}

$filtNiz=array();
$koniPlus="";
if(isset($hashA['filter'])){

$filtArr=explode("-",$hashA['filter']);
$parentArr=array();
foreach($filtArr as $k => $v) {
$parent_id=$brendd[$v]['id_parent'];
$parentArr[]=$parent_id;
$filtNiz[$parent_id][]="find_in_set($v, filteri)";
}
foreach($filtNiz as $k => $v){
$nnee[]="(".implode(" OR ", $v).")";
}
$koniPlus=" AND ".implode(" AND ",$nnee);

$filtArrNew=array();
foreach($filtArr as $k => $v) {
$parent_id=$brendd[$v]['id_parent'];
$filtArrNew[$v]=$brendd[$parent_id]['naziv']." &raquo; ".$brendd[$v]['naziv'];
$filtNiz[]=$v;
}
}
if(isset($bap1['id']) and $bap1['id']>0)
$ibrendis=" AND p.brend=".$bap1['id'];
else
$ibrendis="";

$zasum=mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1 AND p.tip=5 $koniPlus $inner_plus1$ibrendis  GROUP BY p.id");
        $br_upisa=0;
        $minMax=array();
 while($mikes1=mysqli_fetch_assoc($zasum)){
$minMax[]=$mikes1['cena'];
$br_upisa++;
 }
if(count($minMax)>0){
 $mic= round(min($minMax));
$mac= round(max($minMax));
} else
$mic=$mac=0;

$uvoz="https://www.obrenovac.biz/dev/admin";