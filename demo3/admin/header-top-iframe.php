<?php session_start();$sid=session_id();include("../Connections/conn_admin.php");$instgram_show=0;$page_path3 ="$page_path2/".SUBFOLDER."admin";$patHA=$patH."/admin";$ip=getenv('REMOTE_ADDR');$search_values=explode("?",strip_tags(curPageURL()));if($search_values[1]);parse_str($search_values[1],$sarray);$base=strip_tags($_GET['base']);$page=strip_tags($_GET['page']);$id_get=strip_tags($_GET['id']);$idu=strip_tags($_GET['idu']);$idp=strip_tags($_GET['idp']);$id_page=strip_tags($_GET['id_page']);$page_tr=preg_replace('#[^0-9]#i', '', $_GET['p']);$id_cat_get=preg_replace('#[^0-9]#i', '', $_GET['id_cat']);$id_user_get=preg_replace('#[^0-9]#i', '', $_GET['id_user']);$id_paket_get=preg_replace('#[^0-9]#i', '', $_GET['paket']);$id_get=preg_replace('#[^0-9]#i', '', $_GET['id']);$id_kat_get=preg_replace('#[^0-9]#i', '', $_GET['id_kat']);$id_page_get=preg_replace('#[^0-9]#i', '', $_GET['id_page']);$tip=strip_tags($_GET['tip']);$query_all=explode("?",curPageURL());include("$page_path3/Izvrsenja.php");require_once "$page_path2/".SUBFOLDER."paginate/Paginated.php";require_once "$page_path2/".SUBFOLDER."paginate/DoubleBarLayoutAdmin.php";?><!DOCTYPE html><html lang="sr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="IE=9" ><meta http-equiv="Content-Language" content="sr" /><script src="<?php echo $patH?>/admin/js/jquery.min1.7.1.js"></script><link rel="stylesheet" href="../css/style.php"><link href="<?php echo $uvoz?>/css/bootstrap.min.css" rel="stylesheet"><link href="<?php echo $uvoz?>/css/default.css" rel="stylesheet"><link rel="stylesheet" href="<?php echo $patH?>/colorbox/colorbox1.css" /><link rel="stylesheet" href="<?php echo $patH?>/fonts/pro/css/fontawesome-all.min.css" /><link rel="stylesheet" href="<?php echo $uvoz?>/css/responsive.css"><link href="<?php echo $patHA?>/css/style.css" media="screen, projection" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo $patH?>/admin/js/js.js"></script> <script src="<?php echo $patH?>/colorbox/jquery.colorbox.js"></script>          <?php if($_SESSION['userids']>0){?><script type="text/javascript"> obnovi_sessiju(); </script><?php }?> <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script><script type="text/javascript" src="multiselectUI/jquery.multiselect.js"></script>  <script type="text/javascript" src="multiselectUI/jquery.multiselect.filter.js"></script>  <!-- Beginning of compulsory code below --><link href="<?php echo $uvoz?>/css/default.advanced.css" media="screen" rel="stylesheet" type="text/css" /><!--[if lt IE 7]><script type="text/javascript" src="<?php echo $patHA?>/js/jquery/jquery.dropdown.js"></script><![endif]--><script type="text/javascript">	$(document).ready(function(){		$(".ui-tabs").tabs();	});</script><script>$(function() {$('.selectG1').fSelect({        placeholder: ' --- ',        searchText: "Pronadji",        overflowText: "Izabrali ste {n}",        });});</script></head><body>