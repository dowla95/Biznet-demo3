<?php 
include("header-top.php");
if($header!="")
include("$page_path3/$header");
$ByPage1=60; 

?>
<div class="container-fluid">

 <div class="<?php echo $left_right?>">
 <div id="modules">
<?php
if($klasa_id_1!="")
{
?>
<div id="<?php echo $klasa_id_1?>">
<?php
}
 $minhe="400px;";
?>

<?php
if(is_file("$page_path3/$include_file"))
include("$page_path3/$include_file");
else
echo "<div class='infos1'><div>Stranica ne postoji</div></div>";
if($include_file_plus!="")
include("$page_path3/moduli/$include_file_plus");
?>

<?php
if($klasa_id_1!="")
{
?>
</div>
<?php
}
if(count($include_module)>0 and $klasa_id_1!="")
{
?>
<div id="<?php echo $klasa_id_2?>">
<?php
foreach($include_module as $key => $include_modul)
include("$page_path3/moduli/$include_modul");
?>
<div class='trakica_pozadina'></div>
</div>
<?php
}
?>
 </div>
 </div>
</div>
<?php
if(!isset($_GET['izape'])){
?>
<div id="footer_down">
<div class="container-fluid">
<ul><li>© Copyright 2020</li></ul>
</div>
</div>
<?php } ?>
<script src="<?php echo $uvoz?>/js/bootstrap.min.js"></script>
 </body>
</html>