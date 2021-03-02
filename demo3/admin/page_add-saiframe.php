<div class='row'>
<?php 
if(!isset($_GET['id_cat']))
$_GET['id_cat']=0;

if($_GET['id_cat']==0)
{
$zanas="Upis novih stranica/podstranica";
$zanas1="UPISI NOVU STRANICU";
$zanas2="STRANICU";
$zanas3="STRANICA";
}
else
{
$zanas="Upis novih kategorija/podkategorija";
$zanas1="UPISI NOVU KATEGORIJU";
$zanas2="KATEGORIJU";
$zanas3="KATEGORIJA";
}
?>
<div class='naslov_smestaj_padd col-12'>
<h1 class="border_ha"><?php echo $zanas?></h1>
</div>
<div class='col-12 mb-10'>
<b style='float:left;font-size:15px;text-transform:uppercase;display:block;background:#218FBF;padding:5px;'> <a href="#inline_content" class='inline'><span style='padding:6px 10px;font-size:15px;color:white;'><?php echo $zanas1?></span></a></b>
</div>
</div>

<script> 
function gog(id)
{
if(id>0)
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id="+id;
else
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>";
}
function delme(id)
{
var answer = confirm("Brišete ovu stranicu, sve podstranice, sve tekstove, slike i fajlove u vezi sa njom?");
if(answer)
{
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id="+id+"&obrisi_stranice=1&id_cat=<?php echo $id_cat_get?>";
}
}
    $(document).ready(function(){
    $(".ul").sortable({ 
      stop: function(){
        qString = $(this).sortable("serialize");
      }
    });
        //$(".ul").disableSelection();
$('.rem').live('click', function() {
 
  $( this ).parent().remove();
});    

$('.pode').on('change', function() {
  if(this.value>0)
  $(".zahide").fadeOut('slow');
  else
  $(".zahide").fadeIn("slow");
});
  });   
  
function doda(id, tip)
{
//var le=$("#polje"+id+" .tex" ).length;
$("#polje"+id ).prepend("<li class='tex' style='margin-bottom:1px;'><input type='checkbox' name='include_"+tip+"[]' value='text.php' /> text.php <a href='javascript:;' class='rem' style='color:red;float:right;'>X</a></li>");
}   
</script>

<form method="post" action=""  enctype="multipart/form-data" class="w-100">
<div class='row'>
<div class="col-xl-4 col-lg-5 col-md-5 col-12">
<b style='color:#218FBF;font-size:15px;text-transform:uppercase;display:block;'>Izaberi <?php echo $zanas2?> za izmenu</b>
 
 <?php 
$sisi=2;  
 if($sisi==1)
 {
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND p.id_cat=$_GET[id_cat] ORDER BY p.position ASC");
while($tz1=mysqli_fetch_array($tz))
     {
if($tz1['ide']==$_GET['id']) $sele="selected"; else $sele="";
 ?>                     
<a href="<?php echo $patHA?>/index.php?base=admin&page=page_add&id=<?php echo $tz1['ide']?>&id_cat=<?php echo $_GET['id_cat']?>" style="font-weight:bold;color:black;"><?php echo $tz1["naziv"]?> <i class="fas fa-pencil-alt"></i></a>&nbsp; &nbsp;<a href="javascript:;" onclick="delme(<?php echo $tz1['ide'] ?>)"> <i class="fal fa-trash-alt crvena"></i></a>

<a href='<?php echo $patHA?>/index.php?base=admin&page=page_add_content&idp=<?php echo $tz1['id']?>'>add tekst</a> | 
<a href='<?php echo $patHA?>/index.php?base=admin&page=page_content&idp=<?php echo $tz1['id']?>'>lista</a>

<?php                      
$hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$tz1[ide]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");
   while($hz1=mysqli_fetch_array($hz))
     {
  if($hz1['ide']==$_GET['id']) $selet="selected"; else $selet="";
?>
 
<a href="<?php echo $patHA?>/index.php?base=admin&page=page_add&id=<?php echo $hz1['ide']?>" <?php echo $selet?> style="color:red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?> <i class="fas fa-pencil-alt"></i></a>&nbsp; &nbsp;<a href="javascript:;" onclick="delme(<?php echo $hz1['ide'] ?>)" > <i class="fal fa-trash-alt crvena"></i></a>

<?php 
$ahz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$hz1[id]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");                       
   while($ahz1=mysqli_fetch_array($ahz))
     {
$mn2=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM pages_text WHERE id_page=$ahz1[ide] AND id_cat=$_GET[id_cat]"));          
  if($ahz1['ide']==$_GET['id']) $selete="selected"; else $selete="";
?>
                     
<a href="<?php echo $patHA?>/index.php?base=admin&page=page_add&id=<?php echo $ahz1['ide']?>" <?php echo $selete?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ahz1["naziv"]?> <i class="fas fa-pencil-alt"></i></a>&nbsp; &nbsp;<a href="javascript:;" onclick="delme(<?php echo $ahz1['ide'] ?>)" > <i class="fal fa-trash-alt crvena"></i></a>

<?php 
}
}
}
}
?>
<link rel="stylesheet" href="ui-sortable/design1.css"/>
<a href="javascript:;" onclick="geti()">SAČUVAJ POZICIJE <?php echo $zanas3?></a>
<div id="rezu"></div>
<script>
function geti()
  {
  //alert($(".spacer").html())
  //x = new Array();
  var ar="";
$('.spacer  li').each(function(i)
{
var offset = $(this).offset();
//nova=(Math.round(offset.left)-972)/70;
nova=Math.round(offset.left);
 //alert("nova1:" + Math.round(offset.left));
v1=$(this).attr('id');
if(nova<417)
ar +="###"+v1;
$(this).children('ul').children('li').each(function(i)
{
var offset1 = $(this).offset();
//nova1=(Math.round(offset1.left)-972)/70;
nova1=Math.round(offset1.left);
var pp=$(this).parent("ul").parent("li").attr('id');
if(nova1<451)
ar +="###"+pp+"-"+$(this).attr('id');
//alert(pp+"-"+$(this).attr('id'));
$(this).children('ul').children('li').each(function(i)
{
var offset2 = $(this).offset();
//nova2=(Math.round(offset2.left)-972)/70;
nova2=Math.round(offset2.left);
var pp1=$(this).parent("ul").parent("li").attr('id');
if(nova2<490)
ar +="###"+pp+"-"+pp1+"-"+$(this).attr('id');
//alert(pp+"-"+pp1+"-"+$(this).attr('id'));
$(this).children('ul').children('li').each(function(i)
{
var offset3 = $(this).offset();
//nova3=(Math.round(offset3.left)-972)/70;
nova3=Math.round(offset3.left);
var pp2=$(this).parent("ul").parent("li").attr('id');
if(nova3==3)
ar +="###"+pp+"-"+pp1+"-"+pp2+"-"+$(this).attr('id');
//alert(pp+"-"+pp1+"-"+pp2+"-"+$(this).attr('id'));
});
});
});
});
//alert(ar);
$.ajax({
type: "POST",
//dataType: "json",
url: "<?php echo $patHA?>/save_page_position.php",
data: {ara:ar},
cache: false,
success: function(datas){ 
$('#rezu').html("Pozicije su sačuvane!");
}
});
}
</script>
<ul class='space first-space spacer zapaste' id='space1' style='margin-top:-30px;'>
<?php 
 $tz=mysqli_query($conn, "SELECT * FROM page  WHERE nivo=1 AND id_cat=$_GET[id_cat]  ORDER BY position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
$im=mysqli_query($conn, "SELECT * FROM pagel WHERE id_page=$tz1[id] AND lang='$firstlang'");
$im1=mysqli_fetch_assoc($im);        
?>
    <li class='route' id="<?php echo $tz1['id']?>">
    <a href='<?php echo $patHA?>/index.php?base=admin&page=page_add&id=<?php echo $tz1['id']?>&id_cat=<?php echo $_GET['id_cat']?>' style='position:absolute;left:2px;top:5px;z-index:100000;'>  <i class="fas fa-pencil-alt"></i></a>
    <?php 
    if($tz1['akt']==1) $tak="checked"; else $tak="";
    ?>
    <input type="checkbox" value='<?php echo $tz1['id']?>' class='ovor' style='position:absolute;right:2px;top:7px;z-index:100000;' <?php echo $tak ?> />
      <h3 class='title' id='title1'><?php echo $im1["naziv"]?></h3>
      <span class='ui-icon ui-icon-arrow-4-diag'></span>
      <ul class='space' id='space2'>
      <?php 
$hz=mysqli_query($conn, "SELECT * FROM page  WHERE id_parent=$tz1[id]  ORDER BY position ASC");
if(mysqli_num_rows($hz)>0)
{
   while($hz1=mysqli_fetch_array($hz))
     {
$ima=mysqli_query($conn, "SELECT * FROM pagel WHERE id_page=$hz1[id] AND lang='$firstlang'");
$ima1=mysqli_fetch_assoc($ima);     
      ?>
       <li class='route' id="<?php echo $hz1['id']?>">
        <a href='<?php echo $patHA?>/index.php?base=admin&page=page_add&id=<?php echo $hz1['id']?>&id_cat=<?php echo $_GET['id_cat']?>' style='position:absolute;left:4px; top:7px; z-index:100000;'> <i class="fas fa-pencil-alt"></i></a>
<?php 
    if($hz1['akt']==1) $hak="checked"; else $hak="";
    ?>        
        <input type="checkbox" value='<?php echo $hz1['id']?>' class='ovor' style='position:absolute;left:17px; top:3px; z-index:100000;' <?php echo $hak?> />
          <h3 class='title' id='title3'><?php echo $ima1["naziv"]?></h3>
          <span class='ui-icon ui-icon-arrow-4-diag'></span>
          <ul class='space' id='space3'>
          
           <?php 
$pz=mysqli_query($conn, "SELECT * FROM page  WHERE id_parent=$hz1[id] ORDER BY position ASC");
if(mysqli_num_rows($pz)>0)
{
   while($pz1=mysqli_fetch_array($pz))
     {
$imaz=mysqli_query($conn, "SELECT * FROM pagel WHERE id_page=$pz1[id] AND lang='$firstlang'");
$imaz1=mysqli_fetch_assoc($imaz);  
      ?>
       <li class='route' id="<?php echo $pz1['id']?>">
         <a href='<?php echo $patHA?>/index.php?base=admin&page=page_add&id=<?php echo $pz1['id']?>&id_cat=<?php echo $_GET['id_cat']?>' style='position:absolute;left:4px; top:7px; z-index:100000;'>  <i class="fas fa-pencil-alt"></i></a>
  <?php 
    if($pz1['akt']==1) $pak="checked"; else $pak="";
    ?>         
         <input type="checkbox" value='<?php echo $pz1['id']?>' class='ovor' style='position:absolute;left:17px; top:3px; z-index:100000;' <?php echo $pak?> />
          <h3 class='title' id='title3'><?php echo $imaz1["naziv"]?></h3>
          <span class='ui-icon ui-icon-arrow-4-diag'></span>
          <ul class='space' id='space4'>
          
          
           <?php 
$paz=mysqli_query($conn, "SELECT * FROM page  WHERE id_parent=$pz1[id] ORDER BY position ASC");
if(mysqli_num_rows($paz)>0)
{
   while($paz1=mysqli_fetch_array($paz))
     {
$imas=mysqli_query($conn, "SELECT * FROM page WHERE id=$paz1[id]");
$imas1=mysqli_fetch_assoc($imas);  
      ?>
       <li class='route' id="<?php echo $paz1['id']?>">
          <h3 class='title' id='title4'><?php echo $imas1["naziv$firstlang"]?> <?php echo $paz1['id']?></h3>
          <span class='ui-icon ui-icon-arrow-4-diag'></span>
          <ul class='space' id='space5'>

          </ul>
        </li>
     <?php 
     }
     }
     ?> 
          
          </ul>
        </li>
     <?php 
     }
     }
     ?>
          </ul>
        </li>
     <?php 
     }
     }
     ?> 
      </ul>
    </li>                      
<?php 
}
?>
</ul>

<script type='text/javascript' src="ui-sortable/responder.js"></script>              
</div>

<div class="col-xl-8 col-lg-7 col-md-7 col-12">
 <?php 
if($_GET['uspeh']==1)
$msr="Upisana je stranica. Unesite dodatne izmene za upisanu stranicu!";
if($msr!="")
echo "<div class='infos1'><div>$msr</div></div>";

if($_GET['id']>0)
{
$zz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE  p.id=$id_get  AND p.id_cat=$_GET[id_cat]"); 
$zz1=mysqli_fetch_array($zz);
if($zz1['id_page']!=3) {
?>
<div class='ui-tabs-panel ipad d-none'>
 <select name='id_parent' class='selecte w-100'> 
 <option value='0'>Izaberite parent stranu</option>
<?php
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND NOT p.id=$id_get AND p.id_cat=$_GET[id_cat] ORDER BY p.position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
  if($tz1['ide']==$_POST['id_parent'] or $tz1['ide']==$zz1['id_parent']) $sele="selected"; else $sele="";
                      ?>
<option value="<?php echo $tz1['ide']?>" <?php echo $sele?>><?php echo $tz1["naziv"]?></option>
<?php
$hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=2 AND NOT p.id=$id_get AND  id_parent=$tz1[ide]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");
   while($hz1=mysqli_fetch_array($hz))
     {
  if($hz1['ide']==$_POST['id_parent'] or $hz1['ide']==$zz1['id_parent']) $selet="selected"; else $selet="";
?>
<option value="<?php echo $hz1['ide']?>" <?php echo $selet?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option>
<?php 
$ahz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=3 AND NOT p.id=$id_get AND  id_parent=$hz1[id]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");                       
   while($ahz1=mysqli_fetch_array($ahz))
     {
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
<?php } ?> 
<div class="ui-tabs">
<ul class="ui-tabs-nav d-none">
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
 ?>
<div id="tabs-<?php echo $la1['id']?>" class="ui-tabs-panel">
 
<table class='w-100' cellspacing='10' cellpadding='0'>
 <?php
foreach($inp_niz1 as $key => $value)
{
?>
<tr>
<?php 
$zz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$la1[jezik]' AND  p.id=$id_get  AND p.id_cat=$_GET[id_cat]"); 
$zz1=mysqli_fetch_array($zz);
if($n>0) $stp=" style='padding-left:5px;'"; else $stp="";
$jez=$la1['jezik'];
$naziv=$inp_niz[$key];
$nazivi=$zz1[$naziv];
 ?>
 <td<?php echo $stp?>>
<?php echo $value?><br />
<?php 
if($inp_niz[$key]=="podnaslov")
{
?>
<textarea name='<?php echo $inp_niz[$key]?><?php echo $jez?>' class='selecte' placeholder="Ovo je kratak opis stranice."><?php echo $nazivi?></textarea>
<?php if($n==0)
{
}
}
else
{
?>
<input type="text" value="<?php echo $nazivi?>" name='<?php echo $inp_niz[$key]?><?php echo $jez?>' class='selecte' /> 
<?php } ?>
</td>
 </tr>
 <?php 
 }
 ?>
 </table>
	</div>
<?php $n++; } ?>
</div>   
<br class='clear' />
<?php 
$brnivo=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM page WHERE id_parent=$id_get"));
?>
<div class='ui-tabs-panel ipad'> 
  <table class='w-100' class='forma-lista' cellspacing='10' cellpadding='0'>
 <tr>
 <?php 
$zz=mysqli_query($conn, "SELECT * FROM page  WHERE id=$id_get");               
$zz1=mysqli_fetch_array($zz);
?>
 <td>
 Ikona za MENI: <br /><input type='text' name='class_for_icon' class='selecte' style='width:200px;' value='<?php echo $zz1['class_for_icon']?>' />
 </td>
 <td>
 <!--
 Naziv CSS klase za SECTION: <br /><input type='text' name='class_for_icon1' class='selecte' style='width:200px;' value='<?php echo $zz1['class_for_icon1']?>' />
 -->
 </td>
 
 <td>
 <!--
 Tabela / uslov: <br /><input type='text' name='tabela_za_brojanje' class='selecte' style='width:150px;' value='<?php echo $zz1['tabela_za_brojanje']?>' />
 -->
 </td>
<td class='pl-10 d-none'>
Slika: 
<br /> 
  <input type="file" class="file_input_div1"  id="avatar" name='slika' style='width:180px;' />
</td>
<td>
<?php 
if($zz1['slika']!="" and is_file("..".GALFOLDER."/thumb/$zz1[slika]"))
{
echo "<img src='..".GALFOLDER."/thumb/$zz1[slika]' style='max-width:100px;' />";
echo "<input type='hidden' name='stara_slika' value='$zz1[slika]' />";
echo "<br /><input type='checkbox' name='brisi' value='1' /> obrisi sliku";
}
?>
</td>
</tr>
</table> 
</div>
 
<br class='clear'>
<div class='ui-tabs-panel ipad'>
<span>Model prikaza</span>
<select name="model" class='selecte'> 
<option value='0'> -------- </option>                 
<?php 
$tz = mysqli_query($conn, "SELECT * FROM categories_group WHERE akt='1' AND tip=2"); 
while($tz1=mysqli_fetch_array($tz))
{
if((isset($_POST['model']) and $_POST['model']==$tz1['id']) or $tz1['id']==$zz1['model'])
$sev="selected"; else $sev="";     
?>
<option value="<?php echo $tz1['id']?>"  <?php echo $sev?>><?php echo $tz1["name"]?></option>
<?php 
}
?>
</select><br>
 <!--
<span>Koristi ovaj model prikaza za detaljan prikaz upisa (teksta)</span>
<select name="model1" class='selecte'> 
<option value='0'> -------- </option>                 
<?php 
$tz = mysqli_query($conn, "SELECT * FROM categories_group WHERE akt='1' AND tip=2"); 
while($tz1=mysqli_fetch_array($tz))
{
  
if((isset($_POST['model1']) and $_POST['model1']==$tz1['id']) or $tz1['id']==$zz1['model1'])
$sev="selected"; else $sev="";     
?>
<option value="<?php echo $tz1['id']?>"  <?php echo $sev?>><?php echo $tz1["name"]?></option>
<?php 
}
?>
</select><br><br>
-->
</div>
<?php 
if($_GET['id_cat']==0 and $hide_cats==1)
{
?>
<br class='clear'>
<div class='ui-tabs-panel ipad'>
<div  style='padding:10px;'>
<span>Dodeli određene kategorije ovoj stranici</span>
                 
<?php 
$tz = mysqli_query($conn, "SELECT * FROM categories_group WHERE akt='1' AND tip=0"); 
while($tz1=mysqli_fetch_array($tz))
{
$smo=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pages_kat WHERE id_page='$id_get' AND id_kat=$tz1[id]"));  
if(isset($_POST['kategi']) and in_array($tz1['id'],$_POST['kategi']) or $smo>0)
$sev="checked"; else $sev="";     
?>
<br><label><input type='checkbox' name='kategi[]' value="<?php echo $tz1["id"]?>" <?php echo $sev?> style='position:relative;top:1px;' /> <?php echo $tz1["name"]?></label>
<?php 
}
?>

 </div>
</div>
<?php } ?>
<div style="padding-top:15px;">
<?php if($zz1['show_for_users']==1) $zch="checked"; else $zch="";
 ?>

<div style='float:right;'>
<!--
<label><input type='checkbox' name='show_for_users' value='1' <?php echo $zch?> /> Prikazi ovu stranicu samo logovanim korisnicima</label>
-->
<input type='submit' name='izmena_stranice' class="submit_dugmici_blue" value='Izmeni stranicu' />
</div>
<?php if($zz1["id"]==1) $bez=" d-none"; else $bez=""; ?>
<input type='submit' onclick="delme('<?php echo $_GET['id']?>'); return false;" name='novi_upis_change' class="float-left submit_dugmici_blue<?php echo $bez?>" value='Obrisi ovu stranicu'>
</div>
<?php 
}
?>
</div>
</div>
</form>

<div class="row">
<div class="col-12">
<iframe src="modeli.php" class="w-100 mb-30" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
<script>
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
  }
</script>
</div>
</div>

 <div style='display:none'>
	<div id='inline_content' style='padding:10px; background:#fff;'> 
      <form method="post" action="">
   <div class='ui-tabs-panel ipad d-none'>
 <select name='id_parent' class='selecte w-100'> 
 <option value='0'>Izaberite parent stranu</option>
              
                      <?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND p.id_cat=$_GET[id_cat] ORDER BY p.position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
  if($tz1['ide']==$_POST['id_parent']) $sele="selected"; else $sele="";
                      ?>
<option value="<?php echo $tz1['ide']?>" <?php echo $sele?>><?php echo $tz1["naziv"]?></option>
						         	 <?php 
$hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$tz1[ide]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");
   while($hz1=mysqli_fetch_array($hz))
     {
  if($hz1['ide']==$_POST['id_parent']) $selet="selected"; else $selet="";
                      ?>
<option value="<?php echo $hz1['ide']?>" <?php echo $selet?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option>
						         	 <?php 
                       
$ahz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$hz1[id]  AND id_cat=$_GET[id_cat] ORDER BY p.position ASC");                       
   while($ahz1=mysqli_fetch_array($ahz))
     {
   
if($ahz1['ide']==$_POST['id_parent']) $selete="selected"; else $selete="";
                      ?>
<option value="<?php echo $ahz1['ide']?>" <?php echo $selete?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ahz1["naziv"]?></option>
<?php 
}
}
}
?>
</select>		
</div>
 <div class="ui-tabs">
 <!--
	<ul class="ui-tabs-nav">
<?php 

$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<li><a href="#tabsa-<?php echo $la1['id']?>"><?php echo $la1['jezik']?></a></li>
<?php } ?>
	</ul>
-->
  <?php 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
	<div id="tabsa-<?php echo $la1['id']?>" class="ui-tabs-panel">
 <table class='w-100' cellspacing='0' cellpadding='0'>
  <?php 

 foreach($inp_niz1 as $key => $value)
 {
 if($key<4 and $key!=1)
 {
 ?>
 <tr>
 <td>
 <?php echo $value?><br>
 <?php 
 $jez=$la1['jezik'];
 ?>
 <input type="text" name='<?php echo $inp_niz[$key]?><?php echo $jez?>' class='selecte' style='' />
 </td>
 </tr>
 <?php 
 }
 }
 ?>
 </table>
 </div>
<?php } ?>
</div>
<br>
<input type='submit' name='save_stranice' class="submit_dugmici_blue" value='Dodaj novu stranicu'>
</form>
</div>
 </div>	