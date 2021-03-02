<div class='detaljno_smestaj whites'>
 
	<div class='naslov_smestaj_padd'><h1 class="border_ha">Upis / izmena stavki u formi za posao</h1></div>
 
 
 
<script> 
function gog(id)
{
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id="+id;
}
</script>
 
<?php 
if($_POST[save_stavkes])
{
$i=0;
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1[jezik];
$naziv="novastavka$jez";
if($i>0) $zar=", "; else $zar=""; 
$nazivis .= $zar."naziv$jez=".safe($_POST[$naziv]);
$i++; 
 }
$tips=$_POST[tips]; 
//echo $nazivis;
  if(!mysqli_query($conn, "INSERT INTO stavke SET $nazivis")) echo mysqli_error(); else
 echo "<div class='infos1'><div>Uspesno je dodata nova stavka!</div></div>";
}
if($_POST[izmene_stavkes])
{
$i=0;
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1[jezik];
$naziv="starastavka$jez";
if($i>0) $zar=", "; else $zar=""; 
$nazivis .= $zar."naziv$jez=".safe($_POST[$naziv]);
$i++; 
 }
$tips=$_POST[tipsa]; 
 if(!mysqli_query($conn, "UPDATE stavke SET $nazivis WHERE id=$id_get")) echo mysqli_error(); else
 echo "<div class='infos1'><div>Uspesno je izmenjena izabrana stavka!</div></div>"; 
 
}
if($_POST[obrisi_stavkes])
{
mysqli_query($conn, "DELETE FROM stavke WHERE id=$_GET[id] LIMIT 1");
 echo "<div class='infos1'><div>Obrisana izabrana stavka!</div></div>";
}
?> 
  
<form method="post" action="">
 <div class="ui-tabs">
 
<span>Stavke u formi za posao</span>
 
<select name="kat" class='selecte' onchange="gog(this.value)">
<option value=''>---</option>                  
                      <?php 
$tz=mysqli_query($conn, "SELECT * FROM stavke  ORDER BY naziv$amlang ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
       if($tz1[id]==$_GET[id]) $sele="selected"; else $sele="";
                      ?>
<option value="<?php echo $tz1[id]?>" <?php echo $sele?>><?php echo $tz1["naziv$amlang"]?></option>
						         	 <?php 
                      }
                        ?>
						                    </select>
                        
<br />
 
<?php 
if($_GET[id]>0)
{
$tz=mysqli_query($conn, "SELECT * FROM stavke WHERE id=".strip_tags($_GET['id'])."");
$tz1=mysqli_fetch_array($tz);
?>
 <br />
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
  
 
 <?php 
 $jez=$la1[jezik];
 ?>
 <input type="text" name='starastavka<?php echo $jez?>' value="<?php echo $tz1["naziv$jez"]?>" class='selecte' style='' />
 </div>
 <?php 
 }
 ?>
 
<br />

<input type='submit' name='izmene_stavkes' class="submit_dugmici_blue" value='<?php echo $langa['time_zone'][3]?>'> 
 <input type='submit' name='obrisi_stavkes' class="submit_dugmici_blue" value='Obriši'> 
 <br /><br />
<?php 
}
?>
 </div>
 <br />
  <div class="ui-tabs">
 	<ul class="ui-tabs-nav">
<?php 

$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<li><a href="#tabsas-<?php echo $la1['id']?>"><?php echo $la1['jezik']?></a></li>
<?php } ?>
	</ul>
 
  <?php 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
	<div id="tabsas-<?php echo $la1['id']?>" class="ui-tabs-panel">
  
 
 <?php 
 $jez=$la1[jezik];
 ?>
 <input type="text" name='novastavka<?php echo $jez?>' class='selecte' style='' />
 </div>
 <?php 
 }
 ?>
 
<br />

<input type='submit' name='save_stavkes' class="submit_dugmici_blue" value='<?php echo $langa['language'][3]?>'>
 
 </div>
<br />

</form>

		
</div> 




			

