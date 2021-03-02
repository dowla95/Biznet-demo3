<br class='clear'>
<?php 
//$orderby=" -pozicija DESC";
$orderby=" p.id DESC";
?>
 <script>
 function gog(id,tip,idp)
{
if(id!="")
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&"+tip+"="+id+"&idp="+idp
else
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>"+"&idp="+idp;
}
</script>
<?php  
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
$ByPage1=100;
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
$plun .=" AND (pl.naslov LIKE '%".$pret."%' or pl.opis LIKE '%".$pret."%')";
}
}
}
}
$vreme=date("Y-m-d");
$vreme1=date("Y-m-d H:i:s");
if($_GET['tipi1']=="1")
$plun .=" AND p.coment=0";

if($_GET['admino']==10) $plun .=" AND p.nepotpun_filter>0";
if($_GET['admino']==9) $plun .=" AND p.sponzorisano='1' AND p.sponzorisano_do > CURDATE()";
if($_GET['admino']==8) $plun .=" AND p.akcija='1' AND akcijatraje > CURDATE()";
if($_GET['admino']==7) $plun .=" AND p.vegan='1'";
if($_GET['admino']==6) $plun .=" AND p.izdvojeni='1'";
if($_GET['admino']==5) $plun .=" AND p.naslovna='1'";
if($_GET['admino']==4) $plun .=" AND p.akcija_obicna='1'";
if($_GET['admino']==3) $plun .=" AND p.novo='1'";
if($_GET['admino']==2) $plun .=" AND p.akt='0'";
if($_GET['admino']==1) $plun .=" AND p.akt='1'";
if($_GET['id']>0) $plun .=" AND p.id=$id_get"; 
if($_GET['id_kat']>0) $plun .=" AND p.katid=$id_kat_get";
if($_GET['id_page']>0) $plun .=" AND p.id_page=$id_page_get";
if($_GET['id_user']>0) $plun .=" AND p.user_id=$id_user_get";
if($_GET['idp']>0) $andidpS="p.id_page IN(".kategorije($_GET['idp'],"page",1).") AND "; 
$page_cur=0;


//if($kdkd==1)
//$inpagination=urldecode(http_build_query($_POST)); else
if($search_values[1]!="")
$inpagination=urldecode($search_values[1]);
$inpagin=explode("&p=",$inpagination);
$inpagination=$inpagin[0]."&";
$page_cur=$sarray['p'];
$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id  
WHERE p.tip=$_GET[tip] $andidpS $plun GROUP BY p.id"));
$pagedResults = new Paginated($br_upisa, $ByPage1, $page_cur);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout());
$fi=mysqli_query($conn, "SELECT * FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id 
WHERE p.tip=$_GET[tip] $andidpS $plun GROUP BY p.id ORDER BY $orderby LIMIT $str,$ByPage1");
 ?>
 
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td width="65%">
<?php 
$ova=mysqli_query($conn, "SELECT * FROM page WHERE id='$idp'");
$ova1=mysqli_fetch_assoc($ova);
if($_GET['tip']==5) $io="-o";
?>
<div class='naslov_smestaj'><h1>UPISANI PROIZVODI (<a href='export-xls.php'>exel</a>)<span style='color:#444;'><?php echo $ova1["naziv$amlang"]?></h1></div>
</td>
 <td align='right'>
 <?php
 if($settingsc['limit_pro_uk']>=$br_upisa) { ?>
 <a href="<?php echo $patHA?>/index.php?base=admin&page=add_proizvoda&tip=<?php echo $_GET['tip']?>"><span style='padding:6px 10px;font-size:15px;'>UPIŠI NOVI PROIZVOD</span></a>
<div class='trakica_pozadina'></div>
 <?php } ?>
</td>
<td align='right'><a href="#inline_content" class='inline'><span style='padding:6px 10px;font-size:15px;'>PRONAĐI PROIZVOD</span></a>
<div class='trakica_pozadina'></div>
</td>
</tr>
</table>
 
<div class="row">
<div class="col-12">
<form method="get" action="" class="float-right">
    <input type="hidden" name="idp" value="<?php echo $_GET['idp']?>" />
    <input type="hidden" name="base" value="<?php echo $_GET['base']?>" />
    <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
    <input type="hidden" name="tip" value="<?php echo $_GET['tip']?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='id' class='input_poljes' style='padding:3px;float:left;width:100px;' value="<?php echo $_GET['id']?>">
    <input type="submit" value="Pronađi ID" name='nadji_oglas' class='submit_dugmici_blues' style='float:left;width:95px;border:1px solid #888;padding:2px;margin-left:2px;' />
    </form>  
</div>
</div>
<?php 
$novo=$akcija=$neakt=$favoriti=$najpro=$vegani=$adatumska=$nepotpun=array();
$tti=mysqli_query($conn, "SELECT *, p.id as id FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id GROUP BY p.id");
while($tti1=mysqli_fetch_assoc($tti)){
if($tti1['novo']>0) $novo[]=$tti1['id'];
if($tti1['sponzorisano']>0 and $tti1['sponzorisano_do'] > $vreme) $sponz[]=$tti1['id'];
if($tti1['akcija_obicna']>0) $akcija[]=$tti1['id'];
if($tti1['nepotpun_filter']>0) $nepotpun[]=$tti1['id'];
if($tti1['akcija']>0 and $tti1['akcijatraje'] > $vreme1) $adatumska[]=$tti1['id'];
if($tti1['akt']<1) $neakt[]=$tti1['id'];
if($tti1['naslovna']>0) $favoriti[]=$tti1['id'];
if($tti1['izdvojeni']>0) $najpro[]=$tti1['id'];
if($tti1['vegan']>0) $vegani[]=$tti1['id'];
}
?>

<div class="row">
<div class="col-12">
<a class="theme-button mb-10" href="<?php echo $patHA?>/index.php?tip=5&idp=&base=admin&page=proizvodi&search=1&admino=0&nadji_oglas=Pronađi+upis">Svi proizvodi</a>
<a class="theme-button mb-10" href="<?php echo $patHA?>/index.php?tip=5&idp=&base=admin&page=proizvodi&search=1&admino=2&nadji_oglas=Pronađi+upis">Neaktivni (<?php echo count($neakt)?>)</a>
<a class="theme-button mb-10" href="<?php echo $patHA?>/index.php?tip=5&idp=&base=admin&page=proizvodi&search=1&admino=3&nadji_oglas=Pronađi+upis"><?php echo $arrwords['karakteristika2']?> (<?php echo count($novo)?>)</a>
<a class="theme-button mb-10" href="<?php echo $patHA?>/index.php?tip=5&idp=&base=admin&page=proizvodi&search=1&admino=4&nadji_oglas=Pronađi+upis"><?php echo $arrwords['karakteristika1']?> (<?php echo count($akcija)?>)</a>
<a class="theme-button mb-10" href="<?php echo $patHA?>/index.php?tip=5&idp=&base=admin&page=proizvodi&search=1&admino=8&nadji_oglas=Pronađi+upis"><?php echo $arrwords['karakteristika6']?> (<?php if(isset($adatumska)) echo count($adatumska); else echo "0";?>)</a>
<a class="theme-button mb-10" href="<?php echo $patHA?>/index.php?tip=5&idp=&base=admin&page=proizvodi&search=1&admino=5&nadji_oglas=Pronađi+upis"><?php echo $arrwords['karakteristika4']?> (<?php echo count($favoriti)?>)</a>
<a class="theme-button mb-10" href="<?php echo $patHA?>/index.php?tip=5&idp=&base=admin&page=proizvodi&search=1&admino=6&nadji_oglas=Pronađi+upis"><?php echo $arrwords['karakteristika3']?> (<?php echo count($najpro)?>)</a>
<a class="theme-button mb-10" href="<?php echo $patHA?>/index.php?tip=5&idp=&base=admin&page=proizvodi&search=1&admino=7&nadji_oglas=Pronađi+upis"><?php echo $arrwords['karakteristika5']?> (<?php echo count($vegani)?>)</a>
<a class="theme-button mb-10" href="<?php echo $patHA?>/index.php?tip=5&idp=&base=admin&page=proizvodi&search=1&admino=9&nadji_oglas=Pronađi+upis"><?php echo $arrwords['sponzorisano']?> (<?php if(isset($sponz)) echo count($sponz); else echo "0";?>)</a>
<a class="theme-button mb-10" href="<?php echo $patHA?>/index.php?tip=5&idp=&base=admin&page=proizvodi&search=1&admino=10&nadji_oglas=Pronađi+upis">Nepotpun filter (<?php echo count($nepotpun)?>)</a>
</div>
</div>

<div id='sorting' class="row">
<div class="col-12">
<table class='upitnici_oglasi'>
<tbody id="slickbox1">
<tr class="yellow" id="sortid_0"> 
<td>ID</td>
<td>Naslov</td>
<td>Slika</td>
<td>Brend</td>
<td>Slike</td>
<td>Lager</td>
<td>Akt</td>
<td>Izmena / Brisanje</td>
</tr>
<?php 
$i=0;
while($og1=mysqli_fetch_array($fi)){
if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';
$msg_id=$og1['id']; 
$zzL=mysqli_query($conn, "SELECT * FROM prol  WHERE id_text=$og1[id] AND lang='$firstlang'");
$zzL1=mysqli_fetch_array($zzL); 
?>
<tr id="sortid_<?php echo $og1['id']?>" style='<?php echo $ba?>'>

<td style='width:30px;'><?php echo $og1['id']?></td>

<td style='width:350px;'>
<a href="<?php echo $patHA?>/index.php?base=admin&page=edit_proizvoda&id=<?php echo $og1['id']?>&tip=<?php echo $_GET['tip']?>" title="<?php echo str_replace("\"","",$zzL1["naslov"])?>"><?php echo $zzL1["naslov"]?></a>
 </td>
 <td>
 <?php if(is_file("..".GALFOLDER."/$og1[slika]")){ ?>
 <a href="..<?php echo GALFOLDER?>/<?php echo $og1['slika']?>" class='group1'>
 <img src="..<?php echo GALFOLDER?>/thumb/<?php echo $og1['slika']?>" width='50' />
 </a>
 <?php } ?>
 </td>
<?php 
$ttt=2;
?> 
<td>
<?php 
$cg=mysqli_query($conn, "SELECT * FROM stavkel WHERE id_page='$og1[brend]' AND lang='$firstlang'");
$cg1=mysqli_fetch_array($cg);
echo $cg1["naziv"];
?>
</td>
<td>
<?php 
$hg=mysqli_query($conn, "SELECT * FROM slike WHERE idupisa='$og1[id]' AND tip=$_GET[tip]");
echo "<a href='$patHA/index.php?base=admin&page=subslike&idupisa=$og1[id]&id_page=0&tip=$_GET[tip]'>";
echo mysqli_num_rows($hg);
echo "</a>";
?>
</td>
<?php 
if($ttt==1)
{ 
?>
<td> 
<?php 
$ku=mysqli_query($conn, "SELECT * FROM komentari WHERE id_user1='$og1[id]'");
echo "<a href='$patHA/index.php?base=admin&page=komentari&id_ap=$og1[id]&tip=$_GET[tip]'>";
echo mysqli_num_rows($ku);
echo "</a>";
?>
</td>
<?php 
 }
?>
<td>
<?php 
if($og1['lager']==1) $che="checked"; else $che="";
?>
<input type='checkbox' value='1' <?php echo $che?> onclick="akti('<?php echo $og1['id']?>', 'lager_pro')" />
</td> 
<td>
<?php 
if($og1['akt']==1) $che="checked"; else $che="";
?>
<input type='checkbox' value='1' <?php echo $che?> onclick="akti('<?php echo $og1['id']?>', 'akti_pro')" />
</td>
<?php 
if($ttt==1)
{
?> 
<td>
<?php 
if($og1['coment']==1) $sheh="checked"; else $sheh="";
?>
<input type='checkbox' value='1' <?php echo $sheh?> onclick="akti('<?php echo $og1['id']?>', 'coment')" />
</td>
<td>
<?php 
if($og1['comentf']==1) $sheh="checked"; else $sheh="";
?>
<input type='checkbox' value='1' <?php echo $sheh?> onclick="akti('<?php echo $og1['id']?>', 'comentf')" />
</td>
<?php 
}
if($id_page!="")
$iidp="&id_page=$id_page"; else $iidp="";
?>
<td>
<a href="<?php echo $patHA?>/index.php?base=admin&page=edit_proizvoda&id=<?php echo $og1['id']?>&tip=<?php echo $_GET['tip']?>" class="olovcica"><i class="fas fa-pencil-alt"></i></a>&nbsp;&nbsp;
<a href="javascript:;" class="crvena" onclick="obrisime(<?php echo $og1['id']?>,'delete_pro')"><i class="fal fa-trash-alt"></i></a>
</td>
</tr>
<?php 
$i++;
}
?>
</tbody>
  </table>
</div>
</div>
  <?php 
//$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 order by ISNULL(pozicija), pozicija ASC");
//$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 order by -pozicija DESC");
//while($fi1=mysqli_fetch_array($fi))
//echo $fi1[nameAds]." - $fi1[pozicija]<br>"; 
?>
<div class='pagination_o'>	
	<?php 
$hah=preg_replace("/&p=[0-9]/","",curPageURL());
 if($br_upisa>$ByPage1)
echo $pagedResults->fetchPagedNavigation("$patHA/index.php?".$inpagination."p=");
  ?>
</div>
<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
		<form method="get" action="">
    <h3>Pronađite proizvod</h3>
    Ukucajte trazeni pojam:
    <br>
    <input type="hidden" name="tip" value="<?php echo $_GET['tip']?>" />
    <input type="hidden" name="idp" value="<?php echo $_GET['idp']?>" />
    <input type="hidden" name="base" value="<?php echo $_GET['base']?>" />
    <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='pojams' class='input_poljes' value="<?php echo $_GET['pojams']?>">
    <br>
    <br>
    <?php 
    $admino=$admino1=$admino2=$admino3=$admino4=$admino5=$admino6="";
    if(!isset($_GET['admino']) or isset($_GET['admino']) and $_GET['admino']==0) $admino="checked";
    if($_GET['admino']==1) $admino1="checked";
    if($_GET['admino']==2) $admino2="checked";
    if($_GET['admino']==3) $admino3="checked";
    if($_GET['admino']==4) $admino4="checked";
    if($_GET['admino']==5) $admino5="checked";
    if($_GET['admino']==6) $admino6="checked";
	if($_GET['admino']==7) $admino7="checked";
	if($_GET['admino']==8) $admino8="checked";
	if($_GET['admino']==9) $admino9="checked";
    if($_GET['tipi1']==1) $tipi1="checked";
    if($_GET['tipi2']==1) $tipi2="checked";
    ?> 
    Prikaži:
    <br><input type="radio" name='admino' value='0' <?php echo $admino?>> Sve upise
    <br><input type="radio" name='admino' value='1'  <?php echo $admino1?>> Aktivne
    <br><input type="radio" name='admino' value='2' <?php echo $admino2?>> Neaktivne
    <br><input type="radio" name='admino' value='3' <?php echo $admino3?>> <?php echo $arrwords['karakteristika2']?>
    <br><input type="radio" name='admino' value='4' <?php echo $admino4?>> <?php echo $arrwords['karakteristika1']?>
	<br><input type="radio" name='admino' value='8' <?php echo $admino8?>> <?php echo $arrwords['karakteristika6']?>
    <br><input type="radio" name='admino' value='5' <?php echo $admino5?>> <?php echo $arrwords['karakteristika4']?>
    <br><input type="radio" name='admino' value='6' <?php echo $admino6?>> <?php echo $arrwords['karakteristika3']?>
	<br><input type="radio" name='admino' value='7' <?php echo $admino7?>> <?php echo $arrwords['karakteristika5']?>
	<br><input type="radio" name='admino' value='9' <?php echo $admino9?>> <?php echo $arrwords['sponzorisano']?>
    <br>
  <!--  <br><input type="checkbox" name='tipi1' value='1'  <?php echo $tipi1?>> nije dozvoljeno komentarisanje-->
    <br><br>
    <br><br> 
    <br><br>
    <input type="submit" value="Pronađi upis" name='nadji_oglas' class='submit_dugmici_blue' />
    </form>
			</div>
		</div>