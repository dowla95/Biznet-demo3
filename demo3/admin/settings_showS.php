<?php 
session_start();
$sid=session_id();
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
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
  <link rel="stylesheet" type="text/css" href="<?php echo $patH?>/multiselect/doc/smoothness-1.8.13/jquery-ui-1.8.13.custom.css">
 
 
    <script type="text/javascript" src="<?php echo $patH?>/multiselect/doc/jquery-ui-1.8.13.custom.min.js"></script>
    
 
    
    <script type="text/javascript" src="<?php echo $patH?>/multiselect/doc/ui.dropdownchecklist-1.4-min.js"></script>
    
 
    <script type="text/javascript">
        $(document).ready(function() {
            $("#s1").dropdownchecklist();
  $(".s2").dropdownchecklist( {icon: {}, emptyText: "<?php echo $langa['forma_search19']?>...", width: 200 } );
  $(".s22").dropdownchecklist( {icon: {}, emptyText: "<?php echo $langa['forma_search17']?> ...", width: 200 } );
 $(".s23").dropdownchecklist( {icon: {}, emptyText: "<?php echo $langa['forma_search2']?> ...", width: 200 } );  
 $(".s24").dropdownchecklist( {icon: {}, emptyText: "<?php echo $langa['forma_search1a']?> ...", width: 200 } );
    $(".s3").dropdownchecklist( {icon: {}, emptyText: "<?php echo $langa['forma_search18']?>", width: 200 , maxDropHeight: 400} );
   $(".s4").dropdownchecklist( {icon: {}, emptyText: "<?php echo $langa['forma_search16']?>...", width: 200, maxDropHeight: 400 } );
$(".s7").dropdownchecklist( {icon: {}, emptyText: "<?php echo $langa['forma_search20']?>...", width: 200 , maxDropHeight: 400} );
            $("#s3").dropdownchecklist( { width: 150, maxDropHeight: 400 } );
            $("#s4").dropdownchecklist( { maxDropHeight: 150, maxDropHeight: 400 } );
            $("#s5").dropdownchecklist( { firstItemChecksAll: true, explicitClose: '...close' } );
 
 
        });
    </script>
       <script type="text/javascript" src="<?php echo $patH?>/js/jquery.placeholder.js"></script>
   <script type="text/javascript">
    $(function() {
    // Invoke the plugin
    $('input, textarea').placeholder();
    // That’s it, really.
    // Now display a message if the browser supports placeholder natively
 
   });
  </script>
 

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
foreach($_POST[ch] as $keh => $value)
{
if($value>0)
{
$linkav=$_POST["lin$value"]; 
mysqli_query($conn, "INSERT INTO settings_show SET idupisa=$_GET[id], tip=$_GET[tip], shows=$value, link='$linkav'");
}
}
}

 
if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip] AND shows=1"))>0) 
{
$aa=mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip] AND shows=1");
$aa1=mysqli_fetch_array($aa);
$ch1="checked";
$link1=$aa1[link];
}
if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip] AND shows=2"))>0) 
{
$bb=mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip] AND shows=2");
$bb1=mysqli_fetch_array($bb);
$ch2="checked";
$link2=$bb1[link];
}
if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip] AND shows=3"))>0) 
{
$cc=mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip] AND shows=3");
$cc1=mysqli_fetch_array($cc);
$ch3="checked";
$link3=$cc1[link];
}
if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip] AND shows=4"))>0) 
{
$dd=mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$_GET[id] AND tip=$_GET[tip] AND shows=4");
$dd1=mysqli_fetch_array($dd);
$ch4="checked";
$link4=$dd1[link];
}


$nin=array("","Prikaži levo","Prikaži desno","Prikaži dole","Prikaži na vrh");
?>

 
<br />
<?php 
for($i=1;$i<count($nin);$i++)
{
if(${'ch'.$i}=="checked") $link=${'link'.$i}; else $link="";
echo "Prikaži na linku: <input type='text' value='$link' name='lin$i' style='width:300px;' /> - <input type='checkbox' name='ch[]' value='$i' ".${'ch'.$i}."> $nin[$i]<br />";
}
?>
 
 <br />
   
			<input  type="submit"  name="show_settings" class='submit_dugmici_blue' value="SAČUVAJ IZMENE" id="submitButton" />			
   
      
      
      
 
 



 </form>
</body>
</html>
