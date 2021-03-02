<div class='detaljno_smestaj whites'>
<?php 
 $tabli="slike";
?>
<table cellspacing='0' cellpadding="0" style='float:left;width:100%;'>
<script type="text/javascript" src="<?php echo $patHA?>/js/jquery.form.js"></script>
<script type="text/javascript" >
 $(document).ready(function() {
 $('.button').live('click', function() {
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
url: "<?php echo $patHA?>/save_position.php?table=<?php echo $tabli?>&tip=5",
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
<span style='display:block;padding-bottom:7px;font-size:15px;font-weight:bold;color:black;'>UPIS NOVIH SLIKA (Podržani formati slika:<strong style='color:red;'> jpg, gif, png, zip</strong>)</span>
<span style='font-size:11px;color:red'>
Dodajete jednu po jednu sliku. Pozivanjem slike sa Vašeg računara ona se automatski učitava.<br>
</span>
<br><br>
<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo $patHA?>/ajaximage_pages.php?ide=<?php echo $zz1['id']?>&tip=5&tabela=<?php echo $tabli?>'>
<input type='file'  name="photoimg" id="photoimg" /><br>
</form><br class='clear'>
<?php 
$das=mysqli_query($conn, "SELECT * FROM slike WHERE idupisa=$zz1[id] AND id_page=0 AND tip=5 ORDER BY -pozicija DESC");
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
echo "<a href='".$patH.GALFOLDER."/".$p1['slika']."' class='group1'  style='display:block;width:$im[0]px;'><img src='".$patH.GALFOLDER."/thumb/".$p1['slika']."' alt='".$res['naslov']."' style='border:1px solid #999;padding:2px;height:60px;max-width:90%' /></a><br>";
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
$polje1="Alt slike:";
$polje2="Title slike:";
$polje3="U link:";

 $jez=$la1['jezik'];
echo $polje1." <input type='text' value='".$sa1["alt"]."' name='alt$jez' class='input_poljes_sivo' style='width:210px;' /><br>
".$polje2." <input type='text' value='".$sa1["title"]."' name='title$jez' class='input_poljes_sivo' style='width:210px;' /><br>";
if($_GET['tip']!=3)
echo $polje3." <input type='text' value='".$sa1["ulink"]."' name='ulink$jez' class='input_poljes_sivo' style='width:210px;' /><br><br>";
else
echo "<input type='hidden' value='".$sa1["ulink"]."' name='ulink$jez' class='input_poljes_sivo' style='width:210px;' />";
?>
</div>
<?php 
}
?>
</div>
 
<div class='ui-tabs-panel ipad'>
<?php   
echo "Linkuj sliku: <input type='text' value='".$p1["link"]."' name='link'   class='input_poljes_sivo' style='width:210px;' /><br><br>";
if($p1['akt']=="Y") $ch="checked"; else $ch="";
if($p1['poc']=="Y") $ch1="checked"; else $ch1="";
?>
<input type='hidden' name='idslike' value='<?php echo $p1['id']?>'  />
<input type='hidden' name='tabli' value='<?php echo $tabli?>'  />
Pozicija: <input type='text' name='pozicija' value='<?php echo $p1['pozicija']?>' style='width:20px;' />
<span style="padding-left:15px;">prikaži:</span> <input type='checkbox' name='akti' value='1' <?php echo $ch?>  />

<input type='hidden' name='poc' value='1' <?php echo $ch1?>  />
<?php 
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

</td>
</tr>

  </table>	
</div> 