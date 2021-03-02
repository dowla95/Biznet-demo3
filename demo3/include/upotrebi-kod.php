<?php 
session_start([
    'cookie_lifetime' => 86400,
]);
$sid=session_id();
include("../Connections/conn.php");
include("Izvrsenja.php");
foreach($_POST as $k => $v){
if($v!="") {
if($k=="isporuka") $v=(int) filter_var($v, FILTER_SANITIZE_NUMBER_INT);
$_SESSION['izf'][$k]=$v;
}
}
unset($_SESSION['promo-kod']);
if(!isset($_GET['zanemari'])) {
if(!isset($_POST['promo-kod']) or trim($_POST['promo-kod'])=="")
echo "Upišite promo kod!";
elseif(isset($_POST['promo-kod']) and trim($_POST['promo-kod'])!="")
{
$array = array();
$ima=0;
$promo=mysqli_query($conn, "SELECT * FROM promo_kodovi");
while($promo1=mysqli_fetch_assoc($promo)){
 if($promo1['kod']==trim($_POST['promo-kod']))
 {
 $ima=1;
 if(($promo1['iskoriscen']==1 and $promo1['upotrebljivost']==0) or $promo1['istekao']==1 or date("Y-m-d H:i:s")>=$promo1['vazi_do']) {
 $ima=0;
 }
 if($ima==1)
 $array[0] = $promo1;
 }
}
if($ima==0)
 echo "Uneli ste pogrešan PROMO KOD. <br>Molimo Vas pokušajte ponovo!";
 else {

$kateg=explode(",",$array[0]['kategorije']);
 $ukupno=0;
 $ukupno_min=0;
  $kat=array();
 foreach($_SESSION[$sid] as $key => $value)
 {
 if($key>0)
 {
 $az = mysqli_query($conn, "SELECT * FROM pro WHERE akt=1 AND id=$key");
 $az1=mysqli_fetch_assoc($az);
// $ukupno +=format_ceneS1($az1['cena']*$value,1);
 if(in_array($az1['tip'], $kateg))
 $ukupno_min +=format_ceneS1($az1['cena']*$value,1);
 $ukupno +=format_ceneS1($az1['cena']*$value,1);
 $kat[]=$az1['tip'];
 }
 }
$kat=array_unique($kat);
$result =  empty(array_intersect($kateg, $kat));
if($result==1)
echo "Ne postoje proizvodi za koje važi promo kod";
else {
$ukupno_min=round($ukupno_min);
if($array[0]['tip_koda']==1 and $array[0]['min_potrosnja']>$ukupno_min)
echo  "Niste ostvarili minimalnu potrošnju (".$array[0]['min_potrosnja'].") za realizaciju popusta promo kodom!";
else {

$_SESSION['promo-kod']['id']=$array[0]['id'];
$_SESSION['promo-kod']['kod']=$array[0]['kod'];
$_SESSION['promo-kod']['upotrebljivost']=$array[0]['upotrebljivost'];
$_SESSION['promo-kod']['tip_koda']=$array[0]['tip_koda'];
$_SESSION['promo-kod']['broj_kodova']=$array[0]['broj_kodova'];
$_SESSION['promo-kod']['min_potrosnja']=$array[0]['min_potrosnja'];
$_SESSION['promo-kod']['kategorije']=$array[0]['kategorije'];
if($array[0]['tip_koda']==1)
$_SESSION['promo-kod']['vrednost_koda']=$array[0]['vrednost_koda'];
else {
$cc=round($ukupno_min*($array[0]['vrednost_koda']/100));
$_SESSION['promo-kod']['vrednost_koda']=$cc;
}
echo 1;
}

}
}
}
}
?>