<div class="header_sivo">
 <?php 
 if($_SESSION['userids']/* and $admins==2*/ and !isset($_GET['izape']))
 {
$admi=mysqli_query($conn, "SELECT tip, master FROM users_admin WHERE user_id=$_SESSION[userids] AND akt='Y'");
$admi1=mysqli_fetch_array($admi);
?>
 
<div class="container-fluid">
	<div class="row">
		<div class="col-12"> 
			<nav id="menu">
			  <label for="tm" id="toggle-menu">Navigacija <span class="drop-icon"><i class="fas fa-caret-down"></i></span></label>
			  <input type="checkbox" id="tm">
			  <ul class="main-menu clearfix">
				<li><a href="./" rel="<?php echo $patHA?>" id="home">Admin</a></li>
<?php if($admi1['tip']==1 or $admi1['tip']==2) { ?>
				<li><a href="#">Stranice
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm3"><i class="fas fa-caret-down"></i></label>
					</a>
					<input type="checkbox" id="sm3">
					<ul class="sub-menu">
						<li><a href='<?php echo $patHA?>/index.php?base=admin&page=page_add&id_cat=0'>Upis - izmena stranica</a></li>	    
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=menus">Meniji</a></li>
						<!--<li><a href="<?php echo $patHA?>/index.php?base=admin&page=models">Modeli stranica</a></li>-->
<!--
<?php if($admi1['tip']==1) { ?>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=stavke">Stavke</a></li>
<?php } ?>
-->
					</ul>
				</li>
<?php } ?>
				<input type="checkbox" id="sm1">
				<!-- 
				<?php $sums2=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM subscribers"));?>
				<li><a href="<?php echo $patHA?>/index.php?base=admin&page=subscribers">Vesti pr (<?php echo $sums2?>)</a></li>
				-->
<?php if($admi1['tip']==1) { ?>
				<li><a href="#">Podešavanja
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm2"><i class="fas fa-caret-down"></i></label>
					</a>
					<input type="checkbox" id="sm2">
					<ul class="sub-menu">
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=podesavanjaAA">Glavne postavke</a></li>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=moduli">Color šema</a></li>
<?php if($admi1['master']==1) { ?>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=izgled">Postavke izgleda</a></li>
<?php } ?>
<?php if($admi1['master']==1) { ?>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=language_words">Sistemski izrazi</a></li>
<?php } ?>
					</ul>
				</li>
<?php } ?>
				<li><a href="#">Slike
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm4"><i class="fas fa-caret-down"></i></label>
					</a>
					<input type="checkbox" id="sm4">
					<ul class="sub-menu">
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=subslike&idupisa=0&tip=2">Slike slider</a></li>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=subslike&idupisa=0&tip=3">Slike nezavisne</a></li>
					</ul>
				</li>
				<li><a href="#">Sadržaj po tipovima
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm5"><i class="fas fa-caret-down"></i></label>
					</a>
					<input type="checkbox" id="sm5">
					<ul class="sub-menu">
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content0">Svi tipovi</a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content">Sadržaj osnovni tip<span><img src="images/tip0.jpg" alt="Tip osnovni"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content1">Sadržaj tip 1<span><img src="images/tip1.jpg" alt="Tip 1"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content2">Sadržaj tip 2<span><img src="images/tip2.jpg" alt="Tip 2"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content3">Sadržaj tip 3<span><img src="images/tip3.jpg" alt="Tip 3"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content4">Sadržaj tip 4<span><img src="images/tip4.jpg" alt="Tip 4"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content5">Sadržaj tip 5<span><img src="images/tip5.jpg" alt="Tip 5"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content6">Sadržaj tip 6<span><img src="images/tip6.jpg" alt="Tip 6"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content8">Sadržaj tip za BLOG<span><img src="images/tip8.jpg" alt="Tip za blog"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content9">Sadržaj tip za VESTI<span><img src="images/tip9.jpg" alt="Tip za vesti"></span></a></li>
					</ul>
				</li>
				
				
				
				<li><a href="#">Upiši sadržaj
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm5"><i class="fas fa-caret-down"></i></label>
					</a>
					<input type="checkbox" id="sm5">
					<ul class="sub-menu">
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_content&tip=id_page&idp=<?php echo $_GET['idp']?>">Sadržaj osnovni tip<span><img src="images/tip0.jpg" alt="Tip osnovni"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_content1&tip=id_page&idp=<?php echo $_GET['idp']?>">Sadržaj tip 1<span><img src="images/tip1.jpg" alt="Tip 1"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_content2&tip=id_page&idp=<?php echo $_GET['idp']?>">Sadržaj tip 2<span><img src="images/tip2.jpg" alt="Tip 2"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_content3&tip=id_page&idp=<?php echo $_GET['idp']?>">Sadržaj tip 3<span><img src="images/tip3.jpg" alt="Tip 3"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_content4&tip=id_page&idp=<?php echo $_GET['idp']?>">Sadržaj tip 4<span><img src="images/tip4.jpg" alt="Tip 4"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_content5&tip=id_page&idp=<?php echo $_GET['idp']?>">Sadržaj tip 5<span><img src="images/tip5.jpg" alt="Tip 5"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_content6&tip=id_page&idp=<?php echo $_GET['idp']?>">Sadržaj tip 6<span><img src="images/tip6.jpg" alt="Tip 6"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_content8&tip=id_page&idp=<?php echo $_GET['idp']?>">Sadržaj tip za BLOG<span><img src="images/tip8.jpg" alt="Tip za blog"></span></a></li>
					<li class="popup"><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_content9&tip=id_page&idp=<?php echo $_GET['idp']?>">Sadržaj tip za VESTI<span><img src="images/tip9.jpg" alt="Tip za vesti"></span></a></li>
					</ul>
				</li>
				
				
				
				
 <?php 
 $sump=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=4"));
 $sumpa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=4 AND akt=1"));
 $sump1=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=5"));
 $sumpa1=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=5 AND akt=1"));
 $sump2=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=6"));
 $sumpa2=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=6 AND akt=1"));
 ?>
				<li class='float-right'><a title="Odjavi se" href="<?php echo $patHA?>/logout.php"><i class="far fa-sign-out-alt"></i></a></li>
				<li class='float-right'><a title="Idi na sajt" href="<?php echo $patH1?>" target="_blank"><i class="far fa-browser"></i></a></li>
			  </ul>
			</nav>
		</div>
	</div>
</div>
<?php } ?> 
</div>