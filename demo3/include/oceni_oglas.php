<?php 
include("Connections/conn.php");
if($_POST['id']>0)
{
mysqli_query($conn, "INSERT INTO oglasi_ocena SET id_oglasa=".safe($_POST['id']).", ocena=".safe($_POST['ocena'])."");
if($_POST['ocena']==1) $poen="poen"; else $poen="poena";
?>
<span style="color:red;float:right;" >Hvala! Oglasu ste dodelili <?php echo strip_tags($_POST['ocena'])?> <?php echo $poen?>.</span>
<?php 
}
?>