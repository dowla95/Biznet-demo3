<div class="newsletter">
	<div class="site-section bg-light">
		<div class="container">
			<div class="section-header">
				<h2><?php echo $arrwords['pretraga']?></h2>
				<i><?php echo $arrwords['pojam_pretrage']?></i>
			</div>
			<form method="get" action="#" class="footer-suscribe-form">
				<script>document.querySelector("form").setAttribute("action", "")</script>
			
<?php
$rad1=$rad2="";
if(!isset($sarray['pron']) or $sarray['pron']==1)
$rad1="checked";
elseif($sarray['pron']==2)
$rad2="checked";
elseif($sarray['pron']==3)
$rad3="checked";
?>
		<input class="d-none" name="pron" type="radio" value='1' />
		<input class="d-none" name="pron" type="radio" value='2' checked />
		<div class="input-group mb-3">
			<input class="form-control border-secondary text-white bg-transparent" type="text" name="word" required placeholder="Pretraga" value="<?php echo $word?>">
			<div class="input-group-append">
				<button class="btn btn-primary text-white" value="" type="submit" class="btn" id="button-addon2">Pretraži</button>
			</div>
		</div>
			</form>
		</div>
	</div>
</div>

    <div class="site-footer">
        <div class="container">
			<div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="footer-about">
                        <h2><?php echo $settingsc['fnaslov1']?></h2>
<?php
$logf = mysqli_query($conn, "SELECT * FROM slike, slike_lang WHERE slike.id=slike_lang.id_slike AND slike.akt='Y' AND slike.tip=3 AND slike.subtip=1");
$logf1=mysqli_fetch_array($logf);
if($logf1['slika']!="") { ?>
							<a href="<?php echo $patH?>"><img class="img-fluid" src="galerija/<?php echo $logf1['slika']?>" alt="<?php echo $logf1['alt']?>" title="<?php echo $logf1['title']?>"></a>
<?php } ?>
                                <?php echo $settingsc['ftext1']?>
                            </div>
                </div>
                <div class="col-md-6 col-lg-8">
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="footer-contact">
                                <h2><?php echo $settingsc['fnaslov2']?></h2>
                                <p><i class="fa fa-map-marker-alt"></i><?php echo $settingsc['kads']?></p>
                                <p><i class="fa fa-phone"></i><?php echo $settings['tel-sin']?></p>
                                <p><i class="fa fa-envelope"></i><?php echo $settings['email_zaemail1']?></p>
                                <div class="footer-social">
									<?php if($settings['google']!="") {?><a href="<?php echo $settings['google']?>" target="_blank"><i class="fas fa-map-marker-alt"></i></a><?php }?>
									<?php if($settings['facebook']!="") {?><a href="<?php echo $settings['facebook']?>" target="_blank"><i class="fab fa-facebook"></i></a><?php }?>
									<?php if($settings['twitter']!="") {?><a href="<?php echo $settings['twitter']?>" target="_blank"><i class="fab fa-twitter"></i></a><?php }?>
									<?php if($settings['linkedin']!="") {?><a href="<?php echo $settings['linkedin']?>" target="_blank"><i class="fab fa-linkedin"></i></a><?php }?>
									<?php if($settings['instagram']!="") {?><a href="<?php echo $settings['instagram']?>" target="_blank"><i class="fab fa-instagram"></i></a><?php }?>
									<?php if($settings['youtube']!="") {?><a href="<?php echo $settings['youtube']?>" target="_blank"><i class="fab fa-youtube-square"></i></a><?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="footer-link">
                                <h2><?php echo $settingsc['fnaslov3']?></h2>
<?php if($settings['id_menu_footer']!="") {
$me=mysqli_query($conn, "SELECT * FROM menus_list WHERE id_menu=$settings[id_menu_footer] ORDER BY position ASC");
while($me1=mysqli_fetch_assoc($me))
{              
$pe=mysqli_query($conn, "SELECT * FROM pagel WHERE id_page=$me1[id] AND lang='$lang'");
$pe1=mysqli_fetch_assoc($pe);
$pa=mysqli_query($conn, "SELECT * FROM page WHERE id=$me1[id]");
$pa1=mysqli_fetch_assoc($pa);
if(mb_eregi(".php",$pe1['ulink'])) $ulinka=$pe1['ulink']; else
if($pe1['ulink']!="") $ulinka=$pe1['ulink']."/"; else $ulinka="";
?>
<a href="<?php echo $patH1?>/<?php echo $ulinka?>" title="<?php echo $pe1['naziv']?>"><?php echo $pa1['class_for_icon']?> <?php echo $pe1['naziv']?></a>
<?php } } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




			<div class="row pt-5 mt-5 text-center border-top pt-">                
                    <div class="col-md-6">
						<p class="copyright"><small>Copyright © 2021 <a href="<?php echo $patH?>" id="path"><?php echo $settingsc['site_name']?></a>. Sva prava zadržana.</small></p>
					</div>
                    <div class="col-md-6">
						<p class="copyright"><small>Designed by <a target="_blank" href="https://www.biznet.rs/usluge/izrada-web-sajta/">BizNet izrada sajtova</a></small></p>
					</div>				
            </div>
        </div>
		<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <!-- <script type="text/javascript" src="js/js.js"></script> -->  
	</div>
</body>
</html>