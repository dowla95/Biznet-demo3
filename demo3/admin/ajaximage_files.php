<?php 
include("../Connections/conn_admin.php");
$page_path3 =$page_path2.SUBFOLDER."/admin";
$patHA=$patH."/admin";
 $i=1;
session_start();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
 <span class='tabs'></span>
 <script type="text/javascript" src="<?php echo $patHA?>/js/jquery-ui-1.8.23.custom.min.js"></script> 
<script type="text/javascript" src="http://jqueryui.com/latest/ui/ui.tabs.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".ui-tabs").tabs();
	});
</script>
<?php 
function slikevt($is=1)
{
global $patH;
global $conn;
if($_GET['id_page']!="") $iidp="AND id_page=$_GET[id_page]"; else $iidp="";
$das=mysqli_query($conn, "SELECT * FROM $_GET[tabela] WHERE idupisa=$_GET[ide] $iidp AND tip=$_GET[tip]  ORDER BY id DESC LIMIT $is");
while($p1=mysqli_fetch_assoc($das))
 {  
  $b=$i%2;
// if($b==1 and $i>0)
 //echo "<div style='float:left;width:130px;font-size:1px;height:2px;'></div>";
 ?> 
<li id='sortid_<?php echo $p1['id']?>' style='margin-bottom:10px;width:240px;float:left;
margin-left:10px;'>
<form method="post" action="" id="forma<?php echo $p1['id']?>">
<div style='float:left;width:100%;font-size:11px;color:black;position:relative;' id='del<?php echo $p1['id']?>'>
  <div class='ajax-loading1'></div>
<?php 
$zinix=explode('.', $p1['slika']);
$zext= end($zinix);
if($zext=="pdf" or $zext=="PDF") $icon="pdf-icon.png";
else
if($zext=="doc" or $zext=="DOC" or $zext=="docx" or $zext=="DOCX") $icon="word-icon.png";
else
if($zext=="xls" or $zext=="XLS" or $zext=="xlsx" or $zext=="XLSX") $icon="excel-icon.png";
echo "<a href='".$patH.FILFOLDER."/".$p1['slika']."' target='blank'  style='display:block;text-align:center;'><img src='".$patH."/images/icon/".$icon."'   alt='".$res['naslov']."'  /></a><br />";
?>
<div class="ui-tabs">
	<ul class="ui-tabs-nav">
<?php 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<li><a href="#tabs-<?php echo $la1['id']?>"><?php echo $la1['jezik']?></a></li>
<?php } ?>
	</ul>
  <?php 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
	<div id="tabs-<?php echo $la1['id']?>" class="ui-tabs-panel">
<?php 
$jez=$la1['jezik'];
$sa=mysqli_query($conn, "SELECT * FROM files_lang WHERE lang='$la1[jezik]' AND id_fajla='$p1[id]'");
$sa1=mysqli_fetch_array($sa);
echo "Naziv: <input type='text' value='".$sa1["naslov"]."' name='naslov$jez' class='input_poljes_sivo' style='width:210px;' /><br />";
?>
</div>
<?php 
}
?>
</div>
<div class='ui-tabs-panel ipad'>
<?php 
if($p1['akt']=="Y") $ch="checked"; else $ch="";
?>
<input type='hidden' name='idslike' value='<?php echo $p1['id']?>'  />
<input type='hidden' name='tabli' value='<?php echo $_GET['tabela']?>'  />
pozic: <input type='text' name='pozicija' value='<?php echo $p1['pozicija']?>' style='width:30px;' />
prikaži: <input type='checkbox' name='akti' value='1' <?php echo $ch?>  />
<?php 
echo "<a href='javascript:;' title='brisi sliku - delete image' onclick=\"delas($p1[id],'$p1[slika]')\"  style='float:right;margin-top:3px;'>OBRIŠI FAJL</a>
";
?>
</div>
<div id="prev<?php echo $p1['id']?>"></div>
<input type='submit' name='izmene_slike' class="submit_dugmici_blue button" value='Sačuvaj izmene' style='width:100%;' id="<?php echo $p1['id']?>" />
</form>
</div>
</li>
<?php 
  $i++;
 }  
}
	$valid_formats = array("pdf", "PDF", "doc", "DOC", "docx", "DOCX", "xls","XLS", "xlsx","XLSX","zip","ZIP");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			if(strlen($name))
				{
        $inix=explode('.', $name);
        $ext= end($inix);
				//	list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
							$tmp = $_FILES['photoimg']['tmp_name'];
 
if($tmp)
{
if($ext=="zip" or $ext=="ZIP")
{
$path=$tmp;
$zip = new ZipArchive;
if ($zip->open($path) === true) { 
    for($i = 0; $i < $zip->numFiles; $i++) {      
$zip->extractTo('../temp/', array($zip->getNameIndex($i)));
if(is_file($page_path2.SUBFOLDER.FILFOLDER."/".$zip->getNameIndex($i)))
$slika=date("Y-m-d-H-i")."-".$zip->getNameIndex($i);
else
$slika=$zip->getNameIndex($i);          
rename("../temp/".$zip->getNameIndex($i),$page_path2.SUBFOLDER.FILFOLDER."/$slika");
mysqli_query($conn, "INSERT INTO $_GET[tabela] (slika, idupisa, id_page, tip, akt) 
VALUES ('$slika','$_GET[ide]','$_GET[id_page]','$_GET[tip]', 'Y')");                      
        // here you can run a custom function for the particular extracted file
$zid=mysqli_insert_id($conn); 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
{
mysqli_query($conn, "INSERT INTO files_lang SET id_fajla='$zid',lang='$la1[jezik]'");
}
}
    $zip->close();
}
}
else
{
$slika =UploadSlika($name,$tmp,$_FILES['photoimg']['type'],$page_path2.SUBFOLDER.FILFOLDER."/");
mysqli_query($conn, "INSERT INTO $_GET[tabela] (slika, idupisa, id_page, tip, akt) 
VALUES ('$slika','$_GET[ide]','$_GET[id_page]','$_GET[tip]', 'Y')"); 
$zid=mysqli_insert_id($conn); 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
{
mysqli_query($conn, "INSERT INTO files_lang SET id_fajla='$zid',lang='$la1[jezik]'");
}
}
} 
slikevt($i);
}
else
{
echo "<span style='color:red;display:block;padding-bottom:10px;'>Fajle je pogresnog formata!</span>";
slikevt($i);
}	
}
else{
echo "<span style='color:red;display:block;padding-bottom:10px;'>Izaberite fajl!</span>";
slikevt($i);
}
exit;
}
?>