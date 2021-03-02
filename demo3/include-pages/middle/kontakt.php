<div class="contact">
	<div class="site-section bg-light">
        <div class="container">
			<div class="row">
				<div class="col-12 text-center mb-5" data-aos="fade-up" data-aos-delay="">
					<div class="block-heading-1">
						<h1><?php echo $settingsc['knas1']?></h1>
					</div>
				</div>		   
			</div>
			<div class="row">
				<div class="col-lg-6 mb-5" data-aos="fade-up" data-aos-delay="">
                    <div class="contact-form">
	    				<div class="status alert alert-success" style="display:none"></div>
						<div class="status alert alert-warning" style="display:none"></div>
				    	<form id="main-contact-form" name="contact-form" method="post">				           
							<div class="form-group row">
								<div class="col-md-12">
									<input type="text" name="name" class="form-control" required placeholder="Ime i prezime*">
								</div>				                
				            </div>
				            <div class="form-group row">
								<div class="col-md-12">
									<input type="email" name="email" class="form-control" required placeholder="Email*">
								</div>				                
				            </div>
							<div class="form-group row">
								<div class="col-md-12">
									<input type="text" name="subject" class="form-control" placeholder="Naslov poruke">
								</div>				                
				            </div>
							<div class="form-group row">
								<div class="col-md-12">
									<textarea name="message" id="message" class="form-control" rows="8" placeholder="Tekst poruke*" required></textarea>
								</div>				                
				            </div>				            
							<div class="form-group row">
								<div class="col-lg-7 ml-auto">
									<span class='obavezno'>*</span> Čekirajte da niste robot: <br />								
									<div class="g-recaptcha" data-sitekey="<?php echo $settings['recaptcha_html']?>"></div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6 ml-auto">
									<input type="submit" name="submit" class="btn btn-block btn-primary text-white py-3 px-5" value="Pošalji">
								</div>				                
				            </div>				            
				        </form>
                    </div>
                </div>
                <div class="col-lg-4 ml-auto" data-aos="fade-up" data-aos-delay="">
                    <div class="contact-info">
                        <div class="block-team-member-1 mb-4 text-center rounded">
                            <i class="fa fa-map-marker-alt"></i>
                            <div class="contact-text">
                                <h2 class="font-size-20 text-black">Adresa</h2>
                                <p><?php echo $settingsc['kads']?></p>
                            </div>
                        </div>
						
                        <div class="block-team-member-1 mb-4 text-center rounded">
                            <i class="fa fa-phone"></i>
                            <div class="contact-text">
                                <h2 class="font-size-20 text-black">Telefon</h2>
                                <p><?php echo $settings['tel-sin']?></p>
                            </div>
                        </div>
                        <div class="block-team-member-1 mb-4 text-center rounded">
                            <i class="fa fa-envelope"></i>
                            <div class="contact-text">
                                <h2 class="font-size-20 text-black">Email</h2>
                                <p><?php echo $settings['email_zaemail1']?></p>
                            </div>
                        </div>
<?php if($settingsc['ktext']!="") { ?>
						<div class="block-team-member-1 mb-4 text-center rounded">
							<div class="contact-text">
							<?php echo $settingsc['ktext']?>
							</div>
						</div>
<?php } ?>
                    </div>
                </div>                
            </div>
        </div>
	</div>
<?php if($settings['gmapa']!="") { ?>
		<div class="container">
		<div class="row">
            <div class="col-12 text-center block-heading-1 mb-4">
                <h2 class="text-black"><?php echo $settingsc['knas2']?></h2>
            </div>
		</div>
		</div>
		<div class="mb-4"><?php echo $settings['gmapa']?></div>
<?php } ?>
</div>