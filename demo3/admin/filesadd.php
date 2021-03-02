<div class='detaljno_smestaj whites'>
 <?php
 if($_GET['tip']==0 or $_GET['tip']==1)
 {
 if($_GET['tip']==1) $tabi="page"; else $tabi="pages_text";
 $tabli="files";
 $su=mysqli_query($conn, "SELECT * FROM $tabi WHERE id=$_GET[idupisa]");
 $ai1=mysqli_fetch_array($su);
if(curPageURL()!=$_SERVER['HTTP_REFERER'] and $_SERVER['HTTP_REFERER']!="")
 $_SESSION['ref']=$_SERVER['HTTP_REFERER'];
 else $_SESSION['ref']="#";
 ?>
<div class='naslov_smestaj_padd'>
<h1 class="border_ha float-left">Fajlovi upisa: <?php echo $ai1["naslov$amlang"]?></h1>
<button class="float-right" onclick="window.history.go(-1); return false;">Nazad</button>
</div>
<?php
}
?>
<table   cellspacing='0' cellpadding="0" style='float:left;width:100%;'>
 <script type="text/javascript" src="<?php echo $patHA?>/js/jquery.form.js"></script>
<script type="text/javascript" >
 $(document).ready(function() {
 $('.button').live('click', function()			{
 //$('.button').click(function () {
    var ide=$(this).attr("id");

      var datastring = $("#forma"+ide).serialize();

      $("#forma"+ide+" .ajax-loading1").fadeIn();
   $.ajax({
type: "POST",
url: "<?php echo $patHA?>/sacuvaj_data_fajla.php",
data: datastring,
cache: false,
beforeSend: function(){
//$("#prev"+ide).html('<img src="<?php echo $patHA?>/images/loader.gif" alt="Sačekajte...."/>');
},
success: function(html){

$("#prev"+ide).html(html);
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
            $('#photoimg').live('change', function()			{
			        //  $("#preview").html('');
			    $("#previews").html('<img src="<?php echo $patHA?>/images/loader_tape.gif" alt="Sačekajte...."/>');
			$("#imageform").ajaxForm({

            success: function(response) {
     /*  if(response==12)
       {
       $("#previews").html('');
       alert("Već ste upisali 12 dozvoljenih slika!");
       }
       else*/
    $("#sortid_0").after(response);
     $("#previews").html('');
  }
		}).submit();

			});
        });
</script>
<script>
function delas(id,slika){
var answer = confirm("Da li želite da obrišete izabrani fajl?");
if(answer){
jQuery('#del'+id).html('<div>load...</div>');
    var url="<?php echo $patHA?>/del_file_pages.php?id="+id+"&slika="+slika+"&tabli=<?php echo $tabli?>";
   jQuery('#del'+id).load(url);
}
}
</script>
 <tr><td colspan="2">
<div style='padding:5px;font-size:14px;'>
<span style='display:block;padding-bottom:7px;font-size:15px;font-weight:bold;color:black;'>UPIS NOVIH FAJLOVA (Podržani formati:<strong style='color:red;'> pdf, doc, docx, excel, zip</strong>) </span>

<span style='font-size:11px;color:red'>
Dodajete jedan po jedan fajl. Pozivanjem fajla sa Vašeg računara on se automatski učitava.<br />
</span>
<br /><br />
<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo $patHA?>/ajaximage_files.php?ide=<?php echo $_GET['idupisa']?>&tip=<?php echo $_GET['tip']?>&tabela=<?php echo $tabli?>'>
<input type='file'  name="photoimg" id="photoimg"  /><br />
</form><br class='clear' />

<?php
$das=mysqli_query($conn, "SELECT * FROM $tabli WHERE idupisa=$_GET[idupisa] AND tip='".strip_tags($_GET['tip'])."'  ORDER BY -pozicija DESC");
$i=1;
?>
<div id='preview'></div>
<div  id='sorting'><ul  class='ul' style='float:left;'><li id='new_image'></li><li id='sortid_0' class='lisli'></li>


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
$zinix=explode('.', $p1['slika']);
$zext= end($zinix);
if($zext=="pdf" or $zext=="PDF") $icon="pdf-icon.png";
else
if($zext=="doc" or $zext=="DOC" or $zext=="docx" or $zext=="DOCX") $icon="word-icon.png";
else
if($zext=="xls" or $zext=="XLS" or $zext=="xlsx" or $zext=="XLSX") $icon="excel-icon.png";
echo "<a href='".$patH.FILFOLDER."/".$p1['slika']."' target='blank'  style='display:block;text-align:center;'><img src='".$patH."/images/icon/".$icon."'   alt='".$res['naslov']."'  /></a>";
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
 ?>
	<div id="tabs-<?php echo $la1['id']?>" class="ui-tabs-panel">
<?php
$sa=mysqli_query($conn, "SELECT * FROM files_lang WHERE lang='$la1[jezik]' AND id_fajla='$p1[id]'");
$sa1=mysqli_fetch_array($sa);
$jez=$la1['jezik'];
echo "Naziv: <input type='text' value='".$sa1["naslov"]."' name='naslov$jez' class='input_poljes_sivo' style='width:210px;' /><br />

<br />";

?>
</div>
<?php
}
?>
</div>
<div class='ui-tabs-panel ipad'>
<?php
if($p1['akt']=="Y") $ch="checked"; else $ch="";
?>
<input type='hidden' name='tabli' value='<?php echo $tabli?>'  />
<input type='hidden' name='idslike' value='<?php echo $p1['id']?>'  />
pozic: <input type='text' name='pozicija' value='<?php echo $p1['pozicija']?>' style='width:30px;' />
prikaži: <input type='checkbox' name='akti' value='1' <?php echo $ch?>  />
<?php

echo "<a href='javascript:;' title='brisi sliku - delete image' onclick=\"delas($p1[id],'$p1[slika]')\"  style='float:right;margin-top:3px;'>OBRIŠI FAJL</a>
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