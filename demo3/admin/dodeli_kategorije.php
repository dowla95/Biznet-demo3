<?php 
if(isset($_GET['id_cat'])) {
$id_get=$_GET['id_cat'];
$kolona="stavka";
$tabela="stavke_kategorije";
$zaza="FILTERU";
$cekiranje="radio";
$ri=mysqli_query($conn, "SELECT * FROM categories_group WHERE id=$id_get");
$ri1=mysqli_fetch_assoc($ri);
$rip=$ri1['name'];
} else {
$id_get=$_GET['id'];
$kolona="brend";
$tabela="brend_kategorije";
$zaza="BRENDU";
$cekiranje="checkbox";
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND p.id=$id_get");
  $rip1=mysqli_fetch_array($tz);
  $rip=$rip1['naziv'];
}

if(isset($_POST['save_stavke_kategorije'])) {
$iovo=array();
if(is_array($_POST['kategorija'])) {
foreach($_POST['kategorija'] as $k => $v) {
$iovo[]="($id_get, $v)";
}
}
mysqli_query($conn, "DELETE FROM $tabela WHERE $kolona=$id_get");
mysqli_query($conn, "INSERT INTO $tabela ($kolona, kategorija) VALUES ".implode(", ", $iovo));
}
$sin=array();
$vi=mysqli_query($conn, "SELECT * FROM $tabela WHERE $kolona=$id_get");
while($vi1=mysqli_fetch_assoc($vi)){
$sin[]=$vi1['kategorija'];
}

?>

<table class="table-responsive" style='display:table;' cellspacing="0" cellpadding="0">
<tr><td width="100%">
	<div class='naslov_smestaj_padd'><h1 class="border_ha">Dodela kategorija izabranom <?php echo $zaza?> - <?php echo $rip?></h1></div>
</td>

</tr>
</table>        
<?php 
if($msr!="")
echo "<div class='infos1'><div>$msr</div></div>";
?> 
<form method="post" action="" enctype="multipart/form-data">

<div class="row">
<div class="col-12">
<b>Kategorija  <span class="mr-20" style='color:red;'>*</span></b>
<?php if($cekiranje=="checkbox") { ?>
      <input type="checkbox" id="select-all">
      <label>Izaber ili poništi sve</label>
<?php } ?>
<div style="width:100%;height:465px;overflow:auto;border:1px solid #111;background:#fff;-webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;padding:5px;">
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND  p.akt=1 AND p.id_cat=32 ORDER BY -p.position DESC");
   while($tz1=mysqli_fetch_array($tz))
     {
     $hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=2 AND  p.akt=1 AND  id_parent=$tz1[ide]  ORDER BY -p.position DESC");
$sums=mysqli_num_rows($hz);
if($sums>0) {
echo "<div style='width:100%;'><b>".$tz1['naziv']."</b></div>";

   while($hz1=mysqli_fetch_array($hz))
     {
  $fz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$firstlang' AND  p.nivo=3 AND  p.akt=1 AND  id_parent=$hz1[ide]  ORDER BY -p.position DESC");
$fums=mysqli_num_rows($fz);
if($fums>0) {
echo "<div style='width:100%;padding-left:30px;'><b>".$hz1['naziv']."</b></div>";
while($fz1=mysqli_fetch_array($fz))
     {
if(in_array($fz1['ide'],$sin))
$chef="checked"; else $chef="";
echo "<label style='display:block;width:100%;padding:0px;margin:0px;padding-left:50px;'><input type='$cekiranje' name='kategorija[]' value='$fz1[ide]' $chef style='position:relative;top:2px;'> $fz1[naziv]</label>";
}
} else {
if(in_array($hz1['ide'],$sin))
$che="checked"; else $che="";
echo "<label style='display:block;width:100%;padding:0px;margin:0px;padding-left:30px;'><input type='$cekiranje' name='kategorija[]' value='$hz1[ide]' $che style='position:relative;top:2px;'> $hz1[naziv]</label>";
}
}
} else {
if(in_array($tz1['ide'],$sin))
$chet="checked"; else $chet="";
echo "<label style='display:block;width:100%;padding:0px;margin:0px;'><input type='$cekiranje' name='kategorija[]' value='$tz1[ide]' $chet style='position:relative;top:2px;'><b> $tz1[naziv]</b></label>";
}
}
?>

</div>
</div>
</div>
<br>
<div class="row">
<div class="col-12 text-right">
<input type='submit' name='save_stavke_kategorije' class="submit_dugmici_blue" value='Sačuvaj izmene'>
</div>
</div>
<br />
</form>
<script>
$(document).ready(function() {
  $('#select-all').click(function() {
    $('input[type="checkbox"]').prop('checked', this.checked);
  })
});
</script>