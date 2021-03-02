<?php 
session_start();

$sid=session_id();

if($_SESSION['userids']>0 and ((isset($_POST['exportuj_ovo']) and $_POST['exportuj_ovo']!="") or isset($_GET['exportuj_sve'])))

{

include("../Connections/conn_admin.php");

require 'php-excel.class.php';

error_reporting(E_ALL);

ini_set('display_errors', TRUE);

ini_set('display_startup_errors', TRUE);

date_default_timezone_set('Europe/Belgrade');

$data[1] = array ('ID', 'Promo kod', 'Vrednost koda', 'Min. potrosnja', 'Višekratni', 'Vazi do', 'Kategorije', 'Iskorišćen', 'Blok');


if(isset($_POST['exportuj_ovo']) and $_POST['exportuj_ovo']!="")
{
$iovo = " WHERE id IN(".$_POST['exportuj_ovo'].")";
} else $iovo="";

$fi=mysqli_query($conn, "SELECT * FROM  promo_kodovi $iovo ORDER BY id DESC");

$n=2;

while($fi1=mysqli_fetch_assoc($fi))

{
if($fi1['tip_koda']==1) $dod= " rsd"; else $dod= " %";
if($fi1['upotrebljivost']==1)
$iskor= $fi1['iskoriscen'];
else
if($fi1['iskoriscen']==1 and $fi1['upotrebljivost']==0)
$iskor= "da";
else $iskor= "ne";
if($fi1['istekao']==1) $istek= "da"; else $istek= "ne";
// Miscellaneous glyphs, UTF-8


$kniz=array();
$k_arr=explode(",", $fi1['kategorije']);
foreach($kar_arr as $k => $v){
if(in_array($k,$k_arr))
$kniz[] = $kar_arr[$k];
}
$kategorije= implode(", ", $kniz);

$data[$n]=array($fi1['id'], $fi1['kod'], $fi1['vrednost_koda']." ".$dod, $fi1['min_potrosnja'], $fi1['upotrebljivost'], $fi1['vazi_do'], $kategorije, $iskor, $istek);

$n++;

}



$xls = new Excel_XML('UTF-8', false, 'Promo kodovi');
$xls->addArray($data);
$xls->generateXML('promo-kodovi');

}