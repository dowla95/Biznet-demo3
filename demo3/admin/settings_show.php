<?php 
session_start();
$sid=session_id();
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
if($_GET[del]>0)
{
if(!mysqli_query($conn, "DELETE FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip] AND shows=$_GET[del]")) echo mysqli_error();

header("location: $patHA/settings_show.php?id=$_GET[id]&tip=$_GET[tip]");
}
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="X-UA-Compatible" content="IE=9" >

 
 <meta name="author" content="webdizajne.rs" />
 
<meta http-equiv="Content-Language" content="en-us" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="index, follow" />
 
 
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
<?php 
echo $canon_meta;
?>
  <link href="<?php echo $patH?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
 

<script src="<?php echo $patH?>/js/jquery.min1.7.1.js"></script>

<link rel="stylesheet" href="<?php echo $patH?>/colorbox/colorbox1.css" />  



<link href="<?php echo $patHA?>/css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />

 
 	<script type="text/javascript" src="<?php echo $patH?>/admin/js/js.js"></script> 

<script src="<?php echo $patH?>/colorbox/jquery.colorbox.js"></script>          

 
<?php 
 
 
if($_SESSION[userids]>0)
{
?>
<script type="text/javascript">
 obnovi_sessiju();
 </script>
<?php 
}
 
?>
 
 
    
 

<!-- Beginning of compulsory code below -->

<link href="<?php echo $patHA?>/css/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $patHA?>/css/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="<?php echo $patHA?>/js/jquery/jquery.dropdown.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo $patH?>/css/jquery.datepick.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $patH?>/js/jquery.datepick.js"></script>
<script>
$(function() {
	$('#popupDatepicker').datepick();
	
});
</script>
</head>
 
<body style="padding:10px;">


<table class='registracija_naslov'>
<tr>
<td style='width:510px'>
<div class='naslov_smestaj'><h1>Prikaži na poziciji</h1></div>
</td>
<td>

</td>
</table>
<br class='clear' />
<form enctype="multipart/form-data" action="" method="post" class='gf-form' id="contactform" >
 
<?php 
 
if($_POST[show_settings])
{
mysqli_query($conn, "DELETE FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip]");
foreach($_POST[ch] as $key => $value)
{
if($value>0)
{
$linkav=$_POST["lin"][$key]; 

$pop=$_POST["pop"][$key];
$dod=$_POST["dod"][$key];
if($dod!="") $det=1; else $det=$_POST["det"][$key];
mysqli_query($conn, "INSERT INTO settings_show SET idupisa=$_GET[id], tip='$_GET[tip]', shows='$value', link='$linkav', link_details='$det', popup='$pop', dod_link='$dod'");
}
}
}

 
 

$nin=array("","Prikaži levo","Prikaži desno","Prikaži dole","Prikaži na vrh");
?>

 
<br />
<table style='width:100%;'>
<?php 
$of=mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip] ORDER BY shows ASC");
while($of1=mysqli_fetch_array($of))
{
?>
<tr>
<td>
Prikaži na linku
</td>
<td>
<input type='text' value='<?php echo $of1[link]?>' name='lin[]' style='width:280px;' />
</td>
<td>
Dodeli link
</td>
<td>
<input type='text' value='<?php echo $of1[dod_link]?>' name='dod[]' style='width:250px;' />
</td>
<td>
<?php 
if($of1[link_details]==1) $det="checked"; else $det="";
if($of1[popup]==1) $pop="checked"; else $pop="";
?>
Link detaljno <input type='checkbox' <?php echo $det?> name='det[]' value='1'>
</td>
<td>
PopUp link <input type='checkbox' <?php echo $pop?> name='pop[]' value='1'>
</td>
<td>

<select name='ch[]'>
<option value=''>---</option>
<?php 
for($i=1;$i<count($nin);$i++)
{
if($i==$of1[shows]) $ch="selected"; else $ch="";
echo "<option value='$i' $ch> $nin[$i]</option>";
}
?>
</select>
</td>
<td>
<a href='<?php echo $patHA?>/settings_show.php?id=<?php echo $_GET[id]?>&tip=<?php echo $_GET[tip]?>&del=<?php echo $of1[shows]?>'>delete</a>
</td>
</tr>
<?php 
}
?>
<tr>
<td>
Prikaži na linku
</td>
<td>
<input type='text' value='' name='lin[]' style='width:280px;' />
</td>
<td>
Dodeli link
</td>
<td>
<input type='text' value='' name='dod[]' style='width:250px;' />
</td>
<td>
Link detaljno <input type='checkbox' name='det[]' value='1'>
</td>
<td>
PopUp link <input type='checkbox' name='pop[]' value='1'>
</td>
<td>

<select name='ch[]'>
<option value=''>---</option>
<?php 
for($i=1;$i<count($nin);$i++)
{
//if(${'ch'.$i}=="checked") $link=${'link'.$i}; else $link="";
echo "<option value='$i'> $nin[$i]</option>";
}
?>
</select>
</td>
<td>
</td>
</tr>
</table> 
 <br />
   
			<input  type="submit"  name="show_settings" class='submit_dugmici_blue' value="SAČUVAJ IZMENE" id="submitButton" />			
   
      
      
      
 
 



 </form>
</body>
</html>
