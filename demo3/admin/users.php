<?php if($tip==1)       {        $nicK="Nickname";        $koji="KORISNICI";        $koji1="NOVI KORISNIK";        $koji2="PRONAĐI KORISNIKE";        $nono="";        $novi="new_candidate";        }         else          {         $nicK="Firma";         $koji="Korisnici";         $koji1="NOVI KORISNIK";         $koji2="PRONAĐI KORISNIKA";         $nono=" style='display:none;'";         $novi="new_user";         $paketi="Paketi";         }         ?> <br class='clear'><br><table style='width:100%;' cellspacing="0" cellpadding="0"><tr><td width="40%"><div class='naslov_smestaj'><h1><?php echo $koji?></h1></div></td> <td align='right'><a href="<?php echo $patHA?>/new_candidate.php" class='edit_oglas iframes1'><span style='padding:6px 10px;font-size:15px;'><?php echo $koji1?></span></a><div class='trakica_pozadina'></div></td><td align='right'><a href="#inline_content" class='inline'><span style='padding:6px 10px;font-size:15px;'><?php echo $koji2?></span></a><div class='trakica_pozadina'></div></td></tr></table>              <?php $orderby=" user_id DESC";if($_GET['ord']=="") $view="&ord=1"; if($_GET['ord']==1) {$orderby=" br_pregleda ASC";$view="&ord=2";}if($_GET['ord']==2) {$orderby=" br_pregleda DESC";$view="&ord=1";}$ByPage1=50;if($_GET['search']==1){$plun="";$pojams=$_GET['pojams'];if($pojams!="") {$pojams=str_replace(" ","_",$pojams);$poh=explode("_",$pojams);for($t=0;$t<count($poh); $t++){ if(strlen($poh[$t])>2){$pret = addcslashes($poh[$t], '%_');//$plus .=" AND (naslov LIKE '%$pret%' OR opis LIKE '%$pret%' OR opis1 LIKE '%$pret%' OR kraj LIKE '%$pret%' OR idfirme IN (SELECT id FROM proizvodi_page WHERE naslov LIKE '%$pret%'))";//$pret = str_replace(array('š', 'ć', 'č', 'ž', 's', 'c', 'z','Š', 'Ć', 'Č', 'Ž', 'S', 'C', 'Z'), array('(š|s)', '(ć|c)', '(č|c)', '(ž|z)', '(š|s)', '(c|ć|č)', '(ž|z)','(Š|S)', '(Ć|C)', '(Č|C)', '(Ž|Z)', '(Š|S)', '(C|Ć|Č)', '(Ž|Z)'), $pret);  //$plun .=" AND (p.naziv REGEXP '[[:<:]]".$pret."[[:>:]]' OR p.opis  REGEXP '%*".$pret."[[:>:]]')";$plun .=" AND (nickname LIKE '%".$pret."%' OR ulica_broj LIKE '%".$pret."%' OR ime LIKE '%".$pret."%' OR grad LIKE '%".$pret."%' OR telefon LIKE '%".$pret."%' OR email LIKE '%".$pret."%' OR pib LIKE '%".$pret."%' OR user_id LIKE '%".$pret."%')";}}}} if($_GET['id_user']>0) $plun .=" AND user_id=$id_user_get";if($_GET['admino']==1) $plun .=" AND akt='Y'";if($_GET['admino']==2) $plun .=" AND akt='N'";if($_GET['emails']!="" and mb_eregi("@",$_GET['emails']))$plun .=" AND  email=".safe($_GET['emails']);$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users_data WHERE user_id>0 $plun"));$pagedResults = new Paginated($br_upisa, $ByPage1, $page_tr);$str=$pagedResults->fetchPagedRow();$pagedResults->setLayout(new DoubleBarLayout());$fi=mysqli_query($conn, "SELECT * FROM users_data  WHERE user_id>=0 $plun ORDER BY  $orderby LIMIT $str,$ByPage1"); ?><div style='width:100%;font-size:11px;padding-bottom:5px;height:25px;'>	<form method="get" action="" style="float:right;width:200px;">    <input type="hidden" name="base" value="<?php echo $_GET['base']?>" />    <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />    <input type="hidden" name="tip" value="<?php echo $tip?>" />    <input type="hidden" name="search" value="1" />    <input type='text' name='id_user' class='input_poljes' style='padding:3px;float:left;width:100px;'  value="<?php echo $_GET['id_user']?>">    <input type="submit" value="Pronađi ID" name='nadji_oglas' class='submit_dugmici_blues' style='float:left;width:95px;border:1px solid #888;padding:2px;margin-left:2px;' />    </form></div>  <div id='sorting'><table class='upitnici_oglasi'><tbody id="slickbox1">  <tr class="yellow" id="sortid_0">        <td>ID</td>	   <td>Status</td>	   <td class="d-none">Nickname</td>	   <td>Naziv firme</td>	   <td class="d-none">TR</td>	   <td class="d-none">Provizija</td>       <td>Porudžbine</td>       <td>PIB</td>    <td>Ime i Prezime</td>   <td>Grad (p.broj)</td>  <td>Adresa</td> <td>Telefon</td> <?php  $hahord=preg_replace("/&ord=[0-9]/","",curPageURL()); ?>  <td><a href='<?php echo $hahord?><?php echo $view?>' style='color:white;'>Email</a></td>    <td>Datum</td>   <td>Akt</td>       <td>Actions</td>  </tr><?php $i=0;while($og1=mysqli_fetch_array($fi)){if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';$msg_id=$og1['id']; if($brogs>0) $ba="background:#FBEEEE;"; else $ba=""; ?><tr id="sortid_<?php echo $og1['user_id']?>" style='<?php echo $ba?>'> <td><?php echo $og1['user_id']?> </td> <td> <?php if($og1['avatar']!="") { ?> <img src="<?php echo $patH."/avatars/".$og1['user_id']."/thumb/".$og1['avatar']?>" style="max-height:50px;"> <?php } else if($og1['firma']==1) echo '<i class="fal fa-industry-alt fa-3x"></i>'; else if($og1['firma']==0) echo '<i class="fas fa-user-tie fa-3x"></i>'; ?> </td> <td class="d-none"> <?php echo $og1['nickname']?> </td> <td> <?php echo $og1['nazivfirme'] ?> </td> <td class="d-none"> <?php echo $og1['tr'] ?> </td>  <td class="d-none"> <?php echo $og1['provizija'] ?> </td> <td> <a href='index.php?base=admin&page=porudzbine&us=<?php echo $og1['user_id']?>'> <?php  echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM porudzbine WHERE user_id=$og1[user_id]")); ?></a> </td> <td><?php echo $og1['pib']?> </td><td><?php echo $og1['ime']?> </td><td><?php echo $og1['grad']." ($og1[postanski_broj])";?></td><td><?php echo $og1['ulica_broj'];?></td><td><?php echo $og1['telefon'];?></td> <td><?php echo $og1['email']?></td><td><?php echo $og1['datum'];?></td><td><?php if($og1['akt']=="Y") $che="checked"; else $che="";?><input type='checkbox' value='1' <?php echo $che?> onclick="akti('<?php echo $og1['user_id']?>', 'akti_us')" /></td><td><?php if($og1['tip']==1) $tipis="candidates"; else $tipis="users";?><a href="<?php echo $patHA?>/change_candidates.php?id=<?php echo $og1['user_id']?>" class='olovcica'><i class="fas fa-pencil-alt"></i></a>&nbsp;&nbsp;<a href="javascript:;" class="crvena" onclick="obrisimer(<?php echo $og1['user_id']?>,'delete_users')"><i class="fal fa-trash-alt"></i></a></td></tr><?php $i++;}?></tbody>  </table>  </div>  <?php //$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 order by ISNULL(pozicija), pozicija ASC");//$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 order by -pozicija DESC");//while($fi1=mysqli_fetch_array($fi))//echo $fi1[nameAds]." - $fi1[pozicija]<br>"; ?><div class='pagination_o'>		<?php unset($_GET['p']);$inpagination=urldecode(http_build_query($_GET)); if($br_upisa>$ByPage1)echo $pagedResults->fetchPagedNavigation("index.php?".$inpagination."&p=");  ?></div><div style='display:none'>			<div id='inline_content' style='padding:10px; background:#fff;'>		<form method="get" action="">        <input type="hidden" name="tip" value="<?php echo $tip?>" />    <h3>Pronađite korisnika</h3>    Ukucajte traženi pojam:    <br>    <input type="hidden" name="base" value="<?php echo $_GET['base']?>" />    <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />    <input type="hidden" name="search" value="1" />    <input type='text' name='pojams' class='input_poljes'  value="<?php echo $_GET['pojams']?>">    <br>    <br>    Email korisnika:      <input type='text' name='emails' class='input_poljes' value="<?php echo $_GET['emails']?>" >    <br><br>    <?php     if($_GET['admino']==1) $admino1="checked";    else if($_GET['admino']==2) $admino2="checked"; else $admino="checked";    if($_GET['tipi1']==1) $tipi1="checked";    if($_GET['tipi2']==1) $tipi2="checked";    ?>     Prikaži:  <br><input type="radio" name='admino' value='0' <?php echo $admino?>> sve korisnike    <br><input type="radio" name='admino' value='1'  <?php echo $admino1?>> aktivne    <br><input type="radio" name='admino' value='2' <?php echo $admino2?>> neaktivne    <br><br>    <br><br>     <br><br>    <input type="submit" value="Pronađi" name='nadji_oglas' class='submit_dugmici_blue' />    </form>			</div>		</div>