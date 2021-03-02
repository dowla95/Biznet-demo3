<?php 
include("../Connections/conn_admin.php");
$page_path3 =$page_path2.SUBFOLDER."/admin";
$patHA=$patH."/admin";
 $i=1;
session_start();
?>

 <span class='tabs'></span>
	<!-- JS ends --> 
<link rel="stylesheet" type="text/css" href="<?php echo $patH?>/colorbox/colorbox1.css">
<script type="text/javascript" src="<?php echo $patH?>/colorbox/jquery.colorbox.js"></script>
 <script type="text/javascript">
 	$(document).ready(function(){
	$(".iframe").colorbox({iframe:true, width:"90%", height:"810px", cache: false}); 
     	$(".group1").colorbox({rel:'group1'});
});
</script>
<script type="text/javascript" src="<?php echo $patHA?>/js/jquery-ui-1.8.23.custom.min.js"></script>
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
global $nizSub;
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
echo "<a href='".$patH.GALFOLDER."/".$p1['slika']."' class='group1'  style='display:block;width:$im[0]px;'><img src='".$patH.GALFOLDER."/thumb/".$p1['slika']."'   alt='".$res['naslov']."' style='border:1px solid #999;padding:2px;height:60px;max-width:90%' /></a><br />";
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
$sa=mysqli_query($conn, "SELECT * FROM slike_lang WHERE lang='$la1[jezik]' AND id_slike='$p1[id]'");
$sa1=mysqli_fetch_array($sa);
 ?>
	<div id="tabs-<?php echo $la1['id']?>" class="ui-tabs-panel">
<?php 
$jez=$la1['jezik'];
echo "Alt slike: <input type='text' value='".$sa1["alt"]."' name='alt$jez' class='input_poljes_sivo' style='width:210px;' /><br />
Title slike: <input type='text' value='".$sa1["title"]."' name='title$jez' class='input_poljes_sivo' style='width:210px;' /><br />";
if($_GET['tip']==3){
echo "U link: <input type='text' value='".$sa1["ulink"]."' name='ulink$jez' class='input_poljes_sivo' style='width:210px;' /><br>";
echo "Slika se koristi za
<select name='subtip' class='input_poljes_sivo' style='width:210px;'>";

foreach($nizSub as $k => $v) {
//$ep=explode("-",$k); if($p1['subtip']==$ep[0]) $toje=" selected"; else
$toje="";
echo "<option value='$k'$toje>$v</option>";
}
echo "</select><br><br>";
}
?>
</div>
<?php 
}
?>
</div>
 
<div class='ui-tabs-panel ipad'>
<?php 
 
if($p1['akt']=="Y") $ch="checked"; else $ch="";
if($p1['poc']=="Y") $ch1="checked"; else $ch1="";
if($_GET['tip']!=3)
echo "Linkuj sliku: <input type='text' value='".$p1["link"]."' name='link'   class='input_poljes_sivo' style='width:210px;' /><br /><br />";
else
echo "<input type='hidden' value='".$p1["link"]."' name='link' class='input_poljes_sivo' style='width:210px;' />";

?>
<input type='hidden' name='idslike' value='<?php echo $p1['id']?>'  />
<input type='hidden' name='tabli' value='<?php echo $_GET['tabela']?>'  />
pozic: <input type='text' name='pozicija' value='<?php echo $p1['pozicija']?>' style='width:20px;' />
prikaži: <input type='checkbox' name='akti' value='1' <?php echo $ch?>  />
<?php 
if($_GET['tip']!=3)
{
?>
home: <input type='checkbox' name='poc' value='1' <?php echo $ch1?>  />
<?php 
}
else
{
?>
<input type='hidden' name='poc' value='1' <?php echo $ch1?>  />
<?php 
}
echo "<a href='javascript:;' title='brisi sliku - delete image' onclick=\"delas($p1[id],'$p1[slika]')\"  style='float:right;margin-top:3px;'>OBRIŠI</a>
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

 
	$valid_formats = array("jpg", "png", "gif", "JPG", "JPEG", "GIF", "PNG","zip","ZIP", "SVG", "svg");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
        $inix=explode('.', $name);
        $ext= end($inix);
        $ext=strtolower($ext);
        $ext=str_replace("jpeg","jpg",$ext);
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
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/".$zip->getNameIndex($i)))
$slika=date("Y-m-d-H-i")."-".$zip->getNameIndex($i);
else
$slika=$zip->getNameIndex($i);          
rename("../temp/".$zip->getNameIndex($i),$page_path2.SUBFOLDER.GALFOLDER."/$slika");
$iimesl=explode('.', $slika);
$ext= ".".end($iimesl);
$ext=strtolower($ext);
$ext=str_replace("jpeg","jpg",$ext);
if($ext==".jpg" or $ext==".JPG" or $ext==".gif" or $ext==".GIF" or $ext==".png" or $ext==".PNG" or $ext==".SVG" or $ext==".svg")
{
if($_GET['tip']==4 or $_GET['tip']==5 or $_GET['tip']==0)
{
resizerv($slika,$page_path2.SUBFOLDER.GALFOLDER."/");
create_square_image1($slika,$page_path2.SUBFOLDER.GALFOLDER."/",320);
}
else
if($_GET['tip']==3)
{
resizervE($slika,$page_path2.SUBFOLDER.GALFOLDER."/",100);
create_square_image($slika,$page_path2.SUBFOLDER.GALFOLDER."/",100);
}
else
{
resize($slika,$page_path2.SUBFOLDER.GALFOLDER."/");  
resizerv($slika,$page_path2.SUBFOLDER.GALFOLDER."/");
}
}
mysqli_query($conn, "INSERT INTO $_GET[tabela] (slika, idupisa, id_page, tip, akt)
VALUES ('$slika','$_GET[ide]','$_GET[id_page]','$_GET[tip]', 'Y')");
$zid=mysqli_insert_id($conn); 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
{
mysqli_query($conn, "INSERT INTO slike_lang SET id_slike='$zid',lang='$la1[jezik]'");
}                     
        // here you can run a custom function for the particular extracted file            
    }
    $zip->close();             
}
}
else
{ 
if($_GET['tip']==4 or $_GET['tip']==5 or $_GET['tip']==0)
$slika =UploadSlika($name,$tmp,$_FILES['photoimg']['type'],$page_path2.SUBFOLDER.GALFOLDER."/",1,1);
else
if($_GET['tip']==3)
$slika =UploadSlika($name,$tmp,$_FILES['photoimg']['type'],$page_path2.SUBFOLDER.GALFOLDER."/",2,'');
else
if($_GET['tip']==2)
$slika =UploadSlika($name,$tmp,$_FILES['photoimg']['type'],$page_path2.SUBFOLDER.GALFOLDER."/",2,'');
else
$slika =UploadSlika($name,$tmp,$_FILES['photoimg']['type'],$page_path2.SUBFOLDER.GALFOLDER."/",'');

mysqli_query($conn, "INSERT INTO $_GET[tabela] (slika, idupisa, id_page, tip, akt)
VALUES ('$slika','$_GET[ide]','$_GET[id_page]','$_GET[tip]', 'Y')");
$zid=mysqli_insert_id($conn); 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
{
mysqli_query($conn, "INSERT INTO slike_lang SET id_slike='$zid',lang='$la1[jezik]'");
}
}
} 
slikevt($i);
}
else
{
echo "<span style='color:red;display:block;padding-bottom:10px;'>Slika je pogresnog formata!</span>";
slikevt($i);
}	
}
else{
echo "<span style='color:red;display:block;padding-bottom:10px;'>Izaberite sliku!</span>";
slikevt($i);
}
exit;
}
?>