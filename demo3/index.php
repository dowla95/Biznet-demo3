<?php
header('X-Frame-Options: GOFORIT');
session_start();
$sid=session_id();
include("Connections/conn.php");
include(SUBFOLDERS."include/Izvrsenja.php");
require_once SUBFOLDERS."paginate/Paginated.php";
require_once SUBFOLDERS."paginate/DoubleBarLayoutPoslodavci.php";
if($nstop==100444)
{
$titles=$langa['apart-stef43'];
header("Status: 404 Not Found");
 //@include(SUBFOLDERS."/404.php");
$error_page = file_get_contents($patH.'/404/');
echo $error_page;
exit;
}
if($_SESSION['userid']>0) $logovan=1; else $logovan="";
if($sarray['logout']==1)
{
if(isset($_COOKIE['ipcookname']) && isset($_COOKIE['ipcookpass'])){
   //setcookie("ipcookname", "", time()-60*60*24*100, "/");
   setcookie("ipcookpass", "", time()-60*60*24*100, "/");
}
   /* Kill session variables */
   unset($_SESSION['email']);
   unset($_SESSION['password']);
   unset($_SESSION['userid']);
   unset($_SESSION['korisnik']);
  // session_destroy();   // destroy session.
    header("Location: $patH1");
    }
if(isset($_COOKIE['soglasi']) and $_COOKIE['soglasi']!="")
{
$lz_niz=explode(",",$_COOKIE['soglasi']);
}
$isporuceno=0;
if(isset($sarray['zanemari-kod']) and $sarray['zanemari-kod']==1){
unset($_SESSION['promo-kod']);
header("location: ".$search_values[0]);
}
?>
<!DOCTYPE html>
<html lang="sr" itemscope itemtype="http://schema.org/WebPage">
<head prefix="og: http://ogp.me/ns#; dcterms: http://purl.org/dc/terms/#">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $titles?></title>
<meta name="description" content="<?php echo $descripts?>" />
<meta name="author" content="http://www.webdizajne.rs">
<meta property="og:title" content="<?php echo $titles?>" />
<meta property="og:url" content="<?php echo $patH.'/'?>" />
<meta property="og:type" content="website" />
<meta property="og:description" content="<?php echo $descripts?>" />
<meta property="og:image" content="<?php echo $patH.'/slike/logo.png'?>" />
<meta name="dcterms:title" content="<?php echo $titles?>" />
<meta name="dcterms:description" content="<?php echo $descripts?>" />
<meta name="dcterms:subject" content="" />
<meta name="dcterms:type" lang="sr" content="" />
<meta name="dcterms:format" content="text/xml" />
<meta name="dcterms:creator" content="Goran Stojanovic BIZNET http://www.webdizajne.rs" />
<meta name="dcterms:contributor" content="http://www.obrenovac.biz" />
<meta itemprop="name" content="<?php echo $titles?>" />
<meta itemprop="description" content="<?php echo $descripts?>" />
<meta name="geo.position" content="" />
<meta name="geo.placename" content="" />
<meta name="p:domain_verify" content=""/>
<base href="<?php echo $patH1?>/">
<?php
if(isset($dztz1['canurl']) and strlen($dztz1['canurl'])>3){
?>
<link rel="canonical" href="<?php echo $dztz1['canurl']?>" />
<?php
}
?>
<link rel="stylesheet" href="css/style.php">
<meta name="theme-color" content="<?php echo $glavna?>">
    <link href="<?php echo $patH?>/fonts/pro/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,700|Oswald:400,700" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/aos.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
	
<?php
$favicon = mysqli_query($conn, "SELECT * FROM slike, slike_lang WHERE slike.id=slike_lang.id_slike AND slike.akt='Y' AND slike.tip=3 AND slike.subtip=3");
$favicon1=mysqli_fetch_array($favicon);
$log = mysqli_query($conn, "SELECT * FROM slike, slike_lang WHERE slike.id=slike_lang.id_slike AND slike.akt='Y' AND slike.tip=3 AND slike.subtip=1");
$log1=mysqli_fetch_array($log);
if($favicon1['slika']!="") {
?>
<link rel="shortcut icon" href="<?php echo $patH?>/galerija/<?php echo $favicon1['slika']?>">
<?php
}
if(isset($_SESSION['addTrans']) and $_SESSION['addTrans']!=""){
?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-68293561-1']);
  _gaq.push(['_trackPageview']);
<?php echo $_SESSION['addTrans']; ?>
<?php echo $_SESSION['addItems']; ?>
<?php
if($addItems!="")
echo "_gaq.push(['_trackTrans']);";
?>
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php
unset($_SESSION['addTrans']);
unset($_SESSION['addItems']);
}
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php echo $settings['ganal']?>
<!-- Global site tag (gtag.js) - Google Ads: 668986843 --> <script async src="https://www.googletagmanager.com/gtag/js?id=AW-668986843"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-668986843'); </script>
<?php if($page1['id']==34) { ?>
<!-- Event snippet for Purchase conversion page --> <script> gtag('event', 'conversion', { 'send_to': 'AW-668986843/T_n6COXticIBENvb_74C', 'transaction_id': '' }); </script>
<?php } ?>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-aos-easing="slide" data-aos-duration="800" data-aos-delay="0" data-aos-offset="300">
  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  
	<div class="site-wrap"  id="home-section">
	
		<div class="site-mobile-menu site-navbar-target">
			<div class="site-mobile-menu-header">
				<div class="site-mobile-menu-close mt-3">
					<span class="icon-close2 js-menu-toggle"></span>
				</div>
			</div>
			<div class="site-mobile-menu-body"></div>
		</div>
	
            <div class="top-bar">
                <div class="container">
                    <div class="row">                        
                        <div class="col-lg-9">							
								<div class="d-inline-block text-white">
                                    <span>8:00 - 9:00</span>
                                    <p>Opening Hours: Mon - Fri</p>
                                </div>
								<span class="mx-md-2 d-inline-block"></span>
                                <div class="d-inline-block text-white">
                                    <span><a href="tel:<?php echo $settings['tel-sin']?>" class="text-white"><?php echo $settings['tel-header']?></a></span>
                                    <p>Call us...</p>
                                </div>							
						</div>
						<div class="col-lg-3">
                            <div class="float-right">
                                <div class="social">
									<?php if($settings['google']!="") {?><a href="<?php echo $settings['google']?>" class="text-white" target="_blank"><i class="fas fa-map-marker-alt"></i></a><?php }?>
									<?php if($settings['facebook']!="") {?><a href="<?php echo $settings['facebook']?>" class="text-white" target="_blank"><i class="fab fa-facebook"></i></a><?php }?>
									<?php if($settings['twitter']!="") {?><a href="<?php echo $settings['twitter']?>" class="text-white" target="_blank"><i class="fab fa-twitter"></i></a><?php }?>
									<?php if($settings['linkedin']!="") {?><a href="<?php echo $settings['linkedin']?>" class="text-white" target="_blank"><i class="fab fa-linkedin"></i></a><?php }?>
									<?php if($settings['instagram']!="") {?><a href="<?php echo $settings['instagram']?>" class="text-white" target="_blank"><i class="fab fa-instagram"></i></a><?php }?>
									<?php if($settings['youtube']!="") {?><a href="<?php echo $settings['youtube']?>" class="text-white" target="_blank"><i class="fab fa-youtube-square"></i></a><?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include_once('header.php'); ?>
<?php 
if($page1['class_for_icon1']!="") $klass=" class='$page1[class_for_icon1]'"; else $klass="";
if($contM>0 or $zgeM>0)
{
$layGD="layM";
$gd=0;
//echo $arrayM[0]." aaa ".$arrayM[1]." bbb ".$arrayM[2].$contM;
foreach($arrayM as $ke=> $va)
{
$layP="layM";
$lokac="middle";
if(isset($sarray['pron']) and $sarray['pron']==2)
include_once(SUBFOLDERS."include-pages/middle/include/pretraga-teksta.php");
else
if(isset($sarray['pron']) and ($sarray['pron']==1 or $sarray['pron']==3))
include_once(SUBFOLDERS."include-pages/middle/include/pretraga-proizvoda.php");
else
if(mb_eregi("text-", $va))
include(SUBFOLDERS."include-pages/text-velika-slika.php");
else
if(is_file(SUBFOLDERS."include-pages/$lokac/$va"))
{
include_once(SUBFOLDERS."include-pages/$lokac/$va");
}
}
}
?>
<?php include_once('footer.php');
mysqli_close($conn);
?>