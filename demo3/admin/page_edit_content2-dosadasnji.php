<?php include("tiny_mce.php");$AL=mysqli_query($conn, "SELECT * FROM pages_text_lang  WHERE id_text=$id_get AND lang='$firstlang'");$AL1=mysqli_fetch_assoc($AL);?><table class='table-responsive' cellspacing="0" cellpadding="0"><tr><td width="85%">	<div class='naslov_smestaj_padd'><h1 class="border_ha">IZMENA TEKSTA - <span style='color:#444;'><?php echo $AL1['naslov']?></span></h1></div></td> <td align='right'><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content2&idp=<?php echo $_GET['idp']?>"><span style='padding:6px 10px;font-size:15px;'>UPISANI TEKSTOVI</span></a><div class='trakica_pozadina'></div></td></tr></table><?php $zz=mysqli_query($conn, "SELECT * FROM pages_text  WHERE id=$id_get");$zz1=mysqli_fetch_array($zz);$kat_arr=array();$zzC=mysqli_query($conn, "SELECT * FROM pages_text_kat  WHERE id_text=$id_get");while($zzC1=mysqli_fetch_array($zzC))  {$kat_arr[]=$zzC1['id_cat'];}?> <div class="row mb-20"><div class="col-12"><div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse"><a class="card-title">Unosi ovog tipa na istoj stranici</a></div><div id="collapse" class="card-body collapse"><ul class='ul'><?php $az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide        FROM pages_text p        INNER JOIN pages_text_lang pt ON p.id = pt.id_text                WHERE pt.lang='$firstlang' AND p.tipus=2 AND  p.id_page=$zz1[id_page] ORDER BY -p.pozicija DESC, pt.naslov ASC"); while($az1=mysqli_fetch_array($az)){?><li id='<?php echo $az1['ide']?>' class='pr'>                    <a href="<?php echo $patHA?>/index.php?base=admin&page=page_edit_content2&id=<?php echo $az1['ide']?>&tip=<?php echo $_GET['tip']?>"><?php echo $az1["naslov"]?> &nbsp; &nbsp;<i class="fas fa-pencil-alt olovcica"></i></a></li><?php }?></ul></div></div></div><div class="row"><div class="col-12"><?php if($msr!="")echo "<div class='infos1'><div>$msr</div></div>";?><form method="post" action="" enctype="multipart/form-data"><span>Dodeli upis stranici</span><select name="id_page" class='selecte'><option value=''>---</option>                                        <?php $tz = mysqli_query($conn, "SELECT p.*, pt.*        FROM page p        INNER JOIN pagel pt ON p.id = pt.id_page                WHERE pt.lang='$firstlang' AND  nivo=1  AND id_cat=0 ORDER BY p.position ASC");   while($tz1=mysqli_fetch_array($tz))     {$hz = mysqli_query($conn, "SELECT p.*, pt.*        FROM page p        INNER JOIN pagel pt ON p.id = pt.id_page                WHERE pt.lang='$firstlang' AND  id_parent=$tz1[id_page]  AND id_cat=0 ORDER BY p.position ASC");        if($zz1['id_page']==$tz1['id_page']) $sel="selected"; else $sel="";     if(mysqli_num_rows($hz)>0) $dis="disabled"; else $dis="";                      ?><option value="<?php echo $tz1['id_page']?>" <?php echo $sel?>><?php echo $tz1["naziv"]?></option><?php while($hz1=mysqli_fetch_array($hz))     {$rz = mysqli_query($conn, "SELECT p.*, pt.*        FROM page p        INNER JOIN pagel pt ON p.id = pt.id_page                WHERE pt.lang='$firstlang' AND  id_parent=$hz1[id_page]  AND id_cat=0 ORDER BY p.position ASC");      if($zz1['id_page']==$hz1['id_page']) $sel="selected"; else $sel="";                        if(mysqli_num_rows($rz)>0) $dis="disabled"; else $dis="";      ?><option value="<?php echo $hz1['id_page']?>" <?php echo $sel?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option><?php    while($pz1=mysqli_fetch_array($pz))     {     if($zz1['id_page']==$pz1['id_page']) $sel="selected"; else $sel="";                  ?><option value="<?php echo $pz1['id_page']?>" <?php echo $sel?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pz1["naziv"]?></option><?php }}}?></select>             </div></div><div class="row mb-20"><div class="col-12"><div id="cats"><?php if($zz1['id_page']>0 and $hide_cats==1){$fsi=mysqli_query($conn, "SELECT * FROM  categories_group WHERE akt=1 AND tip=0 AND id IN (SELECT id_kat FROM pages_kat WHERE id_page=".$zz1['id_page'].") ORDER BY name ASC");while($fsi1=mysqli_fetch_assoc($fsi)){$tz = mysqli_query($conn, "SELECT p.*, pt.*        FROM page p        INNER JOIN pagel pt ON p.id = pt.id_page                WHERE pt.lang='$firstlang' AND  nivo=1  AND id_cat=$fsi1[id] ORDER BY p.position ASC");if(mysqli_num_rows($tz)>0){        ?> <span>Dodeli upis - <?php echo $fsi1['name']?></span><select name="kat[]" class='selecte'><option value=''>---</option>                   <?php while($tz1=mysqli_fetch_array($tz))     {$hz = mysqli_query($conn, "SELECT p.*, pt.*        FROM page p        INNER JOIN pagel pt ON p.id = pt.id_page                WHERE pt.lang='$firstlang' AND  id_parent=$tz1[id_page]   ORDER BY p.position ASC");            if(in_array($tz1['id_page'],$kat_arr)) $sel="selected"; else $sel="";    if(mysqli_num_rows($hz)>0) $dis="disabled"; else $dis="";                       ?><option value="<?php echo $tz1['id_page']?>" <?php echo $sel?> <?php echo $dis?>><?php echo $tz1["naziv"]?></option><?php    while($hz1=mysqli_fetch_array($hz))     {     $rz = mysqli_query($conn, "SELECT p.*, pt.*        FROM page p        INNER JOIN pagel pt ON p.id = pt.id_page                WHERE pt.lang='$firstlang' AND  id_parent=$hz1[id_page]  ORDER BY p.position ASC");          if(in_array($hz1['id_page'],$kat_arr)) $sel="selected"; else $sel="";     if(mysqli_num_rows($rz)>0) $dis="disabled"; else $dis="";     ?><option value="<?php echo $hz1['id_page']?>" <?php echo $sel?> <?php echo $dis?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option><?php    while($pz1=mysqli_fetch_array($pz))     {     if(in_array($pz1['id_page'],$kat_arr)) $sel="selected"; else $sel="";     ?><option value="<?php echo $pz1['id_page']?>" <?php echo $sel?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pz1["naziv"]?></option> <?php }}}?></select><?php }}}?></div><?php if(isset($_POST['link'])) $link=$_POST['link']; else $link=$zz1['link'];?><input type="hidden" name='link' value="<?php echo $link;?>" class='selecte' style='' /><?php $idu=$zz1['id_page']; if($zz1['id_page']>0){$zap=mysqli_query($conn, "SELECT * FROM page WHERE id=$idu");$zap1=mysqli_fetch_assoc($zap); }?></div></div><div class="row mb-20"><div class="col-12"><div class="ui-tabs"><ul class="ui-tabs-nav"><?php $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC"); while($la1=mysqli_fetch_array($la)) { ?><li><a href="#tabs-<?php echo $la1['id']?>"><?php echo $la1['jezik']?></a></li><?php } ?></ul><?php $naslov=$ulink=$opis1=$opis=$title=$keywords=$description=$esno1=$esno2=$esno3=$esno4=$pozicija="";  $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC"); while($la1=mysqli_fetch_array($la)) { $jez=$la1['jezik']; $zzL=mysqli_query($conn, "SELECT * FROM pages_text_lang  WHERE id_text=$id_get AND lang='$jez'"); $zzL1=mysqli_fetch_array($zzL); $naslov=$_POST["naslov$jez"]?$_POST["naslov$jez"]:$zzL1["naslov"]; $pretragalink=$_POST["pretraga_link$jez"]?$_POST["pretraga_link$jez"]:$zzL1["pretraga_link"]; $opis=$_POST["opis$jez"]?$_POST["opis$jez"]:$zzL1["opis"]; $opis1=$_POST["opis1$jez"]?$_POST["opis1$jez"]:$zzL1["opis1"]; $title=$_POST["title$jez"]?$_POST["title$jez"]:$zzL1["title"]; $keywords=$_POST["keywords$jez"]?$_POST["keywords$jez"]:$zzL1["keywords"]; $description=$_POST["description$jez"]?$_POST["description$jez"]:$zzL1["description"]; $pozicija=$_POST["pozicija"]?$_POST["pozicija"]:$zz1['pozicija']; $titleslike=$zzL1["titleslike"]; $altslike=$zzL1["altslike"]; ?><div id="tabs-<?php echo $la1['id']?>" class="ui-tabs-panel">U naslovu<br /><input type="text" name='naslov<?php echo $jez?>' value="<?php echo $naslov?>" class='selecte' required /><br /><br /><label>Kratak tekst</label><br /><textarea cols="80"  name="opis1<?php echo $jez?>"  rows="5" style="width:100%"><?php echo $opis1?></textarea><br /><label>Opširniji tekst</label><br /><textarea cols="80" id="editor<?php echo $jez?>"  name="opis<?php echo $jez?>" rows="10" style="width:100%"><?php echo $opis?></textarea><div class="row mt-20"><div class="col-12 mb-20"><label>Naslov za celu stranicu (H1):</label><br /> <input type="text" name='youtube' class='selecte' value="<?php echo $zz1['youtube']?>" placeholder="Unosi se samo za tekst koji je prvi na stranici!" /></div><div class="col-4 mb-20"><label>Linkuj tekst:</label><br /><input type="text" name='keywords<?php echo $jez?>' value="<?php echo $keywords?>" class='selecte zeleno'  /></div><div class="col-4 mb-20"><label>Alt slike:</label><br /><input type="text" name='altslike<?php echo $jez?>' value="<?php echo $altslike?>" class='selecte zeleno'  /></div><div class="col-4 mb-20"><label>Title slike:</label><br /><input type="text" name='titleslike<?php echo $jez?>' value="<?php echo $titleslike?>" class='selecte zeleno'  /></div><div class="col-4 mb-20"><div class="ipad"><p><label>Prikaz kao uvodni tekst (bez slike): </label><?php if($zz1['polapola']==1) $pola="checked"; else $pola="";?><input type="checkbox" name="polapola" value="1" <?php echo $pola ?> /></p><!--<label class="mr-10">Pozicija teksta:</label><br /> <input type="number" name='pozicija' class='selecte' value="<?php echo $zz1['pozicija']?>"  min="0" />--></div></div><div class="col-8 mb-20"><div class='ipad'><div class='float-left'><label>Slika:</label><br /> <input type="file" class="file_input_div1"  id="avatar" name='slika' /></div><?php if(is_file("..".GALFOLDER."/".$zz1['slika'])){echo "<div class='float-right'><img src='$patH".GALFOLDER."/thumb/$zz1[slika]' style='width:80px;height:60px;' />";echo "<input type='hidden' value='$zz1[slika]' name='stara_slika' />";echo "<br /><input type='checkbox' value='1' name='brisi' /> Oznaci za brisanje</div>";}?></div></div></div><?php } ?></div></div></div></div><div class="row mt-20"><div class="col-12"><input type="hidden" name="tipus" value="2"><input type='submit' name='save_tekst_change' class="submit_dugmici_blue" value='<?php echo $langa['time_zone'][3]?>'></div></form></div>