<?php 
include("header-top-iframe.php");
$ByPage1=60; 
?>
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td width="73%">
<div class='naslov_smestaj'><h2>UPISANI MODELI STRANICA</h2></div>
</td>
</tr>
</table>              
<?php 
$ByPage=20;  
$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  categories_group WHERE tip=2 ORDER BY name ASC"));
$pagedResults = new Paginated($br_upisa, $ByPage1, $page_cur);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout());
$fi=mysqli_query($conn, "SELECT * FROM  categories_group WHERE tip=2 ORDER BY name ASC LIMIT $str,$ByPage1");
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
 <input type='hidden' value='2'  name='tip' />   
 <div style='float:left;'><input type="checkbox" value='1' <?php echo $akti?> name='akt' /> Aktiviraj</div> 
    
    <input type="submit" value="Upis / Izmena" name='up_iz' class='submit_dugmici_blues' style='float:right;width:95px;border:1px solid #888;padding:2px;margin-left:2px;' />
    <input type='text' name='name' class='input_poljes' style='padding:3px;float:right;width:300px;'  value="<?php echo $zaiz?>">
    </form>  
</div> 

 <div id='sorting'>
<table class='upitnici_oglasi'>
<tbody id="slickbox1">
  <tr class="yellow" id="sortid_0"> 
   <td>ID</td>
   <td>Aktivnost</td>
    <td>Naziv</td>
   <td>Uredi modele</td>
    <td>Izmena / Brisanje</td>
  </tr>
<?php 
$i=0;
while($og1=mysqli_fetch_array($fi)){
if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';
$msg_id=$og1['id']; 
?>

<tr id="sortid_<?php echo $og1['id']?>" style='<?php echo $ba?>'>
<td style='width:30px;'><?php echo $og1['id']?></td>
<td>
<?php 
if($og1["akt"]==1) echo "DA"; else echo "NE";
?></td>
<td>
<?php echo $og1["name"]?></td> 
 <td>
 <a href="index.php?base=admin&page=models_page&id=<?php echo $og1['id']?>">Uredi model</a>
 </td>

<td>
<a href="index.php?base=admin&page=models&id=<?php echo $og1['id']?>" class="edit_oglas"><i class="fas fa-pencil-alt olovcica"></i></a>&nbsp;&nbsp;
<a href="javascript:;" class="edit_oglas" onclick="obrisime(<?php echo $og1['id']?>,'delete_models')"><i class="fal fa-trash-alt crvena"></i></a>
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