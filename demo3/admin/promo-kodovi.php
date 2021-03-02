<?php if($tip==1)
       {
        $nicK="Nickname";
        $koji="KORISNICI";
        $koji1="GENERISI KOD";
        $koji2="PRONAĐI KORISNIKE";
        $nono="";
        $novi="new_candidate";
        }
         else 
         {
         $nicK="Firma";
         $koji="SVI KODOVI";
         $koji1="GENERISI KOD";
         $koji2="PRONAĐI KOD";
         $nono=" style='display:none;'";
         $novi="new_user";
         $paketi="Paketi";
         }
         ?> 
<br class='clear' />
<br />
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td width="40%">
<div class='naslov_smestaj'><h1><?php echo $koji?></h1></div>
</td>
 <td align='right'><a href="<?php echo $patHA?>/novi-kod.php" class='edit_oglas iframes1'><span style='padding:6px 10px;font-size:15px;'><?php echo $koji1?></span></a>
<div class='trakica_pozadina'></div>
</td>
<td align='right'><a href="#inline_content" class='inline'><span style='padding:6px 10px;font-size:15px;'><?php echo $koji2?></span></a>
<div class='trakica_pozadina'></div>
</td>
</tr>
</table>              

<?php 
$orderby=" id DESC";
if($_GET['ord']=="") $view="&ord=1"; 
if($_GET['ord']==1) 
{
$orderby=" br_pregleda ASC";
$view="&ord=2";
}
if($_GET['ord']==2) 
{
$orderby=" br_pregleda DESC";
$view="&ord=1";
}
$ByPage1=50;
if($_GET['search']==1)
{
$plun="";
$pojams=$_GET['pojams'];
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
$plun .=" AND (kod LIKE '%".$pret."%' OR vrednost_koda LIKE '%".$pret."%' OR min_potrosnja LIKE '%".$pret."%' OR vazi_do LIKE '%".$pret."%')";
}
}
}
} 
if($_GET['id']>0) $plun .=" AND id=$id_get";
if($_GET['admino']==1) $plun .=" AND istekao=1";
if($_GET['admino']==2) $plun .=" AND istekao=0";
//if($_GET[adminos]==1) $plun .=" AND iskoriscen=1";
if($_GET['adminos']==2) $plun .=" AND vazi_do>'".date("Y-m-d H:i:s")."'";
if($_GET['adminos']==1) $plun .=" AND vazi_do<='".date("Y-m-d H:i:s")."'";

//$plun .=" AND iskoriscen=0";

$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM promo_kodovi WHERE id>0 $plun"));
$pagedResults = new Paginated($br_upisa, $ByPage1, $page_tr);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout());
$fi=mysqli_query($conn, "SELECT * FROM promo_kodovi  WHERE id>0 $plun ORDER BY  $orderby LIMIT $str,$ByPage1");
?>
<div style='width:100%;font-size:11px;padding-bottom:5px;height:25px;float:left;'>
	<form method="get" action="" style="float:right;width:200px;">
    <input type="hidden" name="base" value="<?php echo $_GET['base']?>" />
    <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
    <input type="hidden" name="tip" value="<?php echo $tip?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='id' class='input_poljes' style='padding:3px;float:left;width:100px;'  value="<?php echo $_GET['id']?>">
    <input type="submit" value="Pronađi ID" name='nadji_oglas' class='submit_dugmici_blues' style='float:left;width:95px;border:1px solid #888;padding:2px;margin-left:2px;' />
    </form>  
</div> 
<div style='float:left;width:100%;font-size:11px;padding-bottom:5px;height:25px;text-align:right;'>
 <a href="export-xls-promo-kodovi.php?exportuj_sve=1" style="float:left;">Exportuj u excel celu tabelu</a>
 <span id="izmi" style="display:none; position:relative;top:-2px;">
 <form method="post" id="obrisi-ovo" action="" style="display:inline;margin:0px;padding:0px">
 <input type="hidden" id="obrisi_ovo" name="obrisi_ovo" value="">
 <a href="" style="color:red;" class="obrisi-ovo"><b>x</b> obriši označeno</a></form> |
 <form method="post" id="exportuj-ovo" action="export-xls-promo-kodovi.php" style="display:inline;margin:0px;padding:0px">
 <input type="hidden" id="exportuj_ovo" name="exportuj_ovo" value="">
 <a href="" class="exportuj-ovo">exportuj u excel označeno</a></form> | </span>
<label><input type="checkbox" id="checkAll" style="position:relative;top:2px;"> Izaberite sve</label>
</div>
 <div id='sorting'>
<table class='upitnici_oglasi'>
<tbody id="slickbox1">
  <tr class="yellow" id="sortid_0"> 
       <td>ID</td>
       <td>Promo Kod</td>
       <!--<td>Br. kodova</td>-->
    <td>Vrednost koda</td>
  <td>Min. potrošnja</td>
 <td>Višekratni</td>
  <td>Iskorišćen</td>
    <td>Vazi do</td>
   <td>Kategorije</td>
    <td>Blok</td>
    <td>Označi</td>
<td>Brisanje</td>
  </tr>
<?php 
$i=0;
while($og1=mysqli_fetch_array($fi)){
if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';
$msg_id=$og1['id']; 
if($brogs>0) $ba="background:#FBEEEE;"; else $ba=""; 
?>
<tr id="sortid_<?php echo $og1['id']?>" style='<?php echo $ba?>'>
 <td>
<?php echo $og1['id']?>
 </td>
 <td>
<?php echo $og1['kod']?></a>
 </td>
 <!--<td>
<?php echo $og1['broj_kodova']?>
 </td>-->
<td>
<?php 
echo $og1['vrednost_koda'];
if($og1['tip_koda']==1) echo " rsd"; else echo " %";
?>
 </td>
<td>
<?php 
echo $og1['min_potrosnja'];


?>
</td>
<td>
<?php 
if($og1['upotrebljivost']==1) $ache="checked"; else $ache="";
if($og1['vazi_do']>=date("Y-m-d H:i:s")) $boja="green"; else $boja="red";
?>
<input type='checkbox' value='1' <?php echo $ache?> onclick="aktit('<?php echo $og1['id']?>', 'id', 'promo_kodovi-upotrebljivost')" />
</td>
<td>
<?php 
if($og1['upotrebljivost']==1)
echo $og1['iskoriscen'];
else
if($og1['iskoriscen']==1 and $og1['upotrebljivost']==0)
echo "da";
else
echo $iskor= "ne";
?>

</td>
<td style="color:<?php echo $boja?>">
<?php 
echo $og1['vazi_do'];
?>
</td> 
<td><?php 
$kniz=array();
$k_arr=explode(",", $og1['kategorije']);
foreach($kar_arr as $k => $v){
if(in_array($k,$k_arr))
$kniz[] = $kar_arr[$k];
}
echo implode(", ", $kniz);
?></td>
<?php 
$eee=2;
if($eee==1) {
?>
<td>
<?php 
if($og1['iskoriscen']==1) $ache1="checked"; else $ache1="";
?>
<input type='checkbox' value='1' <?php echo $ache1?> onclick="aktit('<?php echo $og1['id']?>', 'id', 'promo_kodovi-iskoriscen')" />
</td>
<?php } ?>
<td>
<?php 
if($og1['istekao']==1) $ache2="checked"; else $ache2="";
?>
<input type='checkbox' value='1' <?php echo $ache2?> onclick="aktit('<?php echo $og1['id']?>', 'id', 'promo_kodovi-istekao')" />
</td>
<td>
<input type='checkbox' name="oznaci[]" class='oznaci' value='<?php echo $og1['id']?>' />
</td>
<td>
<a href="javascript:;" class="edit_oglas" onclick="obrisime(<?php echo $og1['id']?>,'promo_kodovi_del')"><img src="<?php echo $patHA?>/images/b_drop.png" /></a>
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
//while($og1=mysqli_fetch_array($fi))
//echo $og1[nameAds]." - $og1[pozicija]<br />";
?>
<div class='pagination_o'>	
	<?php 
unset($_GET['p']);
$inpagination=urldecode(http_build_query($_GET));
 if($br_upisa>$ByPage1)
echo $pagedResults->fetchPagedNavigation("index.php?".$inpagination."&p=");
  ?>
</div>
<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
		<form method="get" action="">
        <input type="hidden" name="tip" value="<?php echo $tip?>" />
    <h3>Pronađite korisnika</h3>
    Ukucajte traženi pojam:
    <br />
    <input type="hidden" name="base" value="<?php echo $_GET['base']?>" />
    <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='pojams' class='input_poljes'  value="<?php echo $_GET['pojams']?>">
    <br />
    <br />
    Email korisnika: 
     <input type='text' name='emails' class='input_poljes' value="<?php echo $_GET['emails']?>" >
    <br /><br />
   <?php 
    if($_GET['admino']==1) $admino1="checked";
    else if($_GET['admino']==2) $admino2="checked"; else $admino="checked";
    if($_GET['tipi1']==1) $tipi1="checked";
    if($_GET['tipi2']==1) $tipi2="checked";
if($_GET['adminos']==1) $adminos1="checked";
    else if($_GET['adminos']==2) $adminos2="checked"; else $adminos="checked";
    ?> 
    Istekle / aktivne:
  <br /><input type="radio" name='admino' value='0' <?php echo $admino?>> sve
    <br /><input type="radio" name='admino' value='1'  <?php echo $admino1?>> istekle
    <br /><input type="radio" name='admino' value='2' <?php echo $admino2?>> aktivne
    <br /><br />
     Iskoriscene / aktivne:
  <br /><input type="radio" name='adminos' value='0' <?php echo $adminos?>> sve
    <br /><input type="radio" name='adminos' value='1'  <?php echo $adminos1?>> iskoriscene
    <br /><input type="radio" name='adminos' value='2' <?php echo $adminos2?>> aktivne
    <br /><br />
    <br /><br /> 
    <br /><br />
    <input type="submit" value="Pronađi" name='nadji_oglas' class='submit_dugmici_blue' />
    </form>
			</div>
		</div>