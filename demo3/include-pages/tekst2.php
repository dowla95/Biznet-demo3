<?php$pozz = mysqli_query($conn, "SELECT * FROM slike, slike_lang WHERE slike.id=slike_lang.id_slike AND slike.akt='Y' AND slike.tip=3 AND slike.subtip=8");$pozz1=mysqli_fetch_array($pozz);if($pozz1['slika']!="") $pstil=" style='background-image:url(".$patH."/galerija/".$pozz1['slika'].")'"; else $pstil="";?><div class="team">	<div class="site-section">		<div class="container"><?php$pte4 = mysqli_query($conn, "SELECT p.*, pt.*, p.id as id        FROM pages_text p        INNER JOIN pages_text_lang pt ON p.id = pt.id_text                WHERE p.tipus=2 AND pt.lang='$lang' AND p.youtube<>'' AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst ORDER BY p.pozicija ASC");while($pte5=mysqli_fetch_assoc($pte4)) {?>		<div class="row mb-5 justify-content-center text-center">			<div class="block-heading-1" data-aos="fade-up" data-aos-delay="">				<h1><?php echo $pte5['youtube']?></h1>			</div>		</div><?php}$pte = mysqli_query($conn, "SELECT p.*, pt.*, p.id as id        FROM pages_text p        INNER JOIN pages_text_lang pt ON p.id = pt.id_text                WHERE p.tipus=2 AND pt.lang='$lang' AND NOT p.polapola=1 AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst ORDER BY p.pozicija ASC");$ptenum=mysqli_num_rows($pte);$pte2 = mysqli_query($conn, "SELECT p.*, pt.*, p.id as id        FROM pages_text p        INNER JOIN pages_text_lang pt ON p.id = pt.id_text                WHERE p.tipus=2 AND pt.lang='$lang' AND p.polapola=1 AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst ORDER BY p.pozicija ASC");while($pte3=mysqli_fetch_assoc($pte2)) { ?>								<div class="row mb-5 justify-content-center text-center">					<div class="col-md-7">						<div class="" data-aos="fade-up" data-aos-delay="">							<h2><?php echo $pte3['naslov']?></h2>							<?php echo $pte3["opis1"]?>						</div>					</div>				</div><?php } ?>			<div class="row mb-5"><?phpwhile($pte1=mysqli_fetch_assoc($pte)){if($pte1['keywords']!="") $ahref="<a href=".$pte1['keywords'].">" and $ah="</a>"; else $ahref="" and $ah="";?>							<div class="col-lg-4 col-md-6 mb-4">				<?php echo $ahref?>					<div class="block-team-member-1 text-center rounded">						<figure><?php if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]")) echo "<img src='".$patH.SUBFOLDER.GALFOLDER."/thumb/".$pte1['slika']."' class='img-fluid' alt='".$pte1['altslike']."' title='".$pte1['titleslike']."' />";?>						</figure>						<div class="team-text">							<h2 class="font-size-20 text-black"><?php echo $pte1["pretraga_link"]?></h2>							<div class="team-social">								<span class="d-block font-gray-5 letter-spacing-1 text-uppercase font-size-12 mb-3"><?php echo $pte1["naslov"]?></span>														</div>							<?php echo $pte1["opis1"]?>						</div>					</div>					<?php echo $ah?>				</div>							<?php}?>			</div>		</div>	</div></div>