 

<br class='clear' />
<br />
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td width="40%">

<div class='naslov_smestaj'><h1>Komentari</h1></div>
</td>
<?php $nea=preg_replace("/&n=1/","",curPageURL()); ?>
<?php 
if($_GET[n]==1)
{
?>
<td align='right'><a href="<?php echo $nea?>"><span style='padding:6px 10px;font-size:15px;'>PRIKAŽI SVE KOMENTARE</span></a>
<div class='trakica_pozadina'></div>
</td>
<?php 
}else
{
?> 
<td align='right'><a href="<?php echo curPageURL()?>&n=1"><span style='padding:6px 10px;font-size:15px;'>PRIKAŽI NEAKTIVNE KOMENTARE</span></a>
<div class='trakica_pozadina'></div>
</td>
<?php 
}
?>
<td align='right'><a href="#inline_content" class='inline'><span style='padding:6px 10px;font-size:15px;'>PRONAĐI KOMENTARE</span></a>
<div class='trakica_pozadina'></div>
</td>
 
 
<!--<td>
 <a href='<?php echo $patH1?>/korisnik/novi-oglas/'  class='link_dugme_plavo'><span style='padding:6px 10px;'>UPIŠITE NOVI SMEŠTAJ</span></a>
<div class='trakica_pozadina'></div>
</td>-->
</tr>
</table>              
<?php 
 
 
$ByPage1=20;
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
$plun .=" AND (naslov LIKE '%".$pret."%' OR email LIKE '%".$pret."%' OR opis LIKE '%".$pret."%')";

}
}
}
} 
if($_GET[id_ap]>0)
$plun .=" AND id_pro=$_GET[id_ap]";

if($_GET[n]>0)
$plun .=" AND akt='N'";


 if($_GET[odd]>0)
$plun .=" AND odd>='".strtotime($_GET[odd])."'";


 

$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comments WHERE id>0 $plun AND id_parent=0"));
$pagedResults = new Paginated($br_upisa, $ByPage1, $page_tr);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout());
if($_GET[n]==1) $id_par=""; else $id_par=" AND id_parent=0";
$fi=mysqli_query($conn, "SELECT * FROM comments WHERE id>0  $plun $id_par ORDER BY  id DESC   LIMIT $str,$ByPage1");

 
 ?>
 

 <div id='sorting'>
<table class='upitnici_oglasi'>
<tbody id="slickbox1">
<!--<tr>
    <th colspan="3">Lista upitnika</th>
  </tr>-->
  <tr class="yellow" id="sortid_0"> 
   
    <td>Naslov teksta</td>
         <td>Ime</td>
   
   <td>Email</td>   

 <td>Vreme</td>
 <td>Opis</td>
 <td>Prikaz</td>
 <td>Brisanje</td>
  </tr>
<?php 
 
$i=0;
while($og1=mysqli_fetch_array($fi)){
if($og1[id_parent]==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';
$msg_id=$og1['id']; 
 
?>
<tr id="sortid_<?php echo $og1[id]?>" style='<?php echo $ba?>'>



<td>
 <?php 
$fog=mysqli_query($conn, "SELECT * FROM pages_text WHERE id='$og1[id_pro]'");
$fog1=mysqli_fetch_array($fog);
 echo "<a href='$og1[link_strane]'  target='_blank'>$fog1[naslovslo]</a>";
 ?>


 </td>
  <td>
<?php echo $og1[naslov]?>
 </td>
<td>
<?php 
echo $og1[email];
?>
</td>
 
<td>
<?php 
echo date("d-m-Y H:i",$og1[datum]);
?>
</td>
 
 <td>
<?php 
echo "$og1[opis]";
?>
<br />
<a href='<?php echo $patHA?>/komentar_upis.php?id_upisa=<?php echo $fog1[id]?>&id_parent=<?php echo $og1[id]?>&tip=0' class='iframes'>Odgovori</a> | <a href='<?php echo $patHA?>/komentar_izmena.php?id=<?php echo $og1[id]?>' class='iframes'>Izmeni</a>
</td> 
 
 
 
 
<td>
 <?php 
if($og1[akt]=="Y") $che="checked"; else $che="";
?>
<input type='checkbox' value='1' <?php echo $che?> onclick="akti('<?php echo $og1[id]?>', 'akti_koment')" />
 </td>
<td>
 
<a href="javascript:;" class="edit_oglas" onclick="obrisime(<?php echo $og1[id]?>,'delete_koment')"><img src="<?php echo $patHA?>/images/b_drop.png" /></a>
</td>
 
</tr>

<?php 
 

$sfi=mysqli_query($conn, "SELECT * FROM comments WHERE id>0  $plun AND id_parent=$og1[id] ORDER BY  id ASC");
$i=0;
while($fog1=mysqli_fetch_array($sfi)){
$ba='background:#fff;';
$msg_id=$fog1['id']; 
 
?>
<tr id="sortid_<?php echo $fog1[id]?>" style='<?php echo $ba?>'>



<td>
 <?php 
$tog=mysqli_query($conn, "SELECT * FROM pages_text WHERE id='$fog1[id_pro]'");
$tog1=mysqli_fetch_array($tog);
 echo "<a href='$og1[link_strane]' target='_blank'>$tog1[naslovslo]</a>";
 ?>


 </td>
  <td>
<?php echo $fog1[naslov]?>
 </td>
<td>
<?php 
echo $fog1[email];
?>
</td>
 
<td>
<?php 
echo date("d-m-Y H:i",$fog1[datum]);
?>
</td>
 
 <td>
<?php 
echo "$fog1[opis]";
?>
<br />
<a href='<?php echo $patHA?>/komentar_izmena.php?id=<?php echo $fog1[id]?>' class='iframes'>Izmeni</a>
</td> 
 
 
 
 
<td>
 <?php 
 

if($fog1[akt]=="Y")  $aht="checked"; else $aht="";

?>
<input type='checkbox' value='1' <?php echo $aht?> onclick="akti('<?php echo $fog1[id]?>', 'akti_koment')" />
 </td>
<td>
 
<a href="javascript:;" class="edit_oglas" onclick="obrisime(<?php echo $fog1[id]?>,'delete_koment')"><img src="<?php echo $patHA?>/images/b_drop.png" /></a>
</td>
 
</tr>

<?php 
$i++;
}
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
    <h3>Pronađite komentar</h3>
    Ukucajte ime, email, ili sadrzaj iz opisa:
    <br />
    <input type="hidden" name="base" value="<?php echo $_GET[base]?>" />
    <input type="hidden" name="page" value="<?php echo $_GET[page]?>" />
    <input type="hidden" name="search" value="1" />
  <input type='text' name='pojams' class='input_poljes'  value="<?php echo $_GET[pojams]?>">
   
    <br />
    <br />
 
    <input type="submit" value="Pronađi" name='nadji_oglas' class='submit_dugmici_blue' />
    </form>
			</div>
		</div>       
