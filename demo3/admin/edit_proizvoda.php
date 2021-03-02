<?php 
include("tiny_mce.php");
$zz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text        
        WHERE pt.lang='$firstlang' AND  p.id=$id_get"); 
$zz1=mysqli_fetch_array($zz);
$nins=array();
$vi=mysqli_query($conn, "SELECT * FROM pro_filt WHERE id_pro=$id_get");
while($vi1=mysqli_fetch_assoc($vi)){
$nins[$vi1['id_filt']]=$vi1['id_filt'];
}
$nin=array();
$vi=mysqli_query($conn, "SELECT * FROM pro_slicni WHERE id_pro=$id_get");
while($vi1=mysqli_fetch_assoc($vi)){
$nin[$vi1['id_pro1']]=$vi1['id_pro1'];
}
$nina=array();
$via=mysqli_query($conn, "SELECT * FROM pro_kupili WHERE id_pro=$id_get");
while($via1=mysqli_fetch_assoc($via)){
$nina[$via1['id_pro1']]=$via1['id_pro1'];
}
$sin=array();
$vi=mysqli_query($conn, "SELECT * FROM kat_pro WHERE pro=$id_get");
while($vi1=mysqli_fetch_assoc($vi)){
$sin[]=$vi1['kat'];
}
if(isset($_POST['kategorija']))
$sin=array($_POST['kategorija']);
//echo $sin[0]."AAAAAAA".$sin[1]."BBBBB".$sin[2];
?>

<div class="row">
<div class="col-12 col-lg-6 col-md-12">
<h1>Izmena proizvoda</h1>
</div>
<div class="col-12 col-lg-3 col-md-6 mb-10">
<a class="submit_dugmici_blue float-right" href="<?php echo $patHA?>/index.php?base=admin&page=add_proizvoda&tip=<?php echo $_GET['tip']?>">UPIŠI NOV PROIZVOD</a>
</div>
<div class="col-12 col-lg-3 col-md-6 mb-10">
<a class="submit_dugmici_blue float-right" href="<?php echo $patHA?>/index.php?base=admin&page=proizvodi&tip=<?php echo $_GET['tip']?>">UPISANI PROIZVODI</a>
</div>
</div>

<div class='trakica_pozadina'></div>
<div class="row mb-20">
<div class="col-12 accordion">
<div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse">
<a class="card-title">Edit ostalih proizvoda</a>
</div>
<div id="collapse" class="card-body collapse">
<div class="kolone">
<ul class='ul'>
<?php 
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text        
        WHERE pt.lang='$firstlang' AND  p.tip=$_GET[tip] ORDER BY p.id DESC, pt.naslov ASC"); 
while($az1=mysqli_fetch_array($az))
{
?>
<li id='<?php echo $az1['ide']?>' class='pr'>                    
<a class="olvcica" href="<?php echo $patHA?>/index.php?base=admin&page=edit_proizvoda&id=<?php echo $az1['ide']?>&tip=<?php echo $_GET['tip']?>"><?php echo $az1["ide"].". ".$az1["naslov"]?> &nbsp; &nbsp;<i class="fas fa-pencil-alt"></i></a>
</li>
<?php 
}
?>
</ul>
</div>
</div>
</div>
</div>
<?php 
if($msr!="")
echo "<div class='infos1'><div>$msr</div></div>";
?> 
<form method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="idpro" value="<?php echo $id_get?>">
<?php 
if($_GET['tip']==5)
{
?>
<div class="row">
<div class="col-12 col-md-6">
<b>Kategorija  <span style='color:red;'>*</span></b>
<div style="height:290px;overflow:auto;border:1px solid #111;background:#fff;-webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;padding:5px;">
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND  p.akt=1 AND p.id_cat=32 ORDER BY -p.position DESC");
   while($tz1=mysqli_fetch_array($tz))
     {
     $hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=2 AND  p.akt=1 AND  id_parent=$tz1[ide]  ORDER BY -p.position DESC");
$sums=mysqli_num_rows($hz);
if($sums>0) {
echo "<div class='card-header collapsed cha1' data-toggle='collapse' data-parent='#accordion' href='#collaps".$tz1['ide']."'>";
echo "<a class='card-title'><b>".$tz1['naziv']."</b></a>";
echo "</div>";
echo "<div id='collaps".$tz1['ide']."' class='card-body collapse cba'>";
   while($hz1=mysqli_fetch_array($hz))
     {
  $fz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=3 AND  p.akt=1 AND  id_parent=$hz1[ide]  ORDER BY -p.position DESC");
$fums=mysqli_num_rows($fz);
if($fums>0) {
echo "<div class='card-header collapsed cha' data-toggle='collapse' data-parent='#accordion' href='#collaps".$hz1['ide']."'>";
echo "<a class='card-title'><b>".$hz1['naziv']."</b></a>";
echo "</div>";
echo "<div id='collaps".$hz1['ide']."' class='card-body collapse cba'>";
while($fz1=mysqli_fetch_array($fz))
     {
if(in_array($fz1['ide'],$sin)) {
$chef="checked";
$list2=$tz1['naziv']." <i class='fal fa-arrow-right'></i> ".$hz1['naziv']." <i class='fal fa-arrow-right'></i> ".$fz1['naziv'];
}
else $chef="" and $list2="";
echo "<label style='display:block;width:100%;padding:0px;margin:0px;padding-left:50px;'><input type='radio' name='kategorija' value='$fz1[ide]' $chef style='position:relative;top:2px;'> $fz1[naziv]</label>";
}
echo "</div>";
} else {
if(in_array($hz1['ide'],$sin)) {
$che="checked";
$list2=$tz1['naziv']." <i class='fal fa-arrow-right'></i> ".$hz1['naziv'];
}
else $che="" and $list2="";
echo "<label class='cha'><input type='radio' name='kategorija' value='$hz1[ide]' $che style='position:relative;top:2px;'> $hz1[naziv]</label>";
}
}
echo "</div>";
} else {
if(in_array($tz1['ide'],$sin)) {
$chet="checked";
$list2=$tz1['naziv'];
}
else $chet="" and $list2="";
echo "<label class='cha1'><input type='radio' name='kategorija' value='$tz1[ide]' $chet style='position:relative;top:2px;'><b> $tz1[naziv]</b></label>";
}
}
?>
<?php 
} else $zvez="<span style='color:red;'>*</span>";
?>
</div>
<?php echo "Trenutno: <b class='crvena'>".$list2."</b>";?>
</div>
<div class="col-12 col-md-6">
<div class="row">
<div class="col-12">
<b>Brendovi  <?php echo $zvez?></b>
<select name="brendovi" class='selecte staviovde'>
<option value="">Izaberite BREND</option>                  
<?php 
if($_GET['tip']==4) $brnd=27; elseif($_GET['tip']==5) $brnd=27; else $brnd=54;
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND  p.akt=1 AND p.id_cat=$brnd ORDER BY -p.position DESC");
   while($tz1=mysqli_fetch_array($tz))
     {
if((isset($_POST['brendovi']) and $tz1['ide']==$_POST['brendovi']) or $tz1['ide']==$zz1['brend']) 
$che="selected"; else $che="";     
echo "<option value='$tz1[ide]' $che>$tz1[naziv]</option>";
}
?>
</select>
</div>

<div class="col-lg-3 col-6 mt-10">
<div class='ui-tabs-panel'>
<label>Cena <span style='color:red;'>*</span></label><br />
<input type="text" name='cena' class='selecte' value="<?php echo $zz1["cena"]?>"  min="0" />
</div>
</div>
<div class="col-lg-3 col-6 mt-10">
<div class='ui-tabs-panel'>
<label>Cena pre akcije</label><br />
<input type="text" name='cena1' class='selecte' value="<?php echo $zz1["cena1"]?>"  min="0" />
</div>
</div>

<div class="col-lg-3 col-6 mt-10">
<div class='ui-tabs-panel'>
<label>EAN KOD</label><br /> 
<input type="number" name='link' class='selecte' value="<?php echo $zz1["link"]?>"  min="0" />
</div>
</div>

<div class="col-lg-3 col-6 mt-10">
<div class='ui-tabs-panel'>
<label>Pozicija</label><br />
<?php if($zz1["pozicija"]==100000) $zz2=""; else $zz2=$zz1['pozicija'];?>
<input type="number" name='pozicija' class='selecte' value="<?php echo $zz2?>"  min="0" />
</div>
</div>

<?php if($modulArr['kupili-su']==1) { ?>
<div class="col-xl-6 col-12 mt-10">
<b>Drugi su kupili:</b><br>
<select name="pro1[]" class='selecte mselect' style="width:96%" multiple="multiple">
<?php 
$kup = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text        
        WHERE pt.lang='$firstlang' AND   p.akt=1 AND p.tip=5  AND NOT p.id=$id_get ORDER BY pt.naslov ASC");
   while($kup1=mysqli_fetch_array($kup))
     {
if((isset($_POST['pro1']) and in_array($kup1['ide'],$_POST['pro1'])) or $nina[$kup1['ide']]>0)
$che="selected"; else $che="";    
echo "<option value='$kup1[ide]' $che>$kup1[naslov]</option>";
}
?>
</select>             
</div>

<?php
}
if($modulArr['mozda-ce-vas-zanimati']==1) {
if($_GET['tip']!=6){
?>
<div class="col-xl-6 col-12 mt-10">
<b>Predlažemo da obavezno pogledajte:</b><br />
<select name="oprema[]" class='selecte mselect' style="width:95.5%" multiple="multiple">                  
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text        
        WHERE pt.lang='$firstlang' AND  p.akt=1 AND  p.tip=5  AND NOT p.id=$id_get  ORDER BY pt.naslov ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
if((isset($_POST['oprema']) and in_array($tz1['ide'],$_POST['oprema'])) or $nin[$tz1['ide']]>0)
$che="selected"; else $che="";     
echo "<option value='$tz1[ide]' $che>$tz1[naslov]</option>";
}
?>
</select>
</div>
<?php } } ?>

<div class="col-6 mt-10">
<div class='ui-tabs-panel'>
<label>Canonical url</label><br />
<input type="text" name='canurl' class='selecte' value="<?php echo $zz1["canurl"]?>" />
</div>
</div>


<div class="col-6 mt-10">
<div class='ui-tabs-panel'>
<label>Povezivanje proizvoda</label><br />
<input type="text" name='kupid' class='selecte' value="<?php echo $zz1["kupindo"]?>" />
</div>
</div>




</div>
</div>
</div>
<?php 
$hid=2; 
if($hid==1)
{
?>            
<b>Posebna ponuda / Prikazi</b>
 <br />
<select name="filteri[]" class='selecte mselect'  style='width:46%;' multiple="multiple">                  
<?php 
if($_GET['tip']==4)
$pidi="p.id_cat=29 or p.id_cat=31";
else
$pidi="p.id_cat=29 or p.id_cat=33";                
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND  p.akt=1 AND ($pidi) ORDER BY -p.position DESC");
   while($tz1=mysqli_fetch_array($tz))
     {
echo "<optgroup label='$tz1[naziv]'>";     
    $hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=2 AND  p.akt=1 AND  id_parent=$tz1[ide]  ORDER BY -p.position DESC");
   while($hz1=mysqli_fetch_array($hz))
     { 
if((isset($_POST['filteri']) and in_array($hz1['ide'],$_POST['filteri'])) or $nins[$hz1['ide']]>0)
$che="selected"; else $che="";     
echo "<option value='$hz1[ide]' $che>$hz1[naziv]</option>";
}
echo "</optgroup>";
}
?>
</select>             
<br /><br />
<?php 
}
if($_GET['tip']==4)
{
?>
<b>Karakteristike</b>
 <br />
<select name="filteri[]" class='selecte mselect' style="width:46%" multiple="multiple">                  
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page       
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND akt=1  AND p.id_cat=30  ORDER BY -p.position DESC");
   while($tz1=mysqli_fetch_array($tz))
     {
if((isset($_POST['filteri']) and in_array($tz1['ide'],$_POST['filteri'])) or $nins[$tz1['ide']]>0)
$che="selected"; else $che="";     
echo "<option value='$tz1[ide]' $che>$tz1[naziv]</option>";
}
?>
</select>             
<br /><br />
<?php 
} elseif($_GET['tip']==6) { ?>
<b>Karakteristike televizora</b>
 <br />
<select name="filteri[]" class='selecte mselect' style="width:46%" multiple="multiple">                  
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page       
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND akt=1  AND p.id_cat=55  ORDER BY -p.position DESC");
   while($tz1=mysqli_fetch_array($tz))
     {
if((isset($_POST['filteri']) and in_array($tz1['ide'],$_POST['filteri'])) or $nins[$tz1['id_filt']]>0)
$che="selected"; else $che="";     
echo "<option value='$tz1[ide]' $che>$tz1[naziv]</option>";
}
?>
</select>             
<br /><br />
<?php } ?>

<?php 
$lager=$lager1=$akti=$akci=$novic=$vegani=$tip_1=$tip_2=$tip_3=$tip_4=$iuk=$spdo=$mpr=$mpr1=$akcobicna="";
if($zz1['lager']==0) $lager1="checked";
if($zz1['lager']==1) $lager="checked";

if($zz1['mesto_prikaza']==0) $mpr1="checked";
if($zz1['mesto_prikaza']==1) $mpr="checked";

if($zz1['akt']==1) $akti="checked";
if($zz1['akcija']==1) $akci="checked";
if($zz1['akcija_obicna']==1) $akcobicna="checked";
if($zz1['novo']==1) $novic="checked";
if($zz1['naslovna']==1) $nazdi="checked";
if($zz1['izdvojeni']==1) $izdi="checked";
if($zz1['vegan']==1) $vegani="checked";
if($zz1['tip_1']==1) $tipus_1="checked";
if($zz1['tip_2']==1) $tipus_2="checked";
if($zz1['tip_3']==1) $tipus_3="checked";
if($zz1['tip_4']==1) $tipus_4="checked";
if($zz1['izdvoj_u_kategoriji']==1) $iuk="checked";
?>
<div class='ui-tabs-panel ipad d-none'>
Nijanse - ponisti izbor <input type="radio" name="nijansa" value="0" style="position:relative;top:2px;">
<div class="row">
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND p.id_cat=30 ORDER BY p.id");
   while($tz1=mysqli_fetch_array($tz))
     {
echo "<div class='col-1 mb-10'>";
echo "<div class='nijans'>";
if($tz1['slika']!="" and is_file("..".GALFOLDER."/thumb/$tz1[slika]"))
echo "<img class='mb-10' src='..".GALFOLDER."/thumb/$tz1[slika]' /><br>";
if($zz1["nijansa"]==$tz1['ide']) $hih="checked"; else $hih="";
echo "<input type='radio' name='nijansa' value='$tz1[ide]' $hih />";
echo "<label for='".$tz1['naziv']."'>".$tz1['naziv']."</label>
</div>
</div>";
}
?>
</div>
</div>
<br>
<div class='ui-tabs-panel ipad'>
<label><b>Lager:  &nbsp; &nbsp;DA</b> <input type="radio" value='1' name='lager' <?php echo $lager?> /></label>&nbsp;  &nbsp; &nbsp;<label><b>NE</b> <input type="radio" value='0' name='lager'  <?php echo $lager1?> /></label>&nbsp; &nbsp;<label><b>Aktivan / neaktivan:</b> <input type="checkbox" value='1' name='akt' <?php echo $akti?> /></label>
&nbsp; &nbsp;<label><b>1. <?php echo $arrwords['karakteristika6']?></b> <input type="checkbox" value='1' name='akcija' <?php echo $akci?> /></label>
&nbsp; &nbsp;<label><b>2. <?php echo $arrwords['karakteristika1']?></b> <input type="checkbox" value='1' name='akcijaobicna' <?php echo $akcobicna?> /></label>
&nbsp; &nbsp;<label><b>3. <?php echo $arrwords['karakteristika2']?></b> <input type="checkbox" value='1' name='novo' <?php echo $novic?> /></label>
&nbsp; &nbsp;<label><b>4. <?php echo $arrwords['karakteristika3']?></b> <input type="checkbox" value='1' name='izdvojeni' <?php echo $izdi?> /></label>
&nbsp; &nbsp;<label><b>5. <?php echo $arrwords['karakteristika4']?></b> <input type="checkbox" value='1' name='naslovna' <?php echo $nazdi?> /></label>
&nbsp; &nbsp;<label><b>6. <?php echo $arrwords['karakteristika5']?></b> <input type="checkbox" value='1' name='vegan' <?php echo $vegani?> /></label>
<br /><br />

<label><b>1a. Akcija traje do: &nbsp; &nbsp;</b>
<input type="text" value='<?php echo $zz1['akcijatraje']?>' name='akcijatraje' id="datepicker" />
</label>
</div>

<br /><br />

Prikaži proizvod u sledećim izgledima:
<br />
<div class='ui-tabs-panel ipad'>
&nbsp; &nbsp;<label><b>Tip-1:</b> <input type="checkbox" value='1' name='tip1' <?php echo $tipus_1?> /></label>
&nbsp; &nbsp;<label><b>Tip-2:</b> <input type="checkbox" value='1' name='tip2' <?php echo $tipus_2?> /></label>
&nbsp; &nbsp;<label><b>Tip-3:</b> <input type="checkbox" value='1' name='tip3' <?php echo $tipus_3?> /></label>
&nbsp; &nbsp;<label><b>Tip-4:</b> <input type="checkbox" value='1' name='tip4' <?php echo $tipus_4?> /></label>
<?php

if($modulArr['sponzorisano']==1) { ?>
<label class="ml-20"><b><?php echo $arrwords['sponzorisano']?></b> <input type="checkbox" value='1' name='iukat' <?php echo $iuk?> id="moze" /></label>

<label class="ml-10"><b>do &nbsp;</b>
<input type="text" value='<?php echo $zz1['sponzorisano_do']?>' name='sponzorisanodo' id="datepicker1" />
</label>

<label class="ml-20"><b>Mesto prikaza sponzorisanog proizvoda:  &nbsp; &nbsp;Top</b> <input type="radio" value='1' name='mprikaza' <?php echo $mpr?> /></label>
&nbsp;  &nbsp; &nbsp;<label><b>Left</b> <input type="radio" value='0' name='mprikaza' <?php echo $mpr1?> /></label>

<?php } ?>

</div>


<script>
$(document).ready(function() {
   $('#datepicker1').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  } );
document.getElementById('moze').onchange = function() {
    document.getElementById('datepicker1').disabled = !this.checked;
};
  </script>

<br /><br />
<div id="cats">
<?php 
if(isset($_POST['id_page']) and $hide_cats==1)
{
$nizi=$_POST['id_page'];
$fsi=mysqli_query($conn, "SELECT * FROM  categories_group WHERE akt=1 AND tip=$_GET[tip] AND id IN (SELECT id_kat FROM pages_kat WHERE id_page=$nizi) ORDER BY name ASC");
while($fsi1=mysqli_fetch_assoc($fsi))
{  
$tz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  nivo=1  AND id_cat=$fsi1[id] ORDER BY -p.position DESC");
if(mysqli_num_rows($tz)>0)
{        
?> 
<span>Dodeli upis - <?php echo $fsi1['name']?></span>
<?php 
if($fsi1['multi']==1) 
{
$imulti_class=" selectG1";
$imulti='multiple="multiple"';
$prazno="";
}else
{
$imulti_class="";
$imulti='';
$prazno="<option value=''>---</option>";
}
?> 
<select name="kat[]" class='selecte<?php echo $imulti_class?>' <?php echo $imulti?>>
<?php 
echo $prazno;
$tz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  nivo=1  AND id_cat=$fsi1[id] ORDER BY -p.position DESC");
   while($tz1=mysqli_fetch_array($tz))
     {
$hz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$tz1[id_page]   ORDER BY -p.position DESC"); 
if(mysqli_num_rows($hz)>0) $dis1="disabled"; else $dis1=""; 
if(isset($_POST['kat']) and in_array($tz1['id_page'],$_POST['kat'])) $sel="selected"; else $sel="";     
?>
<option  value="<?php echo $tz1['id_page']?>" <?php echo $dis1?> <?php echo $sel?>><?php echo $tz1["naziv"]?></option>
<?php 
   while($hz1=mysqli_fetch_array($hz))
     {
$rz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$hz1[id_page]  ORDER BY -p.position DESC");
if(mysqli_num_rows($rz)>0) $dis2="disabled"; else $dis2="";
if(isset($_POST['kat']) and in_array($hz1['id_page'],$_POST['kat'])) $sel="selected"; else $sel="";
?>
<option value="<?php echo $hz1['id_page']?>" <?php echo $dis2?> <?php echo $sel?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option>
<?php 
   while($pz1=mysqli_fetch_array($pz))
     {
if(isset($_POST['kat']) and in_array($pz1['id_page'],$_POST['kat'])) $sel="selected"; else $sel="";     
?>
<option value="<?php echo $pz1['id_page']?>" <?php echo $sel?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pz1["naziv"]?></option>
<?php 
} 
}
}
 ?>
</select>    
<br /><br />
<?php 
}
}
}
?>
</div>
<div class="ui-tabs">
<ul class="ui-tabs-nav">
<?php 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<li><a href="#tabs-<?php echo $la1['id']?>"><?php echo $la1['jezik']?></a></li>
<?php } ?>
</ul>
  <?php 
$naslov=$ulink=$opis1=$opis=$title=$keywords=$description=$esno1=$esno2=$esno3=$esno4=$pozicija=$titleslike=$altslike="";  
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 $jez=$la1['jezik'];
 $naslov=$zz1["naslov"];
 $marka=$zz1["marka"];  
 $opis=$zz1["opis"];
 $title=$zz1["title"];
 $keywords=$zz1["keywords"];
 $description=$zz1["description"];
 $titleslike=$zz1["titleslike"];
 $altslike=$zz1["altslike"];
 ?>
<div id="tabs-<?php echo $la1['id']?>" class="ui-tabs-panel">
<div class="row">
<div class="col-12 col-md-6">
U naslovu <span style='color:red;'>*</span><br />
 <input type="text" name='naslov<?php echo $jez?>' value="<?php echo $naslov?>" class='selecte' required />
</div>
<div class="col-12 col-md-6">
Marka - tip<br />
<input type="text" name='marka<?php echo $jez?>' value="<?php echo $marka?>" class='selecte' style='' />
</div>
</div>

<div class="row mt-10">
<div class="col-12">
<label>Opis</label><br />
<textarea id="editor<?php echo $jez?>" name="opis<?php echo $jez?>"><?php echo $opis?></textarea>
</div>
</div>

<div class="row mt-10">
<div class="col-12 col-md-6">
<label>Title strane:</label><br />
<input type="text" name='title<?php echo $jez?>' value="<?php echo $title?>" class='selecte zeleno' />
</div>

<div class="col-12 col-md-6">
<label>YouTube ili Vimeo video</label><br />
<input type="text" name='keywords<?php echo $jez?>' value='<?php echo $keywords?>' class='selecte zeleno' />
</div>

<div class="col-12 col-md-6">
<label>Description strane:</label><br />
<input type="text" name='description<?php echo $jez?>' value="<?php echo $description?>" class='selecte zeleno' />
</div>

<div class="col-12 col-md-6">
<label>Alt slike:</label><br />
<input type="text" name='altslike<?php echo $jez?>' value="<?php echo $altslike?>" class='selecte zeleno' />
</div>

<div class="col-12 col-md-6">
<label>Title slike:</label><br />
<input type="text" name='titleslike<?php echo $jez?>' value="<?php echo $titleslike?>" class='selecte zeleno' />
</div>
</div>
</div>
<?php } ?>
</div>

<div class="row mt-10 mb-10">
<div class="col-12 col-md-6">
<div class='ui-tabs-panel ipad'>
<label>Slika proizvoda:</label><br /> 
<input type="file" class="file_input_div1"  id="avatar" name='slika' /> 
<?php 
if(is_file("..".GALFOLDER."/".$zz1['slika']))
{
echo "<div style='float:right;'><img src='$patH".GALFOLDER."/$zz1[slika]'   style='width:80px;height:60px;border:1px solid #f1f1f1;padding:2px;' />";
echo  "<input type='hidden' value='$zz1[slika]' name='stara_slika' />";
echo  "<br /><input type='checkbox' value='1' name='brisi' /> Oznaci za brisanje</div>";
 }
 ?>
</div>
</div>


<div class="col-12 col-md-6">
<div class='ui-tabs-panel ipad'>
<label>Druga slika proizvoda:</label><br /> 
<input type="file" class="file_input_div1"  id="avatar" name='slika1' /> 
<?php 
if(is_file("..".GALFOLDER."/".$zz1['slika1']))
{
echo "<div style='float:right;'><img src='$patH".GALFOLDER."/$zz1[slika1]' style='width:80px;height:60px;border:1px solid #f1f1f1;padding:2px;' />";
echo  "<input type='hidden' value='$zz1[slika1]' name='stara_slika1' />";
echo  "<br /><input type='checkbox' value='1' name='brisi1' /> Oznaci za brisanje</div>";
 }
 ?>
</div>
</div>
</div>

<div class="row">
<div class="col-12 col-md-6">
<div class='ui-tabs-panel ipad'>
<label>Video (dozvoljeni formati: mp4, ogg, i webm)</label><br />
<input type="file" class="file_input_div1" name='video'  />
 <?php 
 if(is_file("../video-fajlovi/".$zz1['video']))
 {
 echo "<div style='float:right;'><a href='$patH/video-fajlovi/$zz1[video]'>$zz1[video]</a>";
 echo  "<input type='hidden' value='$zz1[video]' name='stari_video' />";
echo  "<br /><input type='checkbox' value='1' name='brisi_video' /> Oznaci za brisanje</div>";
 }
 ?>
</div>
</div>
</div>

<div class="row mt-20 mb-20">
<div class="col-12 accordion">
<div class="card-header collapsed" data-toggle="collapse" data-parent="#filter" href="#filter">
<b>Filter stavke</b>
</div>
<div id="filter" class="card-body collapse"></div>
</div>
</div>

<div class="row mt-20 mb-20">
<div class="col-12 accordion">
<div class="card-header collapsed" data-toggle="collapse" data-parent="#galerija" href="#galerija">
<b>Galerija slika</b>
</div>
</div>
</div>

<input type='submit' name='save_change_pro' id="changePro" class="submit_dugmici_blue mb-30" value='Sačuvaj izmene'>
<br />
</form>
<div id="galerija" class="card-body collapse">
<?php include('subslike-galerija.php');?>
</div>