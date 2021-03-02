 

<br class='clear' />
<br />
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td width="53%">

<div class='naslov_smestaj'><h1>Upisani tekstovi za kalendar</h1></div>
</td>
 <td align='right'><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_calendar&cal=<?php echo $_GET['cal']?>"><span style='padding:6px 10px;font-size:15px;'>UPIŠI NOVI TEKST ZA KALENDAR</span></a>
<div class='trakica_pozadina'></div>
</td>
<td align='right'><a href="#inline_content" class='inline'><span style='padding:6px 10px;font-size:15px;'>PRONAĐI TEKST</span></a>
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

 
if($_GET[ord]=="") $view="&ord=1"; 
if($_GET[ord]==1) 
{
$orderby=" br_pregleda ASC";
$view="&ord=2";
}
if($_GET[ord]==2) 
{
$orderby=" br_pregleda DESC";
$view="&ord=1";
}
$ByPage1=100;
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
$plun .=" AND (naslov LIKE '%".$pret."%' or opis LIKE '%".$pret."%')";

}
}
}
} 
if($_GET[tipi1]=="1")
$plun .=" AND coment=0";


 
 
 

if($_GET[id]>0) $plun .=" AND id=$id_get"; 
 
 
 
$page_cur=0;



//if($kdkd==1)
//$inpagination=urldecode(http_build_query($_POST)); else
if($search_values[1]!="")
$inpagination=urldecode($search_values[1]);
$inpagin=explode("&p=",$inpagination);
$inpagination=$inpagin[0]."&";
 
$page_cur=$sarray['p'];

 
$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  proizvodi WHERE $andidpS id>0 AND id_page=".strip_tags($_GET['cal'])."  $plun"));

$pagedResults = new Paginated($br_upisa, $ByPage1, $page_cur);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout());

$fi=mysqli_query($conn, "SELECT * FROM proizvodi WHERE $andidpS id>0 AND id_page=".strip_tags($_GET['cal'])." $plun ORDER BY  $orderby LIMIT $str,$ByPage1");

 
 ?>
<div style='width:100%;font-size:11px;padding-bottom:5px;height:25px;'>
 

<form method="get" action="" style="float:right;width:200px;">
    <input type="hidden" name="idp" value="<?php echo $_GET[idp]?>" />
    <input type="hidden" name="base" value="<?php echo $_GET[base]?>" />
    <input type="hidden" name="page" value="<?php echo $_GET[page]?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='id' class='input_poljes' style='padding:3px;float:left;width:100px;'  value="<?php echo $_GET[id]?>">
    <input type="submit" value="Pronađi ID" name='nadji_oglas' class='submit_dugmici_blues' style='float:left;width:95px;border:1px solid #888;padding:2px;margin-left:2px;' />
    </form>  
</div> 

 <div id='sorting'>
<table class='upitnici_oglasi'>
<tbody id="slickbox1">
<!--<tr>
    <th colspan="3">Lista upitnika</th>
  </tr>-->
  <tr class="yellow" id="sortid_0"> 
   <td>ID</td>
    <td>Naslov</td>

       <td>Kalendar</td>
  
    <td>Opis</td>

     <td>Kalendar termini</td>
  
   <td>Akt</td>   

    <td>Izmena / Brisanje</td>
 
  </tr>
<?php 
 
$i=0;
while($og1=mysqli_fetch_array($fi)){
if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';
$msg_id=$og1['id']; 
 
?>

<tr id="sortid_<?php echo $og1[id]?>" style='<?php echo $ba?>'>

<td style='width:30px;'><?php echo $og1['id']?></td>

<td style='width:200px;'>
<?php echo $og1["naslov"]?>


 </td>
  <td>
<?php 
if($og1["id_page"]==6)
echo "Kalendar 1";
else
echo "Kalendar 2";
?>
 </td>
 
 <td>
<?php echo $og1["opis"]?>
 </td>
 
 
<td>
<?php 
$mes= date("m");
$god= date("Y");
echo "<a href='calend_read.php?id=555&mes=$mes&god=$god&id_sobe=$og1[id]' class='iframe_cal'>Rezervisi datume</a>";
?>
</td>
 
 
<td>
<?php 
if($og1[akt]=="Y") $che="checked"; else $che="";
?>
<input type='checkbox' value='1' <?php echo $che?> onclick="akti('<?php echo $og1[id]?>', 'proizvodi')" />
</td>
 
 
<td>
<a href="<?php echo $patHA?>/index.php?base=admin&page=page_edit_calendar&id=<?php echo $og1[id]?>&tip=id_page&cal=<?php echo $_GET[cal]?>" class="edit_oglas"><img src="<?php echo $patHA?>/images/b_edit.png" /></a>&nbsp;&nbsp;
<a href="javascript:;" class="edit_oglas" onclick="obrisime(<?php echo $og1[id]?>,'delete_page')"><img src="<?php echo $patHA?>/images/b_drop.png" /></a>
</td>
 
</tr>

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
//echo $fi1[nameAds]." - $fi1[pozicija]<br />"; 
?>
<div class='pagination_o'>	
	<?php 
$hah=preg_replace("/&p=[0-9]/","",curPageURL());

 if($br_upisa>$ByPage1)
echo $pagedResults->fetchPagedNavigation("$patHA/index.php?".$inpagination."p=");
  ?>
</div>
<?php 
   
  ?>
<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
		<form method="get" action="">
    <h3>Pronađite oglas</h3>
    Ukucajte trazeni pojam za default jezik:
    <br />
    <input type="hidden" name="idp" value="<?php echo $_GET[idp]?>" />
    <input type="hidden" name="base" value="<?php echo $_GET[base]?>" />
    <input type="hidden" name="page" value="<?php echo $_GET[page]?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='pojams' class='input_poljes'  value="<?php echo $_GET[pojams]?>">
    <br />
    <br />
    
    <?php 
    if($_GET[admino]==1) $admino1="checked";
    else if($_GET[admino]==2) $admino2="checked"; else $admino="checked";
    if($_GET[tipi1]==1) $tipi1="checked";
    if($_GET[tipi2]==1) $tipi2="checked";
    
    ?> 
    Prikaži:
    <br /><input type="radio" name='admino' value='0' <?php echo $admino?>> sve upise
    <br /><input type="radio" name='admino' value='1'  <?php echo $admino1?>> aktivne
    <br /><input type="radio" name='admino' value='2' <?php echo $admino2?>> neaktivne
    <br />
  <!--  <br /><input type="checkbox" name='tipi1' value='1'  <?php echo $tipi1?>> nije dozvoljeno komentarisanje-->
    
    <br /><br />
   
    <br /><br /> 
    <br /><br />
    <input type="submit" value="Pronađi upis" name='nadji_oglas' class='submit_dugmici_blue' />
    </form>
			</div>
		</div>       
