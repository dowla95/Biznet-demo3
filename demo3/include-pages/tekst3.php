<?php$pozz = mysqli_query($conn, "SELECT * FROM slike, slike_lang WHERE slike.id=slike_lang.id_slike AND slike.akt='Y' AND slike.tip=3 AND slike.subtip=8");$pozz1=mysqli_fetch_array($pozz);if($pozz1['slika']!="") $pstil=" style='background-image:url(".$patH."/galerija/".$pozz1['slika'].")'"; else $pstil="";?><div class="timeline">	<div class="site-section bg-dark">	<div class="container"><?php$ld=800;$pte4 = mysqli_query($conn, "SELECT p.*, pt.*, p.id as id        FROM pages_text p        INNER JOIN pages_text_lang pt ON p.id = pt.id_text                WHERE p.tipus=3 AND pt.lang='$lang' AND p.youtube<>'' AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst ORDER BY p.pozicija ASC");while($pte5=mysqli_fetch_assoc($pte4)) {?>		<div class="row mb-5 justify-content-center">			<h1><?php echo $pte5['youtube']?></h1>		</div><?php}$pte = mysqli_query($conn, "SELECT p.*, pt.*, p.id as id        FROM pages_text p        INNER JOIN pages_text_lang pt ON p.id = pt.id_text                WHERE p.tipus=3 AND pt.lang='$lang' AND NOT p.polapola=1 AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst ORDER BY p.pozicija ASC");$ptenum=mysqli_num_rows($pte);$pte2 = mysqli_query($conn, "SELECT p.*, pt.*, p.id as id        FROM pages_text p        INNER JOIN pages_text_lang pt ON p.id = pt.id_text                WHERE p.tipus=3 AND pt.lang='$lang' AND p.polapola=1 AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst ORDER BY p.pozicija ASC");while($pte3=mysqli_fetch_assoc($pte2)) { ?>				<div class="row mb-5 justify-content-center">				<div class="col-md-7 text-center">					<h2><?php echo $pte3['naslov']?></h2>					<?php echo $pte3["opis"]?>				</div>				</div><?php } ?><div class="timeline-start">	<div class="owl-carousel block-14">			<?php$in=1;while($pte1=mysqli_fetch_assoc($pte)) {	// if($in %2 !=0) $ld="100"; else $ld="200";	$ld-=200;	if($pte1['keywords']!="")?>			<div class="block-testimony-1 text-center">	<div class="timeline-content" data-aos="zoom-in" data-aos-delay="<?php echo $ld?>">			<?php if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]")) echo "<img class='ml-2' src='".$patH.SUBFOLDER.GALFOLDER."/thumb/".$pte1['slika']."' alt='".$pte1['altslike']."' title='".$pte1['titleslike']."' />";?>		<h2><span><?php echo $pte1["pretraga_link"]?></span><?php echo $pte1["naslov"]?></h2>				<?php echo $pte1["opis"]?><?php if($pte1['keywords']!="") { ?>			<a href="<?php echo $pte1['keywords']?>" class="btn btn-outline-white border-w-2 btn-md">Još o ovome...</a>		<?php } ?>		</div>	</div>							<?php$in++;}?>		</div>		</div>	</div>	</div></div>