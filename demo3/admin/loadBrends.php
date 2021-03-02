<?php 
include("../Connections/conn_admin.php");


$brend_kat=array(0);
if($_POST['kategorija']>0) {
$vi=mysqli_query($conn, "SELECT * FROM brend_kategorije WHERE kategorija=".$_POST['kategorija']);
while($vi1=mysqli_fetch_assoc($vi)){
$brend_kat[]=$vi1['brend'];
}
}
$brendovi='<option value="">Izaberite BREND</option>';

$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND  p.akt=1 AND p.id_cat=27 AND p.id IN (".implode(", ", $brend_kat).") ORDER BY -p.position DESC");
   while($tz1=mysqli_fetch_array($tz))
     {
if((isset($_POST['brend']) and $tz1['ide']==$_POST['brend']))
$che="selected"; else $che="";
$brendovi .="<option value='$tz1[ide]' $che>$tz1[naziv]</option>";
}


$filteri='';
$stavke_kat=array(0);
$vi=mysqli_query($conn, "SELECT * FROM stavke_kategorije WHERE kategorija=".$_POST['kategorija']);
while($vi1=mysqli_fetch_assoc($vi)){
$stavke_kat[]=$vi1['stavka'];
}

$nins=array();
$vi=mysqli_query($conn, "SELECT * FROM pro_filt WHERE id_pro=$_POST[idpro]");
while($vi1=mysqli_fetch_assoc($vi)){
$nins[$vi1['id_filt']]=$vi1['id_filt'];
}

$fis = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND  p.akt=1 AND p.id_cat IN (".implode(", ", $stavke_kat).") ORDER BY -p.position DESC");
$filteri .='<div class="row">';
$i=0;
while($fis1=mysqli_fetch_array($fis))
{
$filteri .='<div class="col-lg-3 col-md-6 col-12">';
$filteri .='<div class="filteri">';
$filteri .='<b>'.$fis1['naziv'].'</b><br>';
$filteri .='<input value="'.$fis1['ide'].'" type="hidden" name="glkat[]" />';
$dis = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=2 AND  p.akt=1 AND id_parent=$fis1[ide] ORDER BY -p.position DESC");
 $j=0;
 while($dis1=mysqli_fetch_array($dis))
 {
if($_POST['idpro']>0 and $nins[$dis1['ide']]>0)
$chekme="checked"; else $chekme="";
$filteri .='<input value="'.$dis1['ide'].'-'.$fis1['ide'].'" type="radio" name="filt'.$i.'" id="ime'.$i.$j.'" '.$chekme.'  /> <label for="ime'.$i.$j.'">'.$dis1['naziv'].'</label><br />';

  $j++;
  }
$i++;
$filteri .='</div>';
$filteri .='</div>';
}
$filteri .='</div>';
$filteri .="<input type='hidden' name='ife' value='$i' />";


$niv=array($brendovi,$filteri);
echo json_encode($niv);