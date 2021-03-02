<?php 
include("../Connections/conn_admin.php");
$g=mysqli_query($conn,"SELECT * FROM page WHERE id=".$_POST['idp']."");
$g1=mysqli_fetch_assoc($g);

$ga=mysqli_query($conn,"SELECT * FROM page_models WHERE id_model=".$g1['model']."");
$ga1=mysqli_fetch_assoc($ga);
$zani=explode(",",$ga1['include_file_middle']);
$nzani=array();
foreach($zani as $k => $v){
if(mb_eregi("tekst-",$v))
$nzani[]=$v;
}
if(count($nzani)>0){
foreach($nzani as $k => $v){
echo "<label><input type='radio' name='sekcija' value='$g1[model]-$v' style='position:relative;top:2px;'> $v</label> &nbsp; &nbsp; &nbsp;";
}
echo "<br><br>";
}

$ga=mysqli_query($conn,"SELECT * FROM page_models WHERE id_model=".$g1['model1']."");
$ga1=mysqli_fetch_assoc($ga);
$zanis=explode(",",$ga1['include_file_middle']);
$nzanis=array();
foreach($zanis as $k => $v){
if(mb_eregi("tekst-",$v))
$nzanis[]=$v;
}
if(count($nzanis)>0){
echo "<b>Kod detaljnog prikaza: </b>";
foreach($nzanis as $k => $v){
echo "<label><input type='radio' name='sekcija' value='$g1[model1]-$v' style='position:relative;top:2px;'> $v</label> &nbsp; &nbsp; &nbsp;";
}
echo "<br><br>";
}
if($_POST['idp']==2){
?>
<b>Kategorija (za prikaz teksta iznad liste proizvoda)</b><br><select name="kat"  class='selecte'>
<option value="0">-- Izaberite kategoriju --</option>
<?php 
$tz = mysqli_query($conn,"SELECT p.*, pt.*, p.id as id
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND p.id_cat=52 ORDER BY p.position ASC");

   while($tz1=mysqli_fetch_array($tz))
     {
?>

<option value="<?php echo $tz1['id']?>"><?php echo $tz1["naziv"]?></option>
<?php } ?>
</select><br><br>
<?php 
}
?>