<header class="site-navbar js-sticky-header site-navbar-target" role="banner">
	<div class="float-left">
		<?php if($log1['slika']!="") { ?>
		<div class="site-logo">
			<a href="<?php echo $patH1?>"><img src="galerija/<?php echo $log1['slika']?>" alt="<?php echo $log1['alt']?>" title="<?php echo $log1['title']?>"></a>
		</div>
		<?php } ?>
	</div>
    <div class="container">		
	   <div class="navbar-expand-lg row align-items-center position-relative">			
            <!-- <a href="javascript:void(0)" class="navbar-brand">MENU</a> -->
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
			<div class="col-lg-12">
				<nav class="site-navigation text-right ml-auto " role="navigation">
                <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
<?php
$menuArr=array();
$menuArrp=array();
$me = mysqli_query($conn, "SELECT m.*, p.*, pl.*, m.id as ide, m.nivo as nivos, m.id_parent as parent
        FROM menus_list m
        INNER JOIN pagel pl ON m.id = pl.id_page
        INNER JOIN page p ON m.id = p.id
        WHERE p.akt=1 AND m.id_menu=4 AND pl.lang='$lang' GROUP BY p.id ORDER BY -m.position DESC");
		
while($me1=mysqli_fetch_assoc($me))
{
$menuArr[$me1['nivos']][]=$me1;
$menuArrp[$me1['parent']][]=$me1['parent'];
}
$benuArr=array();
$benuArrp=array();
$nArrp=array();

$ce=0;
foreach($menuArr[1] as $ke => $me1)
{
if($me1['class_for_icon']!="") $uklas=$me1['class_for_icon']." "; else $uklas="";
if($page1['id']==$me1['ide']) $curre=' active'; else $curre="";
if($menuArrp[$me1['ide']] && count($menuArrp[$me1['ide']])>0)
$arrdole=" <span class='far fa-chevron-down'></span>"; else $arrdole="";

if(is_array($menuArrp[$me1['ide']])) $prom=count($menuArrp[$me1['ide']]); else $prom=0;
if($prom>0) $ulinka="javascript:void(0)";
else $ulinka=$patH1."/".$me1['ulink']."/";
if(substr($ulinka, -2)=="//") $ulinka=$patH1."/".$me1['ulink']; else $ulinka=$patH1."/".$me1['ulink']."/";
if($menuArrp[$me1['ide']] && count($menuArrp[$me1['ide']])>0) {
$li='<li class="has-children">';
$ul='<ul class="dropdown arrow-top">';
$no_li='<!-- test1 -->';
$close_ul='</ul>';
$klasa="nav-link";
$dat='';
}
else {
$li='<li>';
$no_li='<!-- test2-->';
$klasa="nav-link";
$ul='';
$dat='';
}
echo $li;
?>
		<a class="<?php echo $klasa.$curre?>" <?php echo $dat?> href="<?php echo $ulinka?>" title="<?php echo $me1['naziv']?>"><?php echo $uklas.$me1['naziv']?></a><?php echo $no_li ?>
<?php
echo $ul;
if($menuArrp[$me1['ide']] && count($menuArrp[$me1['ide']])>0){
foreach($menuArr[2] as $ce => $ze1) {
if($me1['ide']==$ze1['parent']) {
if($ze1['ulink']!="") $ulinka1=$ze1['ulink']."/"; else $ulinka1="";
if($me1['ulink']!="") $ulinkar=$me1['ulink']."/"; else $ulinkar="";
if(preg_match("/.php/",$ze1['ulink']))
$ulinka1=$ze1['ulink'];
if($ze1['class_for_icon']!="") $uklas1="<i class='".$ze1['class_for_icon']." ic2nivo'></i> "; else $uklas1="";
if($menuArrp[$ze1['ide']] && count($menuArrp[$ze1['ide']])==1)
$link2="javascript:void(0)";
else $link2=$patH1."/".$ulinka1;
if($menuArrp[$ze1['ide']] && count($menuArrp[$ze1['ide']])>0)
$arrde=" <span class='far fa-chevron-right'></span>"; else $arrde="";
?>
<li><a class="dropdown-item" href="<?php echo $link2?>" title="<?php echo $ze1['naziv']?>"><?php echo $uklas1.$ze1['naziv']?><?php echo $arrde?></a></li>
<?php
}
}
echo $close_ul; 

echo $no_li;
?>

<?php } ?>

<?php $ce++; } ?>
				</div>
				</ul>
			</nav>
			<div class="toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>
	</div>
	</div>
</header>








