<br class='clear' /><br /><table style='width:100%;' cellspacing="0" cellpadding="0"><tr><td width="40%"><div class='naslov_smestaj'><h1>Kreirani oglasi</h1></div></td><td align='right'><a href="#inline_content" class='inline'><span style='padding:6px 10px;font-size:15px;'>PRONAĐI</span></a><div class='trakica_pozadina'></div></td><!--<td> <a href='<?php echo $patH1?>/korisnik/novi-oglas/'  class='link_dugme_plavo'><span style='padding:6px 10px;'>UPIŠITE NOVI SMEŠTAJ</span></a><div class='trakica_pozadina'></div></td>--></tr></table>              <?php $orderby=" id DESC";if($_GET['paket']>0 and $_GET['searc']=="") {?><script type="text/javascript" src="<?php echo $patHA?>/js/jquery-ui-1.8.23.custom.min.js"></script> <script>    $(document).ready(function(){    $("#sorting .upitnici_oglasi tbody").sortable({      stop: function(){        qString = $(this).sortable("serialize");   //alert(qString)       // $('#msg').fadeIn("slow");        //$('#msg').html("Updating...");        $.ajax({          type: "POST",      url: "<?php echo $patHA?>/save_position.php?table=oglasi",          data: qString,          cache: false,          beforeSend: function(html){       $("#sorting .upitnici_oglasi tbody").css("opacity", "0.6");          },          success: function(html){          $("#sorting .upitnici_oglasi tbody").css("opacity", "1.0")         }        });      }    });        //$("#sorting .ul").disableSelection();  });   </script><style>#sorting table tr{cursor:move;}</style><?php  $orderby=" pozicija ASC";   }if($_GET['ord']=="") $view="&ord=1"; if($_GET['ord']==1) {$orderby=" br_pregleda ASC";$view="&ord=2";}if($_GET['ord']==2) {$orderby=" br_pregleda DESC";$view="&ord=1";}$ByPage1=50;if($_GET['search']==1){$plun="";$pojams=$_GET['pojams'];if($pojams!="") {$pojams=str_replace(" ","_",$pojams);$poh=explode("_",$pojams);for($t=0;$t<count($poh); $t++){ if(strlen($poh[$t])>2){$pret = addcslashes($poh[$t], '%_');//$plus .=" AND (naslov LIKE '%$pret%' OR opis LIKE '%$pret%' OR opis1 LIKE '%$pret%' OR kraj LIKE '%$pret%' OR idfirme IN (SELECT id FROM proizvodi_page WHERE naslov LIKE '%$pret%'))";//$pret = str_replace(array('š', 'ć', 'č', 'ž', 's', 'c', 'z','Š', 'Ć', 'Č', 'Ž', 'S', 'C', 'Z'), array('(š|s)', '(ć|c)', '(č|c)', '(ž|z)', '(š|s)', '(c|ć|č)', '(ž|z)','(Š|S)', '(Ć|C)', '(Č|C)', '(Ž|Z)', '(Š|S)', '(C|Ć|Č)', '(Ž|Z)'), $pret);  //$plun .=" AND (p.naziv REGEXP '[[:<:]]".$pret."[[:>:]]' OR p.opis  REGEXP '%*".$pret."[[:>:]]')";$plun .=" AND (nameAdsslo LIKE '%".$pret."%')";}}}} if($_GET['akt2']!="")$plun .=" AND akt2=1";if($_GET['tipi1']!="")$plun .=" AND akt1=1";if($_GET['tipi2']!="")$plun .=" AND sms=1";if($_GET['admino']==1) $plun .=" AND akt='Y'";if($_GET['admino']==2) $plun .=" AND akt='N'";if($_GET['emails']!="" and mb_eregi("@",$_GET['emails'])){$plun .=" AND user_id IN (SELECT user_id FROM users WHERE email=".safe($_GET[emails]).")";} if($_GET['id']>0) $plun .=" AND id=$id_get"; if($_GET['id_user']>0) $plun .=" AND user_id=$id_user_get";if($_GET['id_city']>0) $plun .=" AND id_city=$id_city_get";if($_GET['paket']!="") $plun .=" AND paket=$id_paket_get";if($_GET['sms']==1) $plun .=" AND sms=1";if($_GET['akt']==1) $plun .=" AND akt='N'";if($_GET['akt1']==1) $plun .=" AND akt1=1";$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 $plun"));$pagedResults = new Paginated($br_upisa, $ByPage1, $page_tr);$str=$pagedResults->fetchPagedRow();$pagedResults->setLayout(new DoubleBarLayout());$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 $plun ORDER BY  $orderby LIMIT $str,$ByPage1"); ?><div style='width:100%;font-size:11px;padding-bottom:5px;height:25px;'>imate ukupno <b><?php echo $uk_oglasa1?></b> oglasa   |<b><a href="?base=admin&page=oglasi&akt=1"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM oglasi WHERE akt='N'"));?> oglasa </a></b> su neaktivni  | <?php for($i=0;$i<=$settings['number_packets'];$i++){$paks=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM oglasi WHERE akt='Y' AND paket=$i"));echo "<a href='?base=admin&page=oglasi&paket=$i' >paket $i ($paks)</a>&nbsp;&nbsp; ";}$home=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM oglasi WHERE akt2=1"));$sms=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM oglasi WHERE sms=1"));?><a href="?base=admin&page=oglasi&akt2=1">Home (<?php echo $home?>)</a>&nbsp;<a href="?base=admin&page=oglasi&sms=1">SMS (<?php echo $sms?>)</a><form method="get" action="" style="float:right;width:200px;">    <input type="hidden" name="base" value="<?php echo $_GET[base]?>" />    <input type="hidden" name="page" value="<?php echo $_GET[page]?>" />    <input type="hidden" name="search" value="1" />    <input type='text' name='id' class='input_poljes' style='padding:3px;float:left;width:100px;'  value="<?php echo $_GET[id]?>">    <input type="submit" value="Pronađi ID" name='nadji_oglas' class='submit_dugmici_blues' style='float:left;width:95px;border:1px solid #888;padding:2px;margin-left:2px;' />    </form>  </div>  <div id='sorting'><table class='upitnici_oglasi'><tbody id="slickbox1"><!--<tr>    <th colspan="3">Lista upitnika</th>  </tr>-->  <tr class="yellow" id="sortid_0">     <td>Naziv oglasa</td>         <td>ID</td>   <td>Mesto</td>  <td>Tip</td> <td>Email</td>  <?php  $hahord=preg_replace("/&ord=[0-9]/","",curPageURL()); ?> <td><a href='<?php echo $hahord?><?php echo $view?>' style='color:white;'>View</a></td>    <td>Poruke</td>    <td>Koment</td>    <td>Paket</td>   <td>Akt</td>      <td>Home</td>   <td>SMS</td>   <td>Show</td>    <td>Actions</td>  </tr><?php $i=0;while($og1=mysqli_fetch_array($fi)){if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';$msg_id=$og1['id']; ?><tr id="sortid_<?php echo $og1['id']?>" style='<?php echo $ba?>'><td><a href="<?php echo $patH1?>/<?php echo replace_implode1($og1['nameAdsslo'])?>-<?php echo $og1['id']?>.html" target="_blank"  title="<?php echo str_replace("\"","",$og1['nameAdsslo'])?>"><?php echo $og1['nameAdsslo']?></a><br /></td>  <td><?php echo $og1['id']?> </td><td><?php $gg=mysqli_query($conn, "SELECT * FROM city_name WHERE id='$og1[id_city]'");$gg1=mysqli_fetch_array($gg);echo $gg1['nazivslo'];?></td><td><?php $cg=mysqli_query($conn, "SELECT * FROM categories WHERE id='$og1[id_cat]'");$cg1=mysqli_fetch_array($cg);echo $cg1['nazivslo'];?></td><td><?php $ug=mysqli_query($conn, "SELECT * FROM users WHERE user_id='$og1[user_id]'");$ug1=mysqli_fetch_array($ug);$brog=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM oglasi WHERE user_id='$og1[user_id]'"));echo $ug1['email']." (<a href='?base=admin&page=oglasi&id_user=$og1[user_id]'>$brog)";
?>
</td>
<td><?php echo $og1['br_pregleda']?></td>
<td>
<?php 
$hg=mysqli_query($conn, "SELECT * FROM kontakt WHERE id_oglasa='$og1[id]' AND id_por=0");

echo "<a href='$patHA/index.php?base=admin&page=poruke&id=$og1[id]'>";
echo mysqli_num_rows($hg);
echo "</a>";
?>
</td>
<td>
<?php 
$ku=mysqli_query($conn, "SELECT * FROM comments WHERE id_pro='$og1[id]' AND tip=0");
echo "<a href='$patHA/index.php?base=admin&page=comments&id_ap=$og1[id]&tip=0'>";
echo mysqli_num_rows($ku);
echo "</a>";
?>
</td>
<td>
<select id="paket" onchange="paket(this.value,'<?php echo $og1[id]?>')">
<?php 
for($i=0;$i<=$settings['number_packets'];$i++)
{
if($og1[paket]==$i) $spak="selected"; else $spak="";
echo "<option value='$i-$og1[id]' $spak>paket $i</option>";
}
?>
</select>
</td>
<td>
<?php 
if($og1[akt]=="Y") $che="checked"; else $che="";
?>
<input type='checkbox' value='1' <?php echo $che?> onclick="akti('<?php echo $og1[id]?>', 'akti')" />
</td>
<td>
<?php 
if($og1[akt2]==1) $cheh="checked"; else $cheh="";
?>
<input type='checkbox' value='1' <?php echo $cheh?> onclick="akti('<?php echo $og1[id]?>', 'oglasi_konurisanje')" />
</td>
<td>
<?php 
if($og1[sms]==1) $sheh="checked"; else $sheh="";
?>
<input type='checkbox' value='1' <?php echo $sheh?> onclick="akti('<?php echo $og1[id]?>', 'sms')" />
</td>

<td>
<?php 
?>
<a href='<?php echo $patHA?>/settings_show.php?id=<?php echo $og1[id]?>&tip=1' class='iframeB'><?php 
echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$og1[id] AND tip=1"));?></a>
</td> 
<td>
<a href="<?php echo $patHA?>/index.php?base=admin&page=izmena-oglas&id=<?php echo $og1[id]?>&korak=1" class="edit_oglas"><img src="<?php echo $patHA?>/images/b_edit.png" /></a>&nbsp;&nbsp;
<a href="javascript:;" class="edit_oglas" onclick="obrisime(<?php echo $og1[id]?>,'delete_oglas')"><img src="<?php echo $patHA?>/images/b_drop.png" /></a>
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
    <h3>Pronađite oglas</h3>
    Ukucajte pojam iz naziva oglasa:
    <br />
    <input type="hidden" name="base" value="<?php echo $_GET[base]?>" />
    <input type="hidden" name="page" value="<?php echo $_GET[page]?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='pojams' class='input_poljes'  value="<?php echo $_GET[pojams]?>">
    <br />
    <br />
    Email korisnika: 
     <input type='email' name='emails' class='input_poljes' value="<?php echo $_GET[emails]?>" >
    <br />
    <br />
   Mesto:<br />
    <select name="id_city" class='selecte'>
    <option value=''>----</option>
    <?php 
$gg=mysqli_query($conn, "SELECT * FROM city_name order by naziv asc");
while($gg1=mysqli_fetch_array($gg))
{
if($id_city_get==$gg1[id]) $tcity="selected"; else $tcity="";
    echo "<option value='$gg1[id]' $tcity>".$gg1["naziv$lang"]."</option>";
}
    ?>
    </select>
    <br /><br />
    Paket<br />
    <select  name="paket" class='selecte'>
    <option value=''>---</option>
<?php 
for($i=0;$i<=$settings['number_packets'];$i++)
{
if($_GET['paket']==$i and $_GET['paket']!="") $spak="selected"; else $spak="";
echo "<option value='$i' $spak>paket $i</option>";
}
?>
</select>
    <br /><br />
    <?php 
    if($_GET['admino']==1) $admino1="checked";
    else if($_GET['admino']==2) $admino2="checked"; else $admino="checked";
    if($_GET['tipi1']==1) $tipi1="checked";
    if($_GET['tipi2']==1) $tipi2="checked";
    ?>     Prikaži:    <br /><input type="radio" name='admino' value='0' <?php echo $admino?>> sve oglase    <br /><input type="radio" name='admino' value='1'  <?php echo $admino1?>> aktivne    <br /><input type="radio" name='admino' value='2' <?php echo $admino2?>> neaktivne    <br />    <br /><input type="checkbox" name='tipi1' value='1'  <?php echo $tipi1?>> home    <br /><input type="checkbox" name='tipi2' value='1' <?php echo $tipi2?>> sms    <br /><br />    <br /><br />     <br /><br />    <input type="submit" value="Pronađi" name='nadji_oglas' class='submit_dugmici_blue' />    </form>			</div>		</div>