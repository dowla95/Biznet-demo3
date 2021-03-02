<div class="blog">
<div class="site-section bg-light">
	<div class="container border-bottom pt-5">
		<div class="row mb-5 justify-content-center">
			<div class="col-md-7 text-center">
				<div class="block-heading-1" data-aos="fade-up" data-aos-delay="">
					<h2>Poslednje vesti</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="blog-wrapper-inner">
					<div class="row blog-page">
<?php 
$pter = mysqli_query($conn, "SELECT p.*, pt.*
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text        
        WHERE pt.lang='$lang'  AND p.akt='Y' AND p.id_page=63 ORDER BY time DESC LIMIT 3");
while($izg2=mysqli_fetch_assoc($pter))
{
$kom=mysqli_query($conn, "SELECT * FROM komentari WHERE id_pro=$izg2[id] AND tip=1 $aktis ORDER BY date ASC");
$brk=mysqli_num_rows($kom);
if($brk==0) $combr="Bez komentara";
elseif($brk==1) $combr=$brk." komentar";
elseif($brk>1) $combr=$brk." komentra";
?>
						<div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="">
							<div class="blog-item">
								<a href='<?php echo $patH1?>/vesti/<?php echo $izg2["ulink"]?>/'>
									<img class="img-fluid" src="<?php echo $patH?><?php echo GALFOLDER ?>/thumb/<?php echo $izg2['slika']?>" alt="<?php echo $izg2["altslike"]?>" title="<?php echo $izg2["titleslike"]?>" />
								</a>
								<div class="text-muted mb-3 text-uppercase small">
									<i class="fal fa-clock"></i> <?php echo date("H:i",$izg2['time'])?> &nbsp; | 
									<i class="fal fa-calendar-alt"></i> <?php echo datum(date("Y-m-d",$izg2['time']))?>
									<!--<i class="fal fa-comment-smile"></i>  <?php echo $combr?>-->
								</div>
								<h3><a href='<?php echo $patH1?>/vesti/<?php echo $izg2["ulink"]?>/'><?php echo $izg2['naslov']?></a></h3>
								<p><?php echo mb_substr(strip_tags($izg2['opis']),0,120)?>...</p>
							</div>
						</div>
<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>