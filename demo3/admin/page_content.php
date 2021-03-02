<div class="row mt-10">
	<div class="col-9">
<?php 
$ova=mysqli_query($conn, "SELECT * FROM page WHERE id='$idp'");
$ova1=mysqli_fetch_assoc($ova);
?>
<div class='naslov_smestaj'><h1>Upisani tekstovi kao osnovni model</h1></div>
	</div>
	<div class="col-3">
		<a href="#inline_content" class='inline float-right'><span style='padding:6px 10px;font-size:15px;'>PRONAĐI TEKST</span></a>
	</div>
</div>             
<?php 
//$orderby=" id DESC";
//if($_GET['id_page']>0 and $_GET['searc']=="")
//{
?>
 <script>
    $(document).ready(function(){
    $("#sorting .upitnici_oglasi tbody").sortable({
      stop: function(){
        qString = $(this).sortable("serialize");
   //alert(qString)
    
       // $('#msg').fadeIn("slow");
        //$('#msg').html("Updating...");
        $.ajax({
          type: "POST",
   
      url: "<?php echo $patHA?>/save_position.php?table=pages_text",
          data: qString,
          cache: false,
          beforeSend: function(html){
       $("#sorting .upitnici_oglasi tbody").css("opacity", "0.6");
          },
          success: function(html){
          $("#sorting .upitnici_oglasi tbody").css("opacity", "1.0")
          }
        });
      }
    });
        //$("#sorting .ul").disableSelection();
  });   
</script>
<style>
#sorting table tr{cursor:move;}
</style>
 <?php 
 $orderby=" pozicija ASC"; 
 //}
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
<select name="kat" class='selecte' onchange="gog(this.value,'id_page','<?php echo $_GET['idp']?>')">
<?php 
if($id_page==0 and $id_page!="") $pse="selected"; else $pse=""; 
?>
<option value=''>Izaberite stranicu</option>
<?php 
 $tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  nivo=1  AND id_cat=0 ORDER BY p.position ASC");
   while($tz1=mysqli_fetch_array($tz))
{
     if($_GET['id_page']==$tz1['id_page']) $sel="selected"; else $sel="";
?>
<option value="<?php echo $tz1['ide']?>" <?php echo $sel?> style="font-weight:bold;color:black;"><?php echo $tz1["naziv"]?></option>
<?php 
$hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$tz1[ide]  AND id_cat=0 ORDER BY p.position ASC");                       
while($hz1=mysqli_fetch_array($hz))
{
if($_GET['id_page']==$hz1['id_page']) $sel="selected"; else $sel="";
?>
<option value="<?php echo $hz1['ide']?>" <?php echo $sel?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option>
<?php
$rz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$hz1[ide]  AND id_cat=0 ORDER BY p.position ASC");                       
while($pz1=mysqli_fetch_array($pz))
{
if($_GET['id_page']==$pz1['id_page']) $sel="selected"; else $sel="";                  
?>
<option value="<?php echo $pz1['ide']?>" <?php echo $sel?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pz1["naziv"]?></option>
<?php 
}
}
}
?>
</select><br /><br />
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
$plun .=" AND (naslov$amlang LIKE '%".$pret."%' or opis$amlang LIKE '%".$pret."%')";
}
}
}
} 
if($_GET['tipi1']=="1")
$plun .=" AND coment=0";
if($_GET['admino']==1) $plun .=" AND akt='Y'";
if($_GET['admino']==2) $plun .=" AND akt='N'";
if($_GET['id']>0) $plun .=" AND id=$id_get"; 
if($_GET['id_kat']>0) $plun .=" AND katid=$id_kat_get";
if($_GET['id_page']>0) $plun .=" AND id_page=$id_page_get";
if($_GET['id_user']>0) $plun .=" AND user_id=$id_user_get";
if($_GET['idp']>0) $andidpS="id_page IN(".kategorije($_GET['idp'],"page",1).") AND "; 
$page_cur=0;
if($search_values[1]!="")
$inpagination=urldecode($search_values[1]);
$inpagin=explode("&p=",$inpagination);
$inpagination=$inpagin[0]."&";
 
$page_cur=$sarray['p'];
$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  pages_text WHERE $andidpS id>0  $plun"));
$pagedResults = new Paginated($br_upisa, $ByPage1, $page_cur);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout());
$fi=mysqli_query($conn, "SELECT * FROM pages_text WHERE $andidpS id>0 AND tipus=0 $plun ORDER BY $orderby LIMIT $str,$ByPage1");
?>
<div style='width:100%;font-size:11px;padding-bottom:5px;height:25px;'>
<form method="get" action="" style="float:right;width:200px;">
    <input type="hidden" name="idp" value="<?php echo $_GET['idp']?>" />
    <input type="hidden" name="base" value="<?php echo $_GET['base']?>" />
    <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='id' class='input_poljes' style='padding:3px;float:left;width:100px;'  value="<?php echo $_GET['id']?>">
    <input type="submit" value="Pronađi ID" name='nadji_oglas' class='submit_dugmici_blues' style='float:left;width:95px;border:1px solid #888;padding:2px;margin-left:2px;' />
    </form>  
</div> 

<div id='sorting'>
<table class='upitnici_oglasi'>
<tbody id="slickbox1">
  <tr class="yellow" id="sortid_0"> 
	<td>ID</td>
    <td>Naslov</td>
    <td>Slika</td>
	<td>Stranica</td>
	<td>H1</td>
    <td>Slike</td>
	<td>Akt</td>   
    <td>Izmena / Brisanje</td>
  </tr>
<?php 
$i=0;
while($og1=mysqli_fetch_array($fi)){
if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';
$msg_id=$og1['id']; 
$zzL=mysqli_query($conn, "SELECT * FROM pages_text_lang  WHERE id_text=$og1[id] AND lang='$firstlang'");
$zzL1=mysqli_fetch_array($zzL); 
?>
<tr id="sortid_<?php echo $og1['id']?>" style='<?php echo $ba?>'>
<td style='width:30px;'><?php echo $og1['id']?></td>
<td style='width:350px;'>
<a href="#" title="<?php echo str_replace("\"","",$zzL1["naslov"])?>"><?php echo $zzL1["naslov"]?></a>
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
$cg=mysqli_query($conn, "SELECT naziv FROM pagel WHERE id_page='$og1[id_page]' AND lang='$firstlang'");
$cg1=mysqli_fetch_array($cg);
echo $cg1["naziv"];
?>
</td>
<td>
<?php if($og1['youtube']!="") echo '<i class="fas fa-circle fa-2x blue"></i>'; else echo '';?>
</td>
<td>
<?php 
$hg=mysqli_query($conn, "SELECT * FROM slike WHERE idupisa='$og1[id]' AND tip=0");
echo "<a href='$patHA/index.php?base=admin&page=subslike&idupisa=$og1[id]&tip=0&id_page=0'>";
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
$ku=mysqli_query($conn, "SELECT * FROM comments WHERE id_pro='$og1[id]' AND tip=0");
echo "<a href='$patHA/index.php?base=admin&page=comments&id_ap=$og1[id]&tip=0'>";
echo mysqli_num_rows($ku);
echo "</a>";
?>
</td>
<?php 
}
?> 
<td>
<?php 
if($og1['akt']=="Y") $che="checked"; else $che="";
?>
<input type='checkbox' value='1' <?php echo $che?> onclick="akti('<?php echo $og1['id']?>', 'akti_page')" />
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
<a href="<?php echo $patHA?>/index.php?base=admin&page=page_edit_content&id=<?php echo $og1['id']?>" class="edit_oglas"><i class="fas fa-pencil-alt olovcica"></i></a>&nbsp;&nbsp;
<a href="javascript:;" class="edit_oglas" onclick="obrisime(<?php echo $og1['id']?>,'delete_tekst')"><i class="fal fa-trash-alt crvena"></i></a>
</td>
</tr>
<?php 
$i++;
}
?>
</tbody>
</table>
</div>
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
    <h3>Pronađi</h3>
    Ukucajte trazeni pojam:
    <br />
    <input type="hidden" name="idp" value="<?php echo $_GET['idp']?>" />
    <input type="hidden" name="base" value="<?php echo $_GET['base']?>" />
    <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='pojams' class='input_poljes'  value="<?php echo $_GET['pojams']?>">
    <br />
    <br />
    <?php 
    if($_GET['admino']==1) $admino1="checked";
    else if($_GET['admino']==2) $admino2="checked"; else $admino="checked";
    if($_GET['tipi1']==1) $tipi1="checked";
    if($_GET['tipi2']==1) $tipi2="checked";
    ?> 
    Prikaži:
    <br /><input type="radio" name='admino' value='0' <?php echo $admino?>> sve upise
    <br /><input type="radio" name='admino' value='1'  <?php echo $admino1?>> aktivne
    <br /><input type="radio" name='admino' value='2' <?php echo $admino2?>> neaktivne
    <br />
    <br /><br />
    <br /><br /> 
    <br /><br />
    <input type="submit" value="Pronađi upis" name='nadji_oglas' class='submit_dugmici_blue' />
    </form>
	</div>
</div>