<?php 
session_start();
$sid=session_id();
include("../Connections/conn_admin.php");
$instgram_show=0;
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
$ip=getenv('REMOTE_ADDR');
$search_values=explode("?",strip_tags(curPageURL()));
if($search_values[1]);
parse_str($search_values[1],$sarray);
$base=strip_tags($_GET['base']);
$page=strip_tags($_GET['page']);
$id_get=strip_tags($_GET['id']);
$idu=strip_tags($_GET['idu']);
$idp=strip_tags($_GET['idp']);
$id_page=strip_tags($_GET['id_page']);
$page_tr=preg_replace('#[^0-9]#i', '', $_GET['p']);
$id_city_get=preg_replace('#[^0-9]#i', '', $_GET['id_city']);
$id_cat_get=preg_replace('#[^0-9]#i', '', $_GET['id_cat']);
$id_user_get=preg_replace('#[^0-9]#i', '', $_GET['id_user']);
$id_paket_get=preg_replace('#[^0-9]#i', '', $_GET['paket']);
$id_get=preg_replace('#[^0-9]#i', '', $_GET['id']);
$id_kat_get=preg_replace('#[^0-9]#i', '', $_GET['id_kat']);
$id_page_get=preg_replace('#[^0-9]#i', '', $_GET['id_page']);
$tip=strip_tags($_GET['tip']);
$query_all=explode("?",curPageURL());
include("$page_path3/Izvrsenja.php");
require_once "$page_path2/".SUBFOLDER."paginate/Paginated.php";
require_once "$page_path2/".SUBFOLDER."paginate/DoubleBarLayoutPoslodavci.php";
if($_SESSION['userids']>0){
$che=mysqli_query($conn, "SELECT * FROM users_admin WHERE user_id=$_SESSION[userids]");
$che1=mysqli_fetch_assoc($che);
$age=$che1['agencija'];
$doz_br_bio=$che1['dozvoljen_br_biografija'];
$usid=$che1['user_id'];
}
if($_SESSION['emails']!="aleksandrou@gmail.com") $skloni="display:none;";
$my=mysqli_query($conn, "SELECT * FROM settings");
while($my1=@mysqli_fetch_array($my))
{
$upa=$my1['fields'];
$settings[$upa]=$my1['vrednosti'];
}
$uk_users=mysqli_query($conn, "SELECT * FROM users_data");
$uk_users1=mysqli_num_rows($uk_users);
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
<script src="<?php echo $patH?>/admin/js/jquery.min1.7.1.js"></script>
<link rel="stylesheet" href="<?php echo $patH?>/colorbox/colorbox1.css" />
<link href="<?php echo $patHA?>/css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
 	<script type="text/javascript" src="<?php echo $patH?>/admin/js/js.js"></script>
<script src="<?php echo $patH?>/colorbox/jquery.colorbox.js"></script>
<?php 
if($_SESSION['userids']>0)
{
?>
<script type="text/javascript">
 obnovi_sessiju();
 </script>
<?php 
}
?>
 <script type="text/javascript" src="<?php echo $patHA?>/js/jquery-ui-1.8.23.custom.min.js"></script>
 <?php 
 if($_GET['page']!="page_add")
 {
 ?>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
 <?php } ?>
 <link rel="stylesheet" type="text/css" href="multiselectUI/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="multiselectUI/jquery.multiselect.filter.css" />
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript" src="multiselectUI/jquery.multiselect.js"></script>
  <script type="text/javascript" src="multiselectUI/jquery.multiselect.filter.js"></script>
  <script>
  $(function() {
   $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  </script>
<!-- Beginning of compulsory code below -->
<link href="<?php echo $uvoz?>/css/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $uvoz?>/css/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />
<!--[if lt IE 7]>
<script type="text/javascript" src="<?php echo $patHA?>/js/jquery/jquery.dropdown.js"></script>
<![endif]-->
 <script>
	$(document).ready(function(){
//  	$(".iframe").colorbox({iframe:true, width:"97%", height:"300px"});
    $(".iframes").colorbox({iframe:true, width:"330px", height:"300px"});
    $(".iframes1").colorbox({iframe:true, width:"90%", height:"800px"});
    $(".iframe_cal").colorbox({iframe:true, width:"300px", height:"450px"});
      $(".inline").colorbox({
        inline: true,
        width: "600px"
    });
$(".mselect").multiselect({
   height: 400
}).multiselectfilter();
     })
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".ui-tabs").tabs();
	});
</script>
<script>
$(function() {
$('.selectG1').fSelect({
        placeholder: ' --- ',
        searchText: "Pronadji",
        overflowText: "Izabrali ste {n}",
        });
});
</script>
</head>
<body>