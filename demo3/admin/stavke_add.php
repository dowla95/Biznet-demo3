<div class='detaljno_smestaj whites'>
<?php 
$zanas="Upis / izmena stavki";
$zanas1="UPISI NOVU STAVKU";
$zanas2="STAVKU";
?>
<div class='naslov_smestaj_padd'><h1 class="border_ha"><?php echo $zanas?></h1></div>
<b style='float:left;font-size:15px;text-transform:uppercase;display:block;background:#218FBF;padding:5px;'> <a href="#inline_content" class='inline'><span style='padding:6px 10px;font-size:15px;color:white;'><?php echo $zanas1?></span></a></b>
<br class='clear' />
<script> 
function delme(id)
{
var answer = confirm("Brišete ovu stavku?");
if(answer)
{
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id_cat=<?php echo $_GET['id_cat']?>&id="+id+"&obrisi_stavke=1";
}
}
    $(document).ready(function(){
    $(".ul").sortable({ 
      stop: function(){
        //qString = $(this).sortable("serialize");
  //alert(qString)
  var arr = new Array();
  $(".ul .pr").each(function() {
  arr.push($( this ).attr( "id" ));
});
var joins=arr.join(",");
//alert(joins.replace(/undefined-/g,""))
        $.ajax({
          type: "POST",
url: "<?php echo $patHA?>/save_positionS.php?table=stavke",
          data: {ide: joins, table: "stavke"},
          cache: false,
          beforeSend: function(html){
       $(".ul").css("opacity", "0.6");
      // $("#sorting .ul").append("load...");
          },
          success: function(html){
          $(".ul").css("opacity", "1.0")
          }
        });
      }
    });
 $(".ul1").sortable({ 
      stop: function(){
        //qString = $(this).sortable("serialize");
  //alert(qString)
  var arr = new Array();
  $(".ul1 .dr").each(function() {
  arr.push($( this ).attr( "id" ));
});
var joins=arr.join(",");
//alert(joins.replace(/undefined-/g,""))
       // $('#msg').fadeIn("slow");
        //$('#msg').html("Updating...");
        $.ajax({
          type: "POST",
url: "<?php echo $patHA?>/save_positionS.php?table=stavke",
          data: {ide: joins, table: "stavke"},
          cache: false,
          beforeSend: function(html){
       $(".ul").css("opacity", "0.6");
      // $("#sorting .ul").append("load...");
          },
          success: function(html){
          $(".ul").css("opacity", "1.0")
          }
        });
      }
    });
      $(".ul2").sortable({ 
      stop: function(){
        //qString = $(this).sortable("serialize");
  //alert(qString)
  var arr = new Array();
  $(".ul2 .tr").each(function() {
  arr.push($( this ).attr( "id" ));
});
var joins=arr.join(",");
//alert(joins.replace(/undefined-/g,""))
    
       // $('#msg').fadeIn("slow");
        //$('#msg').html("Updating...");
        $.ajax({
          type: "POST",
url: "<?php echo $patHA?>/save_positionS.php?table=stavke",
          data: {ide: joins, table: "stavke"},
          cache: false,
          beforeSend: function(html){
       $(".ul").css("opacity", "0.6");
      // $("#sorting .ul").append("load...");
          },
          success: function(html){
          $(".ul").css("opacity", "1.0")
          }
        });
      }
    }); 
  });   
</script>
<form method="post" action="" enctype="multipart/form-data">
<table style='width:100%'>
<tr valign='top'>
<td style='width:400px;background:#fff;padding:5px;border:2px solid #ccc;'>
<b style='color:#218FBF;font-size:15px;text-transform:uppercase;display:block;'>Izaberi <?php echo $zanas2?> za izmenu</b>
 <br />
<ul style='width:100%;' class='ul'> 
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND p.id_cat=$_GET[id_cat] ORDER BY p.position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
  if(!mysqli_query($conn, "UPDATE stavkel SET ulink='".replace_implode1($tz1["naziv"])."' WHERE id=$tz1[id]")) echo mysqli_error();    
  if($tz1['ide']==$_GET['id']) $sele="selected"; else $sele="";
?>
<!-- Ovo je prvi nivo -->
<li id='<?php echo $tz1['ide']?>' class='pr'>
<a href="<?php echo $patHA?>/index.php?base=admin&page=stavke_add&id=<?php echo $tz1['ide']?>&id_cat=<?php echo $_GET['id_cat']?>"><?php echo $tz1['naziv']." "?><?php if($admi1['master']==1) echo $tz1['ide']; else echo "";?></a> &nbsp; &nbsp;
<a class="olovcica" href="<?php echo $patHA?>/index.php?base=admin&page=stavke_add&id=<?php echo $tz1['ide']?>&id_cat=<?php echo $_GET['id_cat']?>"><i class="fas fa-pencil-alt"></i></a>&nbsp; &nbsp;
<a class="crvena" href="javascript:;" onclick="delme(<?php echo $tz1['ide'] ?>)" ><i class="fal fa-trash-alt"></i></a>&nbsp; &nbsp;
<?php if($_GET['id_cat']==27) { ?>
<a href='index.php?base=admin&page=dodeli_kategorije&id=<?php echo $tz1['ide']?>' target="_blank">dodeli kategorije</a>
<?php
}
if($modulArr['kategorije-hamburger']!=1) {
if($tz1['id_cat']==32){
if($tz1['mega_menu']==1) $che="checked"; else $che="";
?>
<input type='checkbox' value='1' <?php echo $che?> onclick="akti('<?php echo $tz1['ide']?>', 'mega')" /> MEGA MENU
<?php
}
}
$hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=2 AND id_parent=$tz1[ide]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");
        ?>
<ul class='ul1'> 
<?php 
   while($hz1=mysqli_fetch_array($hz))
     {
  if($hz1['ide']==$_GET['id']) $selet="selected"; else $selet="";
?> 
<!-- Ovo je drugi nivo --> 
<li id='<?php echo $hz1['ide']?>' class='dr'> 
<a href="<?php echo $patHA?>/index.php?base=admin&page=stavke_add&id=<?php echo $hz1['ide']?>&id_cat=<?php echo $_GET['id_cat']?>" <?php echo $selet?> style="color:red;"><?php echo $hz1["naziv"]." "?><?php if($admi1['master']==1) echo $hz1['ide']; else echo "";?>
&nbsp;&nbsp;<i class="fas fa-pencil-alt olovcica"></i></a>&nbsp; &nbsp;
<a class="crvena" href="javascript:;" onclick="delme(<?php echo $hz1['ide'] ?>)" ><i class="fal fa-trash-alt"></i></a>&nbsp; &nbsp;

<ul class='ul2'>
 <?php 
$ahz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=3 AND  id_parent=$hz1[ide]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");    
   while($ahz1=mysqli_fetch_array($ahz))
     {
  if($ahz1['ide']==$_GET['id']) $selete="selected"; else $selete="";
?>
<!-- Ovo je treci nivo -->
<li id='<?php echo $ahz1['ide']?>' class='tr'>                      
<a class="olovcica" href="<?php echo $patHA?>/index.php?base=admin&page=stavke_add&id=<?php echo $ahz1['ide']?>&id_cat=<?php echo $_GET['id_cat']?>" <?php echo $selete?>><?php echo $ahz1["naziv"]." "?><?php if($admi1['master']==1) echo $ahz1['ide']; else echo "";?>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i></a>&nbsp; &nbsp;
<a class="crvena" href="javascript:;" onclick="delme(<?php echo $ahz1['ide'] ?>)" ><i class="fal fa-trash-alt"></i></a>&nbsp; &nbsp;
</li>
<?php 
}
?>
</ul>
</li>
<?php                      
}
 ?>
 </ul>
  </li>
 <?php                      
}
?>
</ul>						                    
</td>
<td>                               
 <?php 
if($_GET['uspeh']==1)
$msr="Upisana je stranica. Unesite dodatne izmene za upisanu stranicu!";
if($msr!="")
echo "<div class='infos1'><div>$msr</div></div>";
if($_GET['id']>0)
{
$zz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.id=$id_get  AND p.id_cat=$_GET[id_cat]"); 
$zz1=mysqli_fetch_array($zz);
?>
<div class='ui-tabs-panel ipad'>
 <select style='width:100%;' name='id_parent' class='selecte'> 
 <option value=''>Izaberite parent kategoriju</option>
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND p.nivo=1 AND p.id_cat=$_GET[id_cat] ORDER BY p.position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
  if($tz1['ide']==$_POST['id_parent'] or $tz1['ide']==$zz1['id_parent']) $sele="selected"; else $sele="";
?>
<option value="<?php echo $tz1['ide']?>" <?php echo $sele?>><?php echo $tz1["naziv"]?></option>
<?php 
$hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND id_parent=$tz1[ide]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");
   while($hz1=mysqli_fetch_array($hz))
     {
  if($hz1['ide']==$_POST['id_parent'] or $hz1['ide']==$zz1['id_parent']) $selet="selected"; else $selet="";
?>
<option value="<?php echo $hz1['ide']?>" <?php echo $selet?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option>
<?php 
$ahz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$hz1[id] AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");                       
   while($ahz1=mysqli_fetch_array($ahz))
     {
$mn2=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM stavkes_text WHERE id_page=$ahz1[ide] AND id_cat=$_GET[id_cat]"));          
if($ahz1['ide']==$_POST['id_parent'] or $ahz1['ide']==$zz1['id_parent']) $selete="selected"; else $selete="";
?>
<option value="<?php echo $ahz1['ide']?>" <?php echo $selete?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ahz1["naziv"]?></option>
 <?php 
}
}
}
?>
</select>		
</div>  
<br />
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
$n=0;
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 $zz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$la1[jezik]' AND  p.id=$id_get  AND p.id_cat=$_GET[id_cat]"); 
$zz1=mysqli_fetch_array($zz);
 ?>
<div id="tabs-<?php echo $la1['id']?>" class="ui-tabs-panel">
 
<table style='width:100%' cellspacing='0' cellpadding='0'>
  <?php 
if($n>0) $stp=" style='padding-left:5px;'"; else $stp="";
$jez=$la1['jezik'];
$naziv="naziv$jez";
$nazivi=$zz1['naziv'];
$ulink="ulink$jez";
$ulinki=$zz1['ulink'];
$title="title$jez";
$titlei=$zz1['title'];
$keywords="keywords$jez";
$keywordsi=$zz1['keywords'];
$descriptions="descriptions$jez";
$descriptionsi=$zz1['descriptions'];
$alt="alt$jez";
$alti=$zz1['alt'];
$titlesl="titlesl$jez";
$titlesli=$zz1['titlesl'];
 ?>
 <tr>
 <td>
Naziv<br>
<input type="text" value="<?php echo htmlspecialchars($nazivi, ENT_QUOTES, "UTF-8");?>" name='<?php echo $naziv?>' class='selecte' />
 </td>
 </tr>
<?php 
$strt=1; 
if($strt==1)
{
?> 
 <tr>
 <td>
U link<br>
<input type="text" value="<?php echo $ulinki?>" name='<?php echo $ulink?>' class='selecte' placeholder="Unosi se samo za stavke koje predstavljaju cele stranice" /> 
 </td>
 </tr>
 <td>
Kratak opis stavke<br>
<input type="text" value="<?php echo $keywordsi?>" name='<?php echo $keywords?>' class='selecte' placeholder="Prikazuje se ispod liste proizvoda u kategoriji" /> 
 </td>
 </tr>
 <tr>
 <td>
Title<br>
<input type="text" value="<?php echo $titlei?>" name='<?php echo $title?>' class='selecte' placeholder="Unosi se samo za stavke koje predstavljaju cele stranice" /> 
 </td>
 </tr>
 <tr>
 <tr>
 <td>
Description<br>
<input type="text" value="<?php echo $descriptionsi?>" name='<?php echo $descriptions?>' class='selecte' placeholder="Unosi se samo za stavke koje predstavljaju cele stranice" /> 
 </td>
 </tr>
<?php 
}
?> 
 <tr>
 <td>
Alt slike<br />
<input type="text" value="<?php echo $alti?>" name='<?php echo $alt?>' class='selecte' /> 
 </td>
 </tr>
 <tr>
 <td>
Title slike<br />
<input type="text" value="<?php echo $titlesli?>" name='<?php echo $titlesl?>' class='selecte' /> 
 </td>
 </tr>
 </table>
	</div>
	<?php $n++; } ?>
</div>  
 <br class='clear'><br>
<?php 
$brnivo=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM stavke WHERE id_parent=$id_get"));
?>
<div class='ui-tabs-panel ipad'> 
  <table style='width:100%' class='forma-lista' cellspacing='0' cellpadding='0'>
<!--
   <tr>
<td style='padding-left:5px;'>
ID Kupindove kategorije<br>
<input type="text" value="<?php echo $zz1['id_cat_kupindo']?>" name='id_cat_kupindo' class='selecte' />
 </td>
 <td style='padding-left:15px;'>

 </td>
 </tr>
-->
 <tr>
<td style='padding-left:5px;' class="d-none">
Stavka u detaljnom prikazu proizvoda: 
<br>
<?php 
if($zz1['akt']==0) $akti="selected"; else $akti="";
if($zz1['akt']==1) $akti1="selected"; else $akti1="";
?>
<select name='akti' class='selecte'>
<option value='0' <?php echo $akti?>>NE</option>
<option value='1' <?php echo $akti1?>>DA</option>
</select>
</td>
<td style='padding-left:15px;'>
Slika / Ikonica: 
<br> 
<input type="file" class="file_input_div1"  id="avatar" name='slika' style='width:180px;' />
</td>
<td>
<?php 
if($zz1['slika']!="" and is_file("..".GALFOLDER."/thumb/$zz1[slika]"))
{
echo "<img src='..".GALFOLDER."/thumb/$zz1[slika]' style='max-width:100px;' />";
echo "<input type='hidden' name='stara_slika' value='$zz1[slika]' />";
echo "<br /><input type='checkbox' name='brisi' value='1' /> obrisi sliku";
?>
</td>
<?php } ?>
</tr>
<tr>
<td colspan="3">
<?php
if($zz1['id_cat']==27) $dimsl="Neophodno je da sve slike LOGO-a proizvođača budu isti veličine. Preporučena veličina je 320x100px.";
elseif($zz1['id_cat']==32) $dimsl="Neophodno je da slike kategorija proizvoda budu isti veličine. Preporučena veličina je 60x60px. Ove sličice se prikazuju samo kada je u upotrebi MEGA MENU.";
echo $dimsl;
?>
</td>
</tr>

</table>
</div>
<div style="float:right;padding-top:15px;">
<input type='submit' name='izmene_stavke' class="submit_dugmici_blue" value='Izmeni stavku'> 
</div>
<?php 
}
?>
</form>
 </td>
 </tr>
 </table>
<br>
 <div style='display:none'>
	<div id='inline_content' style='padding:10px; background:#fff;'> 
      <form method="post" action="">
 <br>
 <div class='ui-tabs-panel ipad'>
 <select style='width:100%;' name='id_parent' class='selecte'> 
 <option value=''>Izaberite parent kategoriju</option>
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND p.id_cat=$_GET[id_cat] ORDER BY p.position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
  if($tz1['ide']==$_POST['id_parent']) $sele="selected"; else $sele="";
 ?>
<option value="<?php echo $tz1['ide']?>" <?php echo $sele?>><?php echo $tz1["naziv"]?></option>
<?php 
$hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$tz1[ide]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");
   while($hz1=mysqli_fetch_array($hz))
     {
  if($hz1['ide']==$_POST['id_parent']) $selet="selected"; else $selet="";
?>
<option style="color:red" value="<?php echo $hz1['ide']?>" <?php echo $selet?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option>
<?php 
$ahz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$hz1[id]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");                       
   while($ahz1=mysqli_fetch_array($ahz))
     {
//$mn2=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM stavkes_text WHERE id_page=$ahz1[ide] AND id_cat=$_GET[id_cat]"));          
if($ahz1['ide']==$_POST['id_parent']) $selete="selected"; else $selete="";
?>
<!--
<option style="color:red" value="<?php echo $ahz1['ide']?>" <?php echo $selete?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ahz1["naziv"]?></option>
-->
<?php 
}
}
}
?>
</select>		
</div>  
<br />
 <div class="ui-tabs">
	<ul class="ui-tabs-nav">
<?php 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<li><a href="#tabsa-<?php echo $la1['id']?>"><?php echo $la1['jezik']?></a></li>
<?php } ?>
	</ul>
  <?php 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<div id="tabsa-<?php echo $la1['id']?>" class="ui-tabs-panel">
 <table style='width:100%' cellspacing='0' cellpadding='0'>
 <tr>
 <td>
Naziv<br>
 <?php 
 $jez=$la1['jezik'];
 ?>
 <input type="text" name='naziv<?php echo $jez?>' class='selecte' style='' />
 </td>
 </tr>
 </table>
 </div>
<?php } ?>
</div><br>
<input type='submit' name='save_stavke' class="submit_dugmici_blue" value='Dodaj novu stavku'>
 </form>
</div>
 </div>
</div> 