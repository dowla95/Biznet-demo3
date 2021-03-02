<br class='clear' />
<br />
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td width="73%">

<div class='naslov_smestaj'><h1>UPISANI MENIJI <span style='color:#444;'><?php echo $ova1["naziv$amlang"]?></b></h1></div>
</td>
</tr>
</table>              
<?php 
$ByPage=20;  
$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  categories_group WHERE tip=1 ORDER BY name ASC"));
$pagedResults = new Paginated($br_upisa, $ByPage1, $page_cur);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout());

$fi=mysqli_query($conn, "SELECT * FROM  categories_group WHERE tip=1 ORDER BY name ASC LIMIT $str,$ByPage1");
$akti="";
$zaiz="";
if($id_get>0)
{
$zai=mysqli_query($conn, "SELECT * FROM categories_group WHERE id=$id_get");
$zai1=mysqli_fetch_assoc($zai);
$zaiz=$zai1['name'];
if($zai1['akt']==1) $akti="checked";
} 
 ?>
<div style='width:100%;font-size:11px;padding-bottom:5px;height:30px;'>

<form method="post" action="" style="float:right;width:480px;">
 <input type='hidden' value='1'  name='tip' />   
 <!--<div style='float:left;'><input type="checkbox" value='1' <?php echo $akti?> name='akt' /> Aktiviraj</div> -->
    
    <input type="submit" value="Upis / Izmena" name='up_iz_menu' class='submit_dugmici_blue' style='float:right;padding:8px 20px;height:37px;margin-left: 15px;' />
    <input type='text' name='name' class='form-control' style='padding:3px;float:right;width:300px;font-size:12px;' placeholder="Upisati naziv novog menija ili promeniti postojeći" value="<?php echo $zaiz?>" required>
    </form>  
</div> 

 <div id='sorting'>
<table class='upitnici_oglasi'>
<tbody id="slickbox1">
  <tr class="yellow" id="sortid_0">
  <!--
   <td>ID</td>
   <td>Aktivnost</td>
  -->
   <td>Naziv menija</td>
   <td>Uredi MENU</td>   
   <td>Izmena / Brisanje</td>
  </tr>
<?php 
$i=0;
while($og1=mysqli_fetch_array($fi)){
if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';
$msg_id=$og1['id']; 
?>
<tr id="sortid_<?php echo $og1['id']?>" style='<?php echo $ba?>'>
<!--
<td style='width:30px;'><?php echo $og1['id']?></td>
<td>
<?php 
if($og1["akt"]==1) echo "DA"; else echo "NE";
?></td>
-->
<td>
<?php echo $og1["name"]?></td> 
 <td>
 <a href="index.php?base=admin&page=menu_list&id_kat=<?php echo $og1['id']?>">Uredi meni</a>
 </td>
<td>
<a href="index.php?base=admin&page=menus&id=<?php echo $og1['id']?>" class="olovcica"><i class="fas fa-pencil-alt"></i></a>&nbsp;&nbsp;
<?php if($og1['id']!=4) { ?>
<a class="crvena" href="javascript:;" class="edit_oglas" onclick="obrisime(<?php echo $og1['id']?>,'delete_menus')"><i class="fal fa-trash-alt"></i></a>
<?php } ?>
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
    <h3>Pronađite oglas</h3>
    Ukucajte trazeni pojam za default jezik:
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
  <!--  <br /><input type="checkbox" name='tipi1' value='1'  <?php echo $tipi1?>> nije dozvoljeno komentarisanje-->
    
    <br /><br />
   
    <br /><br /> 
    <br /><br />
    <input type="submit" value="Pronađi upis" name='nadji_oglas' class='submit_dugmici_blue' />
    </form>
			</div>
		</div>