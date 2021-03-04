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
				
<?php
$menuArr=array();
$menuArrp=array();
$me = mysqli_query($conn, "SELECT m.*, p.*, pl.*,m.id as ide, m.nivo as nivos, m.id_parent as parent
        FROM menus_list m
        INNER JOIN pagel pl ON m.id = pl.id_page
        INNER JOIN page p ON m.id = p.id
        WHERE p.akt=1 AND m.id_menu=4  AND pl.lang='$lang' GROUP BY p.id ORDER BY -m.position DESC");
$ce=0;
while($me1=mysqli_fetch_assoc($me))
{
$menuArr[$me1['nivos']][]=$me1;
$menuArrp[$me1['parent']][]=$me1['parent'];
}
$benuArr=array();
$benuArrp=array();
$nArrp=array();
$tz = mysqli_query($conn,"SELECT p.*, pt.*, p.id as ide, p.id_parent as parent
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND (p.id_cat=32) ORDER BY p.position ASC");
   while($me1=mysqli_fetch_array($tz))
     {
$benuArr[$me1['nivo']][]=$me1;
$benuArrp[$me1['parent']][]=$me1;
$nArrp[$me1['ide']]=$me1;
}
?>

<ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">

<?php

$ce=0;
foreach($menuArr[1] as $ke => $me1)
{
if($me1['class_for_icon']!="") $uklas=$me1['class_for_icon']." "; else $uklas="";
if($page1['id']==$me1['ide']) $curre=' active'; else $curre="";

if(preg_match("/.php/",$mel['ulink']))
$ulinka0=$mel['ulink'];

// Proverava da li lista ima dropdown
// Ukoliko ima dodeljuje classu "has-children"; Ne dozvoljava da vodi na tu stranicu; dodaje stelicu ka dropdown listi

if($menuArrp[$me1['ide']] && count($menuArrp[$me1['ide']])>0){
$li='<li class="has-children">';
$ulinka="javascript:void(0)";
$arrdole=" <span class='far fa-chevron-down'></span>";
}
else{
$li='<li>';
$ulinka=$patH1."/".$ulinka0;
$arrdole="";	
}
echo $li;
?>
<a class="nav-link <?php echo $curre?>" href="<?php echo $ulinka?>" title="<?php echo $me1['naziv']?>"><?php echo $uklas.$me1['naziv']?></a>
<?php
if($menuArrp[$me1['ide']] && count($menuArrp[$me1['ide']])>0){
?>
<ul class="dropdown arrow-top">
  <?php
foreach($menuArr[2] as $ce => $ze1)
{
if($me1['ide']==$ze1['parent']) {
if($ze1['ulink']!="") $ulinka1=$ze1['ulink']."/"; else $ulinka1="";
if($me1['ulink']!="") $ulinkar=$me1['ulink']."/"; else $ulinkar="";
if($ze1['class_for_icon']!="") $uklas1="<i class='".$ze1['class_for_icon']." ic2nivo'></i> "; else $uklas1="";

if(preg_match("/.php/",$ze1['ulink']))
$ulinka1=$ze1['ulink'];

// Proverava da li lista ima dropdown
// Ukoliko ima dodeljuje classu "has-children"; Ne dozvoljava da vodi na tu stranicu; dodaje stelicu ka dropdown listi

if($menuArrp[$ze1['ide']] && count($menuArrp[$ze1['ide']])>0){
$li2='<li class="has-children">';
$link2="javascript:void(0)";
$arrde=" <span class='far fa-chevron-right'></span>";
}
else{
$li2='<li>';
$link2=$patH1."/".$ulinka1;	
$arrde="";
}
echo $li2;
?><a class="dropdown-item" href="<?php echo $link2?>" title="<?php echo $ze1['naziv']?>"><?php echo $uklas1.$ze1['naziv']?></a>
<?php
if($menuArrp[$ze1['ide']] && count($menuArrp[$ze1['ide']])>0){
?>
<ul class="dropdown arrow-top">
<?php
foreach($menuArr[3] as $de => $te1)
{
if($ze1['ide']==$te1['parent']) {
if($te1['ulink']!="") $ulinka1=$te1['ulink']."/"; else $ulinka1="";
if($me1['ulink']!="") $ulinkar=$me1['ulink']."/"; else $ulinkar="";
if($te1['class_for_icon']!="") $uklas2="<i class='".$te1['class_for_icon']." ic2nivo'></i> "; else $uklas2="";

if(preg_match("/.php/",$te1['ulink']))
$ulinka1=$te1['ulink'];

// Proverava da li lista ima dropdown
// Ukoliko ima dodeljuje classu "has-children";

if($menuArrp[$te1['ide']] && count($menuArrp[$te1['ide']])>0){
$li3='<li class="has-children">';
}
else{
$li3='<li>';	
}
echo $li3;
?><a class="dropdown-item" href="<?php echo $patH1?>/<?php echo $ulinka1?>" title="<?php echo $te1['naziv']?>"><?php echo $uklas2.$te1['naziv']?></a></li>
<?php
}
}
?>
</ul>
<?php
}
?>
 </li>
<?php
}
}
?>
</ul>
<?php
}

?>
 </li>
<?php
$ce++;
}
?>
</ul>
			</nav>
			<div class="toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>
	</div>
	</div>
</header>








