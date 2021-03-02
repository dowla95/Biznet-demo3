    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo $patH?>">Naslovna</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pretraga proizvoda</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


   <div class="home-module-three hm-1 fix pb-40 pt-20">
       <div class="container-fluid">
<?php 
if(isset($_COOKIE['valuta']))
$idvalute=""; else
$idvalute=1;
$pojam=trim(strip_tags(urldecode($sarray['word'])));
if($pojam and $sarray['pron']==3)
{
$plun .=" AND p.link ='".$pojam."'";
}
else
if($pojam and $sarray['pron']==1)
{
$poh=explode(" ",$pojam);

for($t=0;$t<count($poh); $t++)
{
if(strlen($poh[$t])>0){
$pret = addcslashes($poh[$t], '%_');
$plus .=" AND (naslov LIKE '%$pret%' OR opis LIKE '%$pret%' OR opis1 LIKE '%$pret%' OR kraj LIKE '%$pret%' OR idfirme IN (SELECT id FROM proizvodi_page WHERE naslov LIKE '%$pret%'))";
$pret = str_replace(array('š', 'ć', 'č', 'ž', 's', 'c', 'z','Š', 'Ć', 'Č', 'Ž', 'S', 'C', 'Z'), array('(š|s)', '(ć|c)', '(č|c)', '(ž|z)', '(š|s)', '(c|ć|č)', '(ž|z)','(Š|S)', '(Ć|C)', '(Č|C)', '(Ž|Z)', '(Š|S)', '(C|Ć|Č)', '(Ž|Z)'), $pret);
$plun .=" AND (pt.naslov REGEXP '[[:<:]]".$pret."[[:>:]]' OR pt.marka  REGEXP '%*".$pret."[[:>:]]' OR p.link  REGEXP '%*".$pret."[[:>:]]' OR pt.opis  REGEXP '%*".$pret."[[:>:]]')";
}
}
}
?>
<script>
function geti(vr)
{
window.location="<?php echo $search_values[0]?>?word=<?php echo $pojam?>&pron=1&sev="+vr;
}
</script>
<?php
$sort_arr=array("","Naziv (A-Z)","Naziv (Z-A)","Cena (Rastuće)","Cena (Opadajuće)");
$mlista .="
                    <div class='shop-top-bar mb-30'>
                        <div class='row'>
                            <div class='col-md-6'>
							<div class='top-bar-left'>
							<h3>Rezultat pretrage:</h3>
							</div>
							</div>
							<div class='col-md-6'>
							<div class='top-bar-right'>
							<div class='product-short'>
                                <p>Sortiranje: </p>
";
$mlista .="<select class='nice-select' onchange='geti(this.value)'>";
$mlista .="<option value=''>Izaberi...</option>";
foreach($sort_arr as $k => $v) {
if($k>0) {
if(isset($sarray['sev']) and $sarray['sev']==$k) $sele=" selected"; else $sele="";
$mlista .="<option value='$k'$sele>$v</option>";
}
}
if(isset($sarray['sev']) and $sarray['sev']==1)
$orderby="pt.naslov ASC";
else
if(isset($sarray['sev']) and $sarray['sev']==2)
$orderby="pt.naslov DESC";
else
if(isset($sarray['sev']) and $sarray['sev']==3)
$orderby="p.cena ASC";
else
if(isset($sarray['sev']) and $sarray['sev']==4)
$orderby="p.cena DESC";
else
$orderby="p.cena DESC";
$mlista .="</select>";
$mlista .="					</div>
							</div>
                            </div>
                        </div>
                    </div>
";
$mlista .='			<div id="load-lista">';
$mlista .='				<div class="module-four-wrapper custom-seven-column">';


$slik=mysqli_query($conn, "SELECT slika FROM page WHERE id='3'");
$slik1=mysqli_fetch_assoc($slik);
if($slik1['slika']!="") {
$mlista .='
                        <div class="col col-2 mb-30">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img src="'.$patH1.'/'.GALFOLDER.'/thumb/'.$slik1["slika"].' " alt="">
                                </div>
                            </div>
                        </div>
';
}
if(isset($sarray['sev']) and $sarray['sev']>0) $sort="&sev=".$sarray['sev']; else $sort="";
if(!isset($sarray['p'])) $ipe=0; else $ipe=$sarray['p'];
$ByPage1=12;
$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1   $plun GROUP BY p.id"));
$cce=ceil($br_upisa/$ByPage1);
if($ipe>0) $ipes=$ipe; else $ipes=1;
$str = ($ipes-1)*$ByPage1;

$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1  $plun GROUP BY p.id ORDER BY -p.pozicija DESC, $orderby LIMIT $str,$ByPage1");
while($az1=mysqli_fetch_array($az))
{
$brend=mysqli_query($conn, "SELECT * FROM stavkel WHERE id_page=$az1[brend] AND lang='$lang'");
$brend1=mysqli_fetch_assoc($brend);
if($az1['lager']==1) {
$ukorpu="onclick=\"displaySubs($az1[id],'yes')\"";
$ispis="Dodaj u korpu";
}
else {
$ukorpu="";
$ispis="Nije dostupno";
}
$zalink=$all_links[3];

$mlista .='
                        <div class="col mb-30">
                            <div class="product-item">
								<div class="product-thumb">
                                    <a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'">
                                        <img class="pri-img" src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika'].'" alt="'.$az1['altslike'].'" title="'.$az1['titleslike'].'">
';
if($az1['slika1']!="") $mlista .='<img class="sec-img" src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika1'].'" alt="'.$az1['altslike'].'" title="'.$az1['titleslike'].'">';
$mlista .='
                                    </a>
									<div class="box-label">
'; if($az1['novo']==1) { $mlista .='
                                        <div class="label-product label_new">
                                            <span>new</span>
                                        </div>
'; } $mlista .='
										
';
if($az1['cena1']>0 and $az1['akcija']==1) {
$proc=100*$az1['cena']/$az1['cena1'];
$procenat=-(100-round($proc))."%";
$mlista .='<div class="label-product label_sale"><span>'.$procenat.'</span></div>';
}
$mlista .='
									</div>
                                    <div class="action-links">
                                        <a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'"><i class="fal fa-eye"></i></a>
';
if(isset($lz_niz) and in_array($az1['ide'],$lz_niz))
                  $mlista .='<a title="Izbaci iz liste" href="'.$patH.'/include/ulistu-zelja-del.php?pro='.$az1['ide'].'"><i class="far am-slom-srce"></i></a>';
else $mlista .='<a title="U listu zelja" href="'.$patH.'/include/ulistu-zelja.php?pro='.$az1['ide'].'"><i class="far fa-heart"></i></a>';

if($_SESSION['uporedi'][$az1["ide"]]==$az1["ide"])
         $mlista .='<span id="up'.$az1["ide"].'"><a title="Ukloni iz liste" href="'.$patH1.'/'.$all_links[11].'/?ukloni='.$az1["id"].'"><i class="far fa-remove"></i></a></span>';
         else $mlista .='<span id="up'.$az1["ide"].'"><a title="Uporedi" href="javascript:;" onclick="uporedi('.$az1["ide"].')"><i class="fal fa-balance-scale"></i></a></span>';

$mlista .='
									</div>
                                </div>
								<div class="product-caption">
									<div class="product-name">
										<h4><a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'">'.$az1['naslov'].'</a></h4>
									</div>
									<div class="price-box">
';
if($az1['cena']!=0) {
if($az1['cena1']>0 and $az1['akcija']==1)
$mlista .='
<span class="regular-price">Cena: <span class="special-price">'.number_format($az1['cena'],0,",",".").'</span></span>
<span class="old-price"><del>'.number_format($az1['cena1'],0,",",".").'</del></span>
';
else
$mlista .='
<span class="regular-price">Cena: '.number_format($az1['cena'],0,",",".").'</span>
';
}
$mlista .='
										</div>
								<a class="btn-cart b3" href="javascript:;" '.$ukorpu.' title="Dodaj u korpu">'.$ispis.'</a>
									</div>
								</div>
							</div>
';

}
if($br_upisa>$ByPage1)
{ $ii=$i+1;
$mlista .='
<div class="col-12">
	<div class="pagination-section mb-md-30 mb-sm-30">
	<ul class="pagination">';
$mlista .='<li><a href="">&laquo;</a></li>';
for($s=0; $s<$cce; $s++) {
	$ss=$s+1;
    if($ipe==$ss or ($ipe==0 and $ss==1))
    $active="class='active'"; else $active='';
$mlista .='<li '.$active.'><a href="'.$patH1.'/?word='.$pojam.'&pron='.strip_tags($sarray['pron']).$sort.'&p='.$ss.'" class="ch" >'.$ss.'</a></li>';
}
$mlista .='<li><a href="">&raquo;</a></li>';
$mlista .='</ul>
	</div>
</div>';
}
          echo $mlista;
          ?>
					</div>
<?php if(strlen($page1['podnaslov'])>10) echo "<p>".$page1['podnaslov']."</p>"; ?>
						</div>
					</div>
		</div>