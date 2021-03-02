<?php
$ByPage1=10;
$page_cur=$sarray['p'];  
$ukupnos = mysqli_num_rows(mysqli_query($conn, "SELECT p.*, pt.*
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text        
        WHERE pt.lang='$lang'  AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst"));
$pagedResults = new Paginated($ukupnos, $ByPage1, $page_cur);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout()); 

$pte = mysqli_query($conn, "SELECT p.*, pt.*
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text        
        WHERE pt.lang='$lang'  AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst ORDER BY time DESC LIMIT $str,$ByPage1");

$pte4 = mysqli_query($conn, "SELECT p.*, pt.*, p.id as id
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text        
        WHERE p.tipus=8 AND pt.lang='$lang' AND p.youtube<>'' AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst ORDER BY p.pozicija ASC LIMIT 1");
?>

<div class="page-header">
	<div class="bg-light">
        <div class="container">
            <div class="text-center mb-5">
<?php while($pte5=mysqli_fetch_assoc($pte4)) { ?>
				<div class="block-heading-1">
					<h1><?php echo $pte5['youtube']?></h1>
				</div>	
<?php } ?>
                
					<div class="block-heading-1">
					<a href="<?=$patH?>">Naslovna</a>
<?php if($base_arr_r[0]==$sodom_ex[0]) echo "<a href='javascript:void()'>Blog</a>"; else {
$ptnja = mysqli_query ($conn, "SELECT naslov FROM pages_text_lang WHERE ulink='$base_arr_r[0]'");
$ptnja1 = mysqli_fetch_array($ptnja);
?>
							<a href="<?=$patH?>/blog/">Blog</a>
							<a href='javascript:void()'><?=$ptnja1['naslov']?></a>
<?php } ?>
					</div>
                
            </div>
        </div>
	</div>
</div>
	
<div class="page-section pb-3">
<div class="container">
<div class="row">

<?php include('middle/include/slidebar-left-blog.php');?>

<div class="col-lg-9 order-first order-lg-last">
<?php
if($idup=="") {
$ptenum=mysqli_num_rows($pte);
if($ptenum==0) $br=0;
//if ($br==0)
//echo "<h1>".$page1['h1']."</h1>"; else echo "";
while($pte1=mysqli_fetch_assoc($pte))
{
$stropis1=strlen($pte1["opis1"]);
$stropis2=strlen($pte1["opis"]);

if($pte1["ulink"]!="") {
$link_det="<a href='".$patH1."/".$page1["ulink"]."/".$pte1["ulink"]."/'>";
$link_det1="</a>";
}
if($idup=="" and $stropis1>10 and $stropis2>10)
	
// pocetak izlistavanja kada su popunjena oba editora
{
if($pte1['full_img_width']==0) $ord1="2" and $ord2="1"; else $ord1="1" and $ord2="2";
if($pte1['polapola']==1) $co1="6" and $co2="6"; else $co1="4" and $co2="8";
?>
                            <div class="col-md-12">
                                <div class="single-blog-post gallery-type-post mb-40">
                                    <div class="row">
										<div class="col-12">
											<div class="single-blog-post-content">
                                                <div class="post-meta">
													<h3 class="post-title"><?php echo $link_det.$pte1["naslov"].$link_det1;?></h3>
													<p>
														<span><i class="fa fa-user"></i> Admin</span>
														<span class="separator">|</span>
														<span><i class="fal fa-clock"></i> <?php echo date("H:i",$pte1['time'])?></span>
														<span class="separator">|</span>
														<span><i class="fal fa-calendar-alt"></i> <?php echo datum(date("Y-m-d",$pte1['time']))?></span>
													</p>
												</div>
											</div>
										</div>
                                        <div class="col-md-<?php echo $co1?> order-<?=$ord2?>">
                                            <div class="single-blog-post-media mb-sm-20">
                                                <div class="blog-image-gallery">
<?php
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]"))
{
$wh=explode("-",image_size1(170,128,$pte1['slika']));
?>
                                                    <div class="single-image">
                                                        <?php echo $link_det?>
														<!-- Slika u zbirom prikazu kada su popunjema oba editora -->
                                                        <img class="img-fluid" src="<?=$patH?><?php echo GALFOLDER ?>/<?php echo $pte1['slika']?>" alt="<?php echo $pte1["altslike"]?>" title="<?php echo $pte1["titleslike"]?>" />
                                                        <?php echo $link_det1?>
                                                    </div>
<?php } ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-<?php echo $co2?> order-<?=$ord1?>">
                                            <div class="single-blog-post-content">
                                                <div class="post-excerpt"><?php echo $pte1["opis1"];?></div>
<?php echo "<a class='btn btn-primary text-white float-right' href='".$patH1."/".$page1["ulink"]."/".$pte1["ulink"]."/'>OPŠIRNIJE</a>";?>
                                            </div>
                                        </div>
                                    </div>
									<hr>
                                </div>
                            </div>
                           

<?php
$br++;
}
// kraj izlistavanja kada su popunjena oba editora
else
/**********************************************************************************
pocetak izlistavanja kada je popunjen samo donji editor
**********************************************************************************/
if($idup=="" and $stropis1<10 and $stropis2>10)
{
if($pte1['full_img_width']==0) $ord1="2" and $ord2="1"; else $ord1="1" and $ord2="2";
if($pte1['polapola']==1) $co1="6" and $co2="6"; else $co1="4" and $co2="8";
?>

                            <div class="col-md-12">
                                <div class="single-blog-post gallery-type-post mb-40">
                                    <div class="row">
										<div class="col-12">
											<div class="single-blog-post-content">
											    <h3 class="post-title"><?php echo $link_det?><?php echo $pte1["naslov"];?><?php echo $link_det1?></h3>
                                                <div class="post-meta">
													<p>
														<span><i class="fa fa-user"></i> Admin</span>
														<span class="separator">|</span>
														<span><i class="fal fa-clock"></i> <?php echo date("H:i",$pte1['time'])?></span>
														<span class="separator">|</span>
														<span><i class="fal fa-calendar-alt"></i> <?php echo datum(date("Y-m-d",$pte1['time']))?></span>
													</p>
                                                </div>
											</div>
										</div>
                                        <div class="col-md-<?php echo $co1?> order-<?=$ord2?>">
                                            <div class="single-blog-post-media mb-sm-20">
                                                <div class="blog-image-gallery">
                                                    
<?php
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]"))
{
$wh=explode("-",image_size1(170,128,$pte1['slika']));
?>
<div class="single-image">
<!-- Slika na zbirnom prikazu kada je popunjen samo donji editor -->
<?php echo $link_det?>
<img src="<?=$patH?><?php echo GALFOLDER ?>/<?php echo $pte1['slika']?>" alt="<?php echo $pte1["altslike"]?>" title="<?php echo $pte1["titleslike"]?>" class="img-fluid" />
<?php echo $link_det1?>
</div>
<?php } ?>
<?php
read_files("idupisa",$pte1['id'],$page1['id'],$patH,$page_path2,0);
$izg=mysqli_query($conn, "SELECT * FROM slike WHERE akt='Y' and tip=0 and idupisa='$pte1[id]' ORDER BY -pozicija DESC");
$pp = mysqli_query($conn, "SELECT p.*, pt.*
        FROM slike p
        INNER JOIN slike_lang pt ON p.id = pt.id_slike        
        WHERE pt.lang='$lang' AND p.tip=0  AND p.akt='Y' AND p.idupisa=$pte1[id] ORDER BY -p.pozicija DESC");
while($izg1=mysqli_fetch_assoc($pp))
{
$wh=explode("-",image_size1(200,128,$izg1['slika']));
echo '
<div class="single-image">';
echo $link_det;
echo '<img class="img-fluid" src="'.$patH.SUBFOLDER.GALFOLDER.'/'.$izg1['slika'].'" alt="'.$izg1['alt'].'" title="'.$izg1['title'].'">';
echo $link_det1;
echo '</div>';
if($pate1['polapola']==1) $pola1="6" and $pola2="6"; else $pola1="8" and $pola2="8";
}
?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        <div class="col-md-<?php echo $co2?> order-<?=$ord1?>">
                                            <div class="single-blog-post-content">
                                                <div class="post-excerpt"><?=substr($pte1["opis"],0,300);?>...</div>
												<?php echo "<a class='btn btn-primary text-white float-right' href='".$patH1."/".$page1["ulink"]."/".$pte1["ulink"]."/'>OPŠIRNIJE</a>"?>
                                            </div>
                                        </div>
                                    </div>
									<hr>
                                </div>
                            </div>
<?php
 $br++;
}
}
}
 // kraj izlistavanja kada je popunjen samo donji editor

else { 
// pocetak detaljnog prikaza teme bloga
if($idup>0)
{
?>
                    <div class="blog">					
<?php
if($pate1["naslov"]!="")
echo "<div class='section-header'><h1>".$pate1["naslov"]."</h1></div>";
?>                        
							<p class="text-center">
								<span><i class="fa fa-user"></i> Admin</span>
								<span class="separator">|</span>
								<span><i class="fal fa-clock"></i> <?php echo date("H:i",$pate1['time'])?></span>
								<span class="separator">|</span>
								<span><i class="fal fa-calendar-alt"></i> <?php echo datum(date("Y-m-d",$pate1['time']))?></span>
							</p>
<?php
$pp = mysqli_query($conn, "SELECT p.*, pt.*
        FROM slike p
        INNER JOIN slike_lang pt ON p.id = pt.id_slike        
        WHERE pt.lang='$lang' AND p.tip=0  AND p.akt='Y' AND p.idupisa=$pate1[id_text] ORDER BY -p.pozicija DESC");

if($pate1['polapola']==1) $pola=" col-12 col-md-6 mimg".$pate1['full_img_width']; else $pola="";
if(mysqli_num_rows($pp)>0 and $pate1['mini_slider']==1) $galcl="blog-thumb-active owl-carousel"; else $galcl="mb-3";
if(isset($pate1['slika']) and $pate1['slika']!="") { ?>
                                <div class="<?php echo $galcl.$pola?>">
<!-- Slika u detaljnom prikazu teme bloga -->
<img src="<?=$patH?><?php echo GALFOLDER ?>/<?php echo $pate1['slika']?>" alt="<?php echo $pate1["altslike"]?>" title="<?php echo $pate1["titleslike"]?>" class="w-100 img-fluid">

<?php
//read_files("idupisa",$pate1['id'],$page1['id'],$patH,$page_path2,0);
if($pate1['mini_slider']==1) {
while($izg1=mysqli_fetch_assoc($pp))
{
$wh=explode("-",image_size1(200,128,$izg1['slika']));
echo '<div class="blog-thumb">';
echo '<img class="img-fluid" src="'.$patH.SUBFOLDER.GALFOLDER.'/'.$izg1['slika'].'" alt="'.$izg1['alt'].'" title="'.$izg1['title'].'">';
echo '</div>';
}
}
?>
                                </div>
<?php } ?>
                        <div class="post-content mb-3">
						<?php echo $pate1["opis"];?>
                        </div>
<?php if($pate1['mini_slider']==0) { ?>
<div class="row">
<?php
while($izg1=mysqli_fetch_assoc($pp)) {
?>
<div class="mt-10 col-12 col-lg-2 col-md-3 col-sm-6">
<div class="galerija">
<div class="pro-large-img">
<img class="img-fluid" src="<?php echo $patH.SUBFOLDER.GALFOLDER?>/thumb/<?php echo $izg1['slika']?>" alt="<?php echo $izg1['alt']?>" title="<?php echo $izg1['title']?>">
<div class="img-view">
<a class="img-popup" href="<?php echo $patH.SUBFOLDER.GALFOLDER?>/<?php echo $izg1['slika']?>" title="<?php echo $izg1['title']?>"><i class="fa fa-search"></i></a>
</div>
</div>
</div>
</div>
<?php } ?>
</div>
<?php
}
if($pate1['pretraga_link']!="") {
echo '<div class="video embed-responsive embed-responsive-16by9 mt-20">';
echo $pate1['pretraga_link'];
echo '</div>';
}
if($pate1['video']!="") {
?>
<div class="text-center">
<video id="volume" controls preload="auto" class="mt-20">
	<source src="<?php echo $patH1?>/video-fajlovi/<?php echo $pate1['video']?>" />
</video>
</div>
<?php } ?>
					<div class="row">
						<div class="col-12 mb-3">
<?php if($pate1['keywords']!="") { ?>
						<a class="btn btn-primary text-white float-right" href='<?php echo $pate1['keywords']?>'>Pročitaj još <i class="fal fa-arrow-alt-right"></i></a>
<?php } ?>
						<a class="btn btn-primary text-white float-left" href="#" onclick="window.history.go(-1); return false;"><i class="fal fa-arrow-alt-left"> PRETHODNA STRANA</i></a>
						</div>
					</div>
						<div class="clearfix mb-2"></div>

<?php
if($modulArr['komentari']==1) {
if(!isset($_SESSION['userids']))  $aktis=" AND akt=1"; else $aktis="";
$kom=mysqli_query($conn, "SELECT * FROM komentari WHERE id_pro=$pate1[id] AND tip=1 AND id_parent=0 $aktis ORDER BY date ASC");
$brk=mysqli_num_rows($kom);
if($brk==0) {
$pref="";
$cbr="Nema komentara, budite prvi ko će komentarisati ovaj blog post";
}
else {
$cbr="KOMENTAR";
$pref=$brk;
}
if($brk>1) $nast="A"; else $nast="";
?>
                    <div class="comment-section mb-md-30 mb-sm-30">
                        <h3 class="comment-counter"><?=$pref." ".$cbr.$nast?></h3>
                        <div class="comment-container mb-30">
 <?php 
while($kom1=mysqli_fetch_assoc($kom)) { 
$tim = strtotime($kom1['date']);
?>

<div id="kom<?php echo $kom1['id']?>">
<?php
if(isset($_SESSION['userids']))
{ //admin akcije
if($kom1['akt']==1) $komse="checked"; else $komse="";
$odgovri='<span class="reply-btn"><a href="javascript:;" onclick="formOdg('.$kom1['id'].')" title="Odgovori na komentar"><i class="far fa-reply-all"></i></a></span>';
?>
<div class="single-comment admin-odobrenje">
<div class="check-box d-inline-block ml-0 ml-md-2">
<input id="odobrikom<?php echo $kom1['id']?>" class="check-box" type='checkbox' <?php echo $komse?> value='<?php echo $kom1['id']?>' onclick="akti(<?php echo $kom1['id']?>, 'akomentar')" />
<label for="odobrikom<?php echo $kom1['id']?>"><?php echo $langa['messag'][56]?></label>
</div>

<a href='javascript:;' onclick="delm(<?php echo $kom1['id']?>,'del_kom','<?php echo $langa['messag'][562]?>', 0)">
<i class="far fa-trash-alt"></i> <?php echo $langa['messag'][561]?></a>
<a style="margin-left:10%" name="reviews" href='javascript:;' rel="<?php echo $kom1['id']?>" class='izmform'><i class="far fa-retweet-alt"></i> Izmeni komentar</a>

</div>
<?php } ?>


<div class="single-comment mb-15">
<?php echo $odgovri?>
<div class="image">
<i class="fal fa-comment-smile fa-3x"></i>
</div>
<div class="content">
<h3 class="user"><?php echo $kom1['ime']?> <span class="comment-time"><?php echo date("H:i", $tim)?> <?php echo date("d.m.Y", $tim)?></span></h3>
<p class="comment-text" id="com<?php echo $kom1['id']?>"><?php echo $kom1['komentar']?></p>

<div id="fom<?php echo $kom1['id']?>"></div>

<?php
$skom=mysqli_query($conn, "SELECT * FROM komentari WHERE id_parent=$kom1[id] AND tip=1 $aktis ORDER BY date ASC");
if(mysqli_num_rows($skom)>0) {
while($skom1=mysqli_fetch_assoc($skom)) {
$tim = strtotime($skom1['date']);
if(isset($_SESSION['userids']))
{
if($skom1['akt']==1) $skomse="checked"; else $skomse="";
?>
<div id="kom<?php echo $kom1['id']?>">
<div class="single-comment admin-odobrenje skom<?php echo $skom1['id']?>">

<div class="check-box d-inline-block ml-0 ml-md-2">
<input id="odobrikom<?php echo $skom1['id']?>" class="check-box" type='checkbox' <?php echo $skomse?> value='<?php echo $skom1['id']?>' onclick="akti(<?php echo $skom1['id']?>, 'akomentar')" />
<label for="odobrikom<?php echo $skom1['id']?>"><?php echo $langa['messag'][56]?></label>
</div>

<a href='javascript:;' onclick="delm(<?php echo $skom1['id']?>,'del_kom','<?php echo $langa['messag'][562]?>', <?php echo $kom1['id']?>)">
<i class="far fa-trash-alt"></i> <?php echo $langa['messag'][561]?></a>
<a style="margin-left:10%" name="reviews" href='javascript:;' rel="<?php echo $skom1['id']?>" class='izmform'><i class="far fa-retweet-alt"></i> Izmeni komentar</a>
</div>

<?php } ?>
<div class="single-comment skom<?php echo $skom1['id']?> mb-20 pt-15 d-block">
<p class="comment-text"><i class="fal fa-comment-smile fa-2x"></i> <span class="comment-time"><?php echo date("H:i", $tim)?> <?php echo date("d.m.Y", $tim)?></span> <strong><?php echo $skom1['ime']?></strong> kaže:</p>
<p class="comment-text" id="com<?php echo $skom1['id']?>"><?php echo $skom1['komentar']?></p>
</div>

</div>

<?php
}
}
?>
</div>
</div>
</div> <!-- / div id -->
<?php
}
if(isset($_SESSION['userids']))
{
if(isset($sarray['ch']) and $sarray['ch']>0)
{
$uzk=mysqli_query($conn, "SELECT * FROM komentari WHERE id=".$sarray['ch']."");
$uzk1=mysqli_fetch_assoc($uzk);
}
}
?>
                        </div>
                    </div>
<?php } ?>
                </div>

<?php

if($modulArr['komentari']==1) { ?>

<div id="reviews" class="mb-30 w-100">
<div class="col-sm-12">
<h3>Napišite svoj komentar</h3>
<p>Vaša email adresa neće biti objabvljena</p>


<div class="comment-form">
	<form action="<?php echo curPageURL()?>#reviews"  method="post" class="comment-form">
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Ime ili nadimak <span class="required">*</span></label>
					<input type="text" name='ime' placeholder="Vaše ime" value="<?php echo $_POST['ime']?$_POST['ime']:$uzk1['ime']?>" required>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group">
					<label>Email <span class="required">*</span></label>
					<input type="email" name='email' value="<?php echo $_POST['email']?$_POST['email']:$uzk1['email']?>" placeholder="Vaša email adresa" required>
				</div>
			</div>

<?php
if(isset($sarray['ch']) and $sarray['ch']>0)
{
?>
<input type="hidden" name="izmena_komentara" value="<?php echo $sarray['ch']?>">
<?php
}
else {
?>
<input type="hidden" name="send_komentar1" value="1">
<?php } ?>
<input type="hidden" name="idpro" value="<?php echo $pate1['id']?>">

<div class="col-lg-12">
<div class="form-group">
<label>Komentar <span class="required">*</span></label>
<textarea name="poruka" required><?php echo $_POST['poruka']?$_POST['poruka']:$uzk1['komentar']?></textarea>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<?php
if(!isset($sarray['ch']))
{
?>
<div class="g-recaptcha" data-sitekey="<?php echo $settings['recaptcha_html']?>"></div>
<?php } ?>
<button type="submit" class="fl-btn btn-primary text-white float-right">
<?php
if(isset($sarray['ch']) and $sarray['ch']>0) echo "Izmeni"; else echo "Pošalji";
?>
</button>
</div>
</div>

</form>
</div>

<div id="komForma" style="display:none;">
<form action="<?php echo curPageURL()?>#reviews"  method="post" class="comment-form">
<div class="row">
<div class="col-lg-6">
    <div class="form-group">
<label>Ime ili nadimak <span class="required">*</span></label>
<input type="text" name='ime' placeholder="Vaše ime" value="" required>
	</div>
</div>
<div class="col-lg-6">
    <div class="form-group">
<label>Email <span class="required">*</span></label>
<input type="email" name='email' value="" placeholder="Vaša email adresa" required>
	</div>
</div>
<input type="hidden" name="id_parent" id="id_parent" value="0">
<input type="hidden" name="send_komentar1" value="1">
<input type="hidden" name="idpro" value="<?php echo $pate1['id']?>">
<div class="col-lg-12">
<div class="form-group">
<label>Komentar <span class="required">*</span></label>
<textarea name="poruka" required></textarea>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<button type="submit" class="fl-btn btn-primary text-white float-right"><?php echo "Pošalji";?></button>
</div>
</div>
</form>
</div>

</div>
</div>

<?php
}
}
}
// kraj detaljnog prikaza teme bloga
if($idup=="")
{
if($ukupnos>$ByPage1){
?>
<div class="pagination-area pull-right">
<ul class="pagination">
<?php 
echo $pagedResults->fetchPagedNavigation($search_values[0]."?p=");
?>								
</ul>
</div>
<?php 
}
}
?>
</div>
</div>
</div>
</div>
<?php
if($idup>0) {
$pter = mysqli_query($conn, "SELECT p.*, pt.*
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text        
        WHERE pt.lang='$lang'  AND p.akt='Y' AND p.id_page='$page1[id]' AND NOT p.id=".$pate1['id_text']." ORDER BY rand() LIMIT 3");
if(mysqli_num_rows($pter)>0) {
?>
<div class="blog">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
			<div class="section-header mb-3">
				<h2>Pogledajte još...</h2>
			</div>
			</div>
		</div>
        <div class="row blog-page">
<?php
while($izg2=mysqli_fetch_assoc($pter))
{
?>
		<div class="col-lg-4 col-md-6">
             <div class="blog-item">
                <a href='<?=$patH1?>/<?=$page1["ulink"]?>/<?=$izg2["ulink"]?>/'>
                     <img class="img-fluid" src="<?=$patH?><?php echo GALFOLDER ?>/<?php echo $izg2['slika']?>" alt="<?php echo $izg2["altslike"]?>" title="<?php echo $izg2["titleslike"]?>" />
                </a>
				<h3><a href='<?=$patH1?>/<?=$page1["ulink"]?>/<?=$izg2["ulink"]?>/'><?=$izg2['naslov']?></a></h3>
				<div class="meta">
				<i class="fal fa-clock"></i> <?php echo date("H:i",$izg2['time'])?>
				<i class="fal fa-calendar-alt"></i> <?php echo datum(date("Y-m-d",$izg2['time']))?>
				</div>
				<p><?php echo substr(strip_tags($izg2["opis"]),0,80)?>...</p>
            </div>
		</div>
<?php } ?>
        </div>
	</div>
</div>
<?php } ?>

<?php } ?>
<script>
// The function actually applying the offset
function offsetAnchor() {
  if (location.hash.length !== 0) {
    window.scrollTo(window.scrollX, window.scrollY - 350);
  }
}

// Captures click events of all <a> elements with href starting with #
$(document).on('click', 'a[href^="#"]', function(event) {
  // Click events are captured before hashchanges. Timeout
  // causes offsetAnchor to be called after the page jump.
  window.setTimeout(function() {
    offsetAnchor();
  }, 0);
});

// Set the offset when entering page with hash present in the url
window.setTimeout(offsetAnchor, 0);
</script>