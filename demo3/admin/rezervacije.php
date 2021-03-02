 <link rel="stylesheet" href="<?php echo $patH?>/css/jquery.datepick.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $patH?>/js/jquery.datepick.js"></script>
<script>
$(function() {
		
$('#popupDatepicker').datepick();
 
});

</script>

<br class='clear' />
<br />
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td width="40%">

<div class='naslov_smestaj'><h1>Sve rezervacije</h1></div>
</td>
 
<td align='right'><a href="#inline_content" class='inline'><span style='padding:6px 10px;font-size:15px;'>PRONAĐI REZERVACIJE</span></a>
<div class='trakica_pozadina'></div>
</td>
 
 
<!--<td>
 <a href='<?php echo $patH1?>/korisnik/novi-oglas/'  class='link_dugme_plavo'><span style='padding:6px 10px;'>UPIŠITE NOVI SMEŠTAJ</span></a>
<div class='trakica_pozadina'></div>
</td>-->
</tr>
</table>              
<?php 
$orderby=" id DESC";
 
$ByPage1=50;
if($_GET[search]==1)
{
$plun="";
$pojams=$_GET[pojams];
if($pojams!="") 
{
$pojams=str_replace(" ","_",$pojams);
$poh=explode("_",$pojams);
for($t=0;$t<count($poh); $t++)
{ 
if(strlen($poh[$t])>2){
$pret = addcslashes($poh[$t], '%_');
 
//$plus .=" AND (naslov LIKE '%$pret%' OR opis LIKE '%$pret%' OR opis1 LIKE '%$pret%' OR kraj LIKE '%$pret%' OR idfirme IN (SELECT id FROM proizvodi_page WHERE naslov LIKE '%$pret%'))";
//$pret = str_replace(array('š', 'ć', 'č', 'ž', 's', 'c', 'z','Š', 'Ć', 'Č', 'Ž', 'S', 'C', 'Z'), array('(š|s)', '(ć|c)', '(č|c)', '(ž|z)', '(š|s)', '(c|ć|č)', '(ž|z)','(Š|S)', '(Ć|C)', '(Č|C)', '(Ž|Z)', '(Š|S)', '(C|Ć|Č)', '(Ž|Z)'), $pret);  
//$plun .=" AND (p.naziv REGEXP '[[:<:]]".$pret."[[:>:]]' OR p.opis  REGEXP '%*".$pret."[[:>:]]')";
$plun .=" AND (ime LIKE '%".$pret."%' OR telefon LIKE '%".$pret."%' OR email LIKE '%".$pret."%' OR opis LIKE '%".$pret."%')";

}
}
}
} 
if($_GET[id_ap]>0)
$plun .=" AND id_ap=$_GET[id_ap]";

 if($_GET[odd]>0)
$plun .=" AND odd>='".strtotime($_GET[odd])."'";


 

$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM rezervacije WHERE id>0 $plun"));
$pagedResults = new Paginated($br_upisa, $ByPage1, $page_tr);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout());

$fi=mysqli_query($conn, "SELECT * FROM rezervacije WHERE id>0 $plun ORDER BY  $orderby LIMIT $str,$ByPage1");

 
 ?>
 

 <div id='sorting'>
<table class='upitnici_oglasi'>
<tbody id="slickbox1">
<!--<tr>
    <th colspan="3">Lista upitnika</th>
  </tr>-->
  <tr class="yellow" id="sortid_0"> 
   
    <td>Naziv apartmana</td>
         <td>Ime</td>
   
     
    <td>Rezervacija Od - Do</td>
    <td>Br osoba</td>    
   <td>Email</td>   
    <td>Telefon</td>
 <td>Vreme rezerv.</td>
 <td>Brisanje</td>
  </tr>
<?php 
 
$i=0;
while($og1=mysqli_fetch_array($fi)){
if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';
$msg_id=$og1['id']; 
 
?>
<tr id="sortid_<?php echo $og1[id]?>" style='<?php echo $ba?>'>



<td>
 <?php 
$fog=mysqli_query($conn, "SELECT * FROM oglasi WHERE id='$og1[id_ap]'");
$fog1=mysqli_fetch_array($fog);
 echo $fog1[nameAdsslo];
 ?>


 </td>
  <td>
<?php echo $og1[ime]?>
 </td>
<td>
<?php 
echo datum($og1[odd])." -  ".datum($og1[doo]);
?>
</td>
 
<td>
<?php 
echo "$og1[brosoba]";
?>
</td>
<td>
<?php 
echo "$og1[email]";
?>
</td> 
<td>
<?php 
echo "$og1[telefon]";
?>
</td>
<td>
<?php 
echo date("d-m-Y H:i:s", $og1[vreme]);
?>
</td>
 
 
 

 
<td>
 
<a href="javascript:;" class="edit_oglas" onclick="obrisime(<?php echo $og1[id]?>,'delete_rezerv')"><img src="<?php echo $patHA?>/images/b_drop.png" /></a>
</td>

</tr>
 <?php 
 if(strlen($og1[opis])>4)
 {
 ?>
 <tr>
 <td colspan="9">
 <?php 
 echo nl2br($og1[opis]);
 ?>
 </td>
 </tr>
 <?php 
 }
 ?>
<?php 
$i++;
}


 
?>
</tbody>
  </table>
  </div>
  <?php 
//$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 order by ISNULL(pozicija), pozicija ASC");
//$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 order by -pozicija DESC");
//while($fi1=mysqli_fetch_array($fi))
//echo $fi1[nameAdsslo]." - $fi1[pozicija]<br />"; 
?>
<div class='pagination_o'>	
	<?php 
$hah=preg_replace("/&p=[0-9]/","",curPageURL());
 if($br_upisa>$ByPage1)
echo $pagedResults->fetchPagedNavigation(curPageURL()."&p=");
  ?>
</div>
<?php 
   
  ?>
<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
		<form method="get" action="">
    <h3>Pronađite rezervacije</h3>
    Ukucajte ime, email, telefon, ili sadrzaj iz opisa:
    <br />
    <input type="hidden" name="base" value="<?php echo $_GET[base]?>" />
    <input type="hidden" name="page" value="<?php echo $_GET[page]?>" />
    <input type="hidden" name="search" value="1" />
  <input type='text' name='pojams' class='input_poljes'  value="<?php echo $_GET[pojams]?>">
    <br />
    <br />
  Rezervacije izvresene od datuma: 
    <input type='text' name='odd' class='input_poljes' id="popupDatepicker" value="<?php echo $_GET[odd]?>" >
    <br />
    <br />
   Mesto:<br />
    <select name="id_ap" class='selecte'>
    <option value=''>----</option>
    <?php 
$gg=mysqli_query($conn, "SELECT * FROM oglasi order by nameAdsslo asc");
while($gg1=mysqli_fetch_array($gg))
{
if($_GET[id_ap]==$gg1[id]) $tcity="selected"; else $tcity="";
    echo "<option value='$gg1[id]' $tcity>".$gg1["nameAdsslo"]."</option>";
}
    ?>
    </select>
    
     
    <br /><br />
    <input type="submit" value="Pronađi" name='nadji_oglas' class='submit_dugmici_blue' />
    </form>
			</div>
		</div>       
