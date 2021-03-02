 
<div class='detaljno_smestaj whites'>
 
	<div class='naslov_smestaj_padd'><h1 class="border_ha">Upis - Izmena reči jezika</h1></div>
 
 
  
 
 
 <?php 
if($msr!="" and $_POST['save_izmena_jezika'])
echo "<div class='box_beeg'><div>$msr</div></div>";
else
if($msrok!="" and $_POST['save_izmena_jezika'])
echo "<div class='box_beeg_ok'><div>$msrok</div></div>";
 ?>
  <ul id="ovo" class='ul langi' >
<li id="clonedInput1" class="clonedInput hiden" style='border-bottom:1px solid #f1f1f1;width:100%;'>
<div class='padd'>
<input type="text" name="slug[]"  style='margin-left:20px;background:#F9F9F4'  class='inputli' /> <b> - Slug naziva (upisati slug koji ne postoji, u obliku: nesto_nesto)</b>
<br />
<div style='width:100%;margin-top:10px;'>
<?php 
$tz=mysqli_query($conn, "SELECT * FROM language ORDER BY pozicija ASC");
while($tz1=mysqli_fetch_array($tz))
{
 
?>
<b style='text-transform:uppercase;'><?php echo $tz1['jezik'] ?>:</b>  <input type="text" name="lang[<?php echo $tz1['jezik'] ?>][]"  class='inputli' />
<?php } ?>

</div>





<div style='text-align:right;'>
<a href="javascript:;" class="clone">Novi red</a> |  
        <a href='javascript:;' class="remove">Obriši red</a>
        </div>
</div>        
    
</li>
</ul>
 
 
 
 
 
<div class="ui-tabs">
	<ul class="ui-tabs-nav">
<?php 
if(isset($_POST['save_izmena_reci']))
{
if(is_file("$page_path2/language/$firstlang".".php"))
{
$myfile = @fopen("$page_path2/language/".trim($firstlang.".php"), "r") or die("Unable to open file!");
$procF= @fread($myfile,filesize("$page_path2/language/$firstlang".".php"));
}

$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 $jezik=$la1['jezik'];
 $rlang="$jezik.php";
 
//if(is_file("$page_path2/language/$rlang")){ 
$proc=$_POST["opis$jezik"];
 $f=fopen("$page_path2/language/".trim($jezik).".php","w");
  //$proc=str_replace("\"","'",$proc);
  if (fwrite($f,$proc)>0){
   fclose($f);
  }
//}
/*else
{ 
$proc=$procF;
 $f=fopen("$page_path2/language/".trim($jezik).".php","w");
    
  if (fwrite($f,$proc)>0){
   fclose($f);
  }
}*/
 
 }
}

$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<li><a href="#tabs-<?php echo $la1['id']?>"><?php echo $la1['jezik']?></a></li>
<?php } ?>
	</ul> 
<form method='post' action=''>
  <?php 
$n=0;
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<div id="tabs-<?php echo $la1['id']?>" class="ui-tabs-panel">
<table style='width:100%;' class='tar' cellpadding="10">
 
<tr><td colspan='3'>

 <?php 

$rlang="$la1[jezik].php";
 
if(is_file("$page_path2/language/$rlang"))
{ 
$myfile = @fopen("$page_path2/language/$rlang", "r") or die("Unable to open file!");
$proc= @fread($myfile,filesize("$page_path2/language/$rlang"));
echo "<textarea name='opis$la1[jezik]' style='width:100%;height:800px;'>";
echo $proc;
echo "</textarea>";
fclose($myfile); 
}else
{
echo "<textarea name='opis$la1[jezik]' style='width:100%;height:800px;'>";

echo "</textarea>";
} 
 ?>
 </td></tr>
 
 
 
</tr>
 
</table>

</div>
	<?php $n++; } ?>
  <br />
  <input type='submit' name='save_izmena_reci' class="submit_dugmici_blue fright" value='Sacuvaj izmene'>
</form>                       
 
<br />



		
</div> 




			

