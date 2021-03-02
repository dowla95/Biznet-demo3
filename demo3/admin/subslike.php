<div class='detaljno_smestaj whites'>
<?php 
 if(!isset($_GET['idupisa']))
 $_GET['idupisa']=0;
 $tabli="slike";
 if($_GET['tip']==0 or $_GET['tip']==1 or $_GET['tip']==4)
 {
 if($_GET['tip']==1) $tabi="page";
 else
 if($_GET['tip']==4) $tabi="prol";
 else
 if($_GET['tip']==0) 
 $tabi="pages_text_lang";
 $su=mysqli_query($conn, "SELECT * FROM $tabi WHERE id=$_GET[idupisa]");
 $ai1=mysqli_fetch_array($su);
 //
 if(curPageURL()!=$_SERVER['HTTP_REFERER'] and $_SERVER['HTTP_REFERER']!="")
 $_SESSION['ref']=$_SERVER['HTTP_REFERER'];
 else $_SESSION['ref']="#";
 ?>
<div class='naslov_smestaj_padd'><h1 class="border_ha">Slike upisa: <span style='color:#444'><?php echo $ai1["naslov"]?></span><a href="<?php echo $_SESSION['ref']?>" style='float:right;font-size:12px;'>PRETHODNA STRANA &raquo;</a></h1></div>
<?php 
}
elseif($_GET['tip']==2)
{
$velicina="Poželjno je da sve slike u slider-u budu istih dimenzija. Preporučena veličina ovih slika je 1600x700px.";
?>
<div class='naslov_smestaj_padd'><h1 class="border_ha">Slike Slider</h1></div>
 <br>
 <script>
 function gog(id)
{
if(id!="")
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&tip=2&idupisa=<?php echo $_GET[idupisa]?>&id_page="+id;
else
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&tip=2&idupisa=<?php echo $_GET[idupisa]?>&id_page=0";
}
</script>
<!--
<select name="kat" class='selecte' onchange="gog(this.value)">
<?php 
if($id_page==0 and $id_page!="") $pse="selected"; else $pse="";
if($id_page=="") $id_page=0; else $id_page=$id_page;    
?>
<option value=''>Izaberite stranicu ako zelite da slike dodelite odredjenoj stranici</option>
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  nivo=1  AND id_cat=0 ORDER BY p.position ASC");
while($tz1=mysqli_fetch_array($tz))
     {
     if($_GET['id_page']==$tz1['id_page']) $sel="selected"; else $sel="";
?>
<option value="<?php echo $tz1['id']?>" <?php echo $sel?> style="font-weight:bold;color:black;"><?php echo $tz1["naziv"]?></option>
<?php 
$hz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$tz1[id]  AND id_cat=0 ORDER BY p.position ASC");                       
   while($hz1=mysqli_fetch_array($hz))
     {
      if($_GET['id_page']==$hz1['id_page']) $sel="selected"; else $sel="";
?>
<option value="<?php echo $hz1['id']?>" <?php echo $sel?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option>
<?php 
$rz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$hz1[id]  AND id_cat=0 ORDER BY p.position ASC");                       
   while($pz1=mysqli_fetch_array($pz))
     {
     if($_GET['id_page']==$pz1['id_page']) $sel="selected"; else $sel="";                  
             ?>
<option value="<?php echo $pz1['id']?>" <?php echo $sel?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pz1["naziv"]?></option>
<?php 
}        	 
}
}
?>
</select><br><br>
-->
<?php 
}
if($_GET['tip']==3)
{
$velicina="Poželjno je da slike koje se koriste na istom mestu budu istih dimenzija. Preporučena veličina slika je:<br>
- Logo i slika u footer-u: 240x60px<br>
- Favicon: 32x32px<br>
- 1 baner: 1600x200px<br>
- 2 banera: 825x200px<br>
- 3 banera: 540x200px";
$id_page=0;
?>
<div class='naslov_smestaj_padd'><h1 class="border_ha">NEZAVISNE SLIKE</h1></div>
<?php 
}
/*$zip = new ZipArchive;
if ($zip->open('test.zip') === TRUE) {
    $zip->extractTo('test/');
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}
$path = 'test.zip';
$zip = new ZipArchive;
if ($zip->open($path) === true) {
    for($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);
        $fileinfo = pathinfo($filename);
        echo $filename."<br>";
        copy($path, "test/".$fileinfo['basename']);
    }                  
    $zip->close();                  
}
*/
//resize("2015-04-05-10-16-a.jpg","C:/xampp/htdocs/ming/".SUBFOLDER."galerija/");
?>
<table cellspacing='0' cellpadding="0" style='float:left;width:100%;'>
<script type="text/javascript" src="<?php echo $patHA?>/js/jquery.form.js"></script>
<script type="text/javascript" >
 $(document).ready(function() {
 $('.button').live('click', function()			{
 //$('.button').click(function () {
    var ide=$(this).attr("id")    
      var datastring = $("#forma"+ide).serialize();
      $("#forma"+ide+" .ajax-loading1").fadeIn();
   $.ajax({
type: "POST",
url: "<?php echo $patHA?>/sacuvaj_data_slike.php",
data: datastring,
cache: false,
beforeSend: function(){
//$("#prev"+ide).html('<img src="<?php echo $patHA?>/images/loader.gif" alt="Sačekajte...."/>'); 	 
},
success: function(html){
 if(html!='') alert(html)
//$("#prev"+ide).html(html);
 $("#forma"+ide+" .ajax-loading1").fadeOut();
}
});
    return false;
  });
    $(document).ready(function(){
    $("#sorting .ul").sortable({ 
      stop: function(){
        qString = $(this).sortable("serialize");
   // alert(qString)
       // $('#msg').fadeIn("slow");
        //$('#msg').html("Updating...");
        $.ajax({
          type: "POST",
url: "<?php echo $patHA?>/save_position.php?table=<?php echo $tabli?>&tip=<?php echo $_GET['tip']?>",
          data: qString,
          cache: false,
          beforeSend: function(html){
       $("#sorting .ul").css("opacity", "0.6");
      // $("#sorting .ul").append("load...");
          },
          success: function(html){
          $("#sorting .ul").css("opacity", "1.0")
          $("#sli").remove();
        $('#previews').html(html);
          }
        });
      }
    });
        //$("#sorting .ul").disableSelection();
  });
 // $('#brdanas').bind('change', function () {
		$( "body" ).on("change", "#photoimg", function() {
            //$('#photoimg').live('change', function()			{ 
			        //  $("#preview").html('');
			    $("#previews").html('<img src="<?php echo $patHA?>/images/loader_tape.gif" alt="Sačekajte...."/>');
			$("#imageform").ajaxForm({
					 
            success: function(response) {
       if(response==12) 
       {
       $("#previews").html('');
       alert("Već ste upisali 12 dozvoljenih slika!");
       }
       else
    $("#sortid_0").after(response);
     $("#previews").html('');
  }
		}).submit();
		
			});
        }); 
</script>
<script>
function delas(id,slika){ 
var answer = confirm("Da li želite da obrišete izabranu sliku?");
if(answer){
jQuery('#del'+id).html('<div>load...</div>');
    var url="<?php echo $patHA?>/del_image_pages.php?id="+id+"&slika="+slika+"&tabli=<?php echo $tabli?>";
   jQuery('#del'+id).load(url);
}
}
</script>
 <tr><td colspan="2">
<div style='padding:5px;font-size:14px;'>
<div style='display:block;padding-bottom:7px;font-size:15px;font-weight:bold;color:black;'>Podržani formati slika:<strong style='color:red;'> jpg, gif, png, zip, svg</strong></div>
<div><?php echo $velicina ?></div>
<span style='font-size:11px;color:red'>
Dodajete jednu po jednu sliku. Pozivanjem slike sa Vašeg računara ona se automatski učitava.<br>
</span>
<br><br>
<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo $patHA?>/ajaximage_pages.php?ide=<?php echo $_GET['idupisa']?>&tip=<?php echo $_GET['tip']?>&tabela=<?php echo $tabli?>'>
<input type='file'  name="photoimg" id="photoimg"  /><br>
</form><br class='clear'>
<?php 
$das=mysqli_query($conn, "SELECT * FROM slike WHERE idupisa=$_GET[idupisa] AND id_page=$id_page AND tip='".strip_tags($_GET['tip'])."'  ORDER BY -pozicija DESC");
$i=1;
?>
<div id='preview'></div>
<div id='sorting'><ul class='ul' style='float:left;'><li id='new_image'></li><li id='sortid_0' class='lisli'></li>
 <?php 
while($p1=mysqli_fetch_assoc($das))
 {  
  $b=$i%2;
 ?> 
<li id='sortid_<?php echo $p1['id']?>' style='margin-bottom:10px;width:240px;float:left;
margin-left:10px;'>
<form method="post" action="" id="forma<?php echo $p1['id']?>"> 
<div style='float:left;width:100%;font-size:11px;color:black;position:relative;' id='del<?php echo $p1['id']?>'>
  <div class='ajax-loading1'></div>
 
<?php
if(substr($p1['slika'],-4)==".svg") $thumb=""; else $thumb="/thumb";
echo "<a href='".$patH.GALFOLDER.$thumb."/".$p1['slika']."' class='group1'  style='display:block;width:$im[0]px;'><img src='".$patH.GALFOLDER."/".$p1['slika']."'  alt='".$res['naslov']."' style='border:1px solid #999;padding:2px;height:60px;max-width:90%' /></a><br>";
?>
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
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 $sa=mysqli_query($conn, "SELECT * FROM slike_lang WHERE lang='$la1[jezik]' AND id_slike='$p1[id]'");
$sa1=mysqli_fetch_array($sa);
 ?>
	<div id="tabs-<?php echo $la1['id']?>" class="ui-tabs-panel">
 

<?php 
if($_GET['tip']==2) {
$polje1="Prvi red u slideru";
$polje2="Drugi red u slideru";
$polje3="Treci red u slideru";
}
elseif($_GET['tip']==3) {
$polje1="Alt slike:";
$polje2="Title slike:";
$polje3="U link:";
}
elseif($_GET['tip']==1) {
$polje1="Alt slike:";
$polje2="Title slike:";
$polje3="Link na slici:";
$polje4="Pripadnost:";
}
else {
$polje1="Alt slike:";
$polje2="Title slike:";
//$polje3="U link:";
}
$jez=$la1['jezik'];
echo $polje1." <input type='text' value='".$sa1["alt"]."' name='alt$jez' class='input_poljes_sivo' style='width:210px;' /><br>
".$polje2." <input type='text' value='".$sa1["title"]."' name='title$jez' class='input_poljes_sivo' style='width:210px;' /><br>";
if(isset($polje3))
echo $polje3." <input type='text' value='".$sa1["ulink"]."' name='ulink$jez' class='input_poljes_sivo' style='width:210px;' /><br>";
if(isset($polje4))
echo $polje4." <input type='text' value='".$sa1["pripada"]."' name='pripada$jez' class='input_poljes_sivo' style='width:210px;' /><br>";
else
echo "<input type='hidden' value='".$sa1["ulink"]."' name='ulink$jez' class='input_poljes_sivo' style='width:210px;' /><br>";
if($_GET['tip']==3){
echo "Slika se koristi za<select name='subtip' class='input_poljes_sivo' style='width:210px;'>";

foreach($nizSub as $k => $v) {
$ep=explode("-",$k);
if($p1['subtip']==$ep[0]) $toje=" selected"; else $toje="";
echo "<option value='$k'$toje>$v</option>";
}
echo "</select><br><br>";
}
?>
</div>
<?php 
}
?>
</div>
 
<div class='ui-tabs-panel ipad'>
<?php 
if($_GET['tip']==2)  
echo "Link: <input type='text' value='".$p1["link"]."' name='link' class='input_poljes_sivo' style='width:210px;' /><br><br>";
if($p1['akt']=="Y") $ch="checked"; else $ch="";
if($p1['poc']=="Y") $ch1="checked"; else $ch1="";
?>
<input type='hidden' name='idslike' value='<?php echo $p1['id']?>'  />
<input type='hidden' name='tabli' value='<?php echo $tabli?>'  />
Pozicija: <input type='text' name='pozicija' value='<?php echo $p1['pozicija']?>' style='width:20px;' />
<span style="padding-left:15px;">prikaži:</span> <input type='checkbox' name='akti' value='1' <?php echo $ch?>  />
<?php 
if($_GET['tip']!=2 and $_GET['tip']!=3)
{
?>
<!--
home: <input type='checkbox' name='poc' value='1' <?php echo $ch1?>  />
-->
<?php 
}
else
{
?>
<input type='hidden' name='poc' value='1' <?php echo $ch1?>  />
<?php 
}
echo "<a href='javascript:;' title='brisi sliku - delete image' onclick=\"delas($p1[id],'$p1[slika]')\"  style='float:right;margin-top:3px;'>OBRIŠI</a>
";
?>
</div>
<div id="prev<?php echo $p1['id']?>"></div>
<input type='submit' name='izmene_slike' class="submit_dugmici_blue button" value='Sačuvaj izmene' style='width:100%;' id="<?php echo $p1['id']?>" />
</form>

</div>
  
</li>
<?php 

$i++;
 }
?>
</ul></div>
</div>
</td></tr>
	 

<tr><td colspan="2" height="20">	 

<?php 
if($_POST['izmena_korak5'])
{
?>
<div class='box'><div>UPIS JE SAČUVAN I ČEKA ODOBRENJE ADMINISTRATORA UKOLIKO NIJE ODOBRAVAN DO SADA</div></div>
<?php 
}
?>
</td></tr>
 <tr><td colspan="2" height="20"></td></tr>
  </table>	
</div> 