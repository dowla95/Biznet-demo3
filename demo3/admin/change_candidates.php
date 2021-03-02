<?php 
include("header-top-add-user.php"); 
if(isset($_GET['id']))
{
$mn=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_GET[id]");
$mn1=mysqli_fetch_assoc($mn);
if($msgr!="")
echo "<div class='infob'><div class='info_box'><div class='container'>$msgr</div></div></div>";
?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titles?></title>        
<meta name="description" content="<?php echo $descripts?>" />
	<meta name="keywords" content="" />
    <meta name="author" content="">
    
    <base href="<?php echo $patH?>/">
    <link href="<?php echo $patH?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $patH?>/assets/css/default.css" rel="stylesheet">
    <link href="<?php echo $patH?>/fonts/pro/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="<?php echo $patH?>/css/prettyPhoto.css" rel="stylesheet">
 
    <link href="<?php echo $patH?>/css/animate.css" rel="stylesheet">
	<link href="<?php echo $patH?>/assets/css/style.css" rel="stylesheet">
	<link href="<?php echo $patH?>/css/responsive.css" rel="stylesheet">
<script src="<?php echo $patH?>/js/jquery.js"></script>
<script src="<?php echo $patH?>/js/js.js"></script>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="<?php echo $patH?>/images/icon/favicona.svg">
</head><!--/head-->
<body>
<section id="form"><!--form-->

	<div class="container">
	<h1 class="mt-20 mb-10">Izmena podataka registrovanog korisnika</h1>
		<div class="login-form"><!--sign up form-->
			<form action="" method="post" enctype="multipart/form-data" >
				<div class="row">
         <div class="col-md-4">
<?php
$fifi1=$fifi2="";
if($mn1['firma']==1) $fifi1="selected";
if($mn1['firma']==0) $fifi2="selected";
if($mn1['firma']==1) $disdis=''; else $disdis=' disabled';
?>
						<div class="form-select form-control">
							<select name="firma-lice" id="firma-lice" class="izbor" required>
								<option value="">Firma ili fizičko lice?*</option>
								<option value="firma" <?php echo $fifi1?>>Firma</option>
								<option value="lice" <?php echo $fifi2?>>Fizičko lice</option>
							</select>
						</div>
        </div>
                    <div class="col-md-4">
						<input id="nazivfirme" type="text" name='nazivfirme' class="form-control" placeholder="Naziv firme*" value="<?php echo $mn1['nazivfirme']?>" required<?php echo $disdis?>>
                    </div>
                    <div class="col-md-4">
						<input id="pib" type="text" name="pib" class="form-control" placeholder="PIB*" value="<?php echo $mn1['pib']?>" required<?php echo $disdis?>>
                    </div>
<script>
document.getElementById("firma-lice").onchange = function() {
    document.getElementById("nazivfirme").disabled = (this.value == "lice" || this.value == "default");
	document.getElementById("pib").disabled = (this.value == "lice" || this.value == "default");
}
document.getElementById("firma-lice").change();
</script>
                     <div class="col-md-4">
						<input type="text" name='ime' placeholder="Ime i prezime*" value="<?php echo $mn1['ime']?>" required>
                    </div>
					<!--
                    <div class="col-md-4">
						<input type="text" name='nickname' id="username" placeholder="Jedinstveni naziv (nick name)*" value="<?php echo $mn1['nickname']?>" required>
						<div class="invalid-feedback"></div>
                    </div>
					-->
                    <div class="col-md-4">
						<input type="email" name='email' value="<?php echo $mn1['email']?>" placeholder="Email adresa*" required>
                    </div>
                    <div class="col-md-4">
						<input type="password" placeholder="Lozinka*" name="password" value="">
                    </div>
                    <div class="col-md-4">
						<input type="password" placeholder="Ponovite lozinku*" name="password1" value="">
                    </div>
                    <div class="col-md-4">
						<input type="text" placeholder="Telefon*" name="telefon" value="<?php echo $mn1['telefon']?>" required>
                    </div>
                    <div class="col-md-4">
						<input type="text" placeholder="Poštanski broj*" value="<?php echo $mn1['postanski_broj']?>" name="pbroj" required>
                    </div>
                    <div class="col-md-4">
						<input type="text" placeholder="Grad - Mesto*" value="<?php echo $mn1['grad']?>" name="grad" required>
                    </div>
                    <div class="col-md-4">
						<input type="text" placeholder="Ulica i broj*" name="ulica_broj" value="<?php echo $mn1['ulica_broj']?>" required>
                    </div>
					<!--
                    <div class="col-md-4">
						<input type="text" placeholder="Tekući račun" name="racun" value="<?php echo $mn1['tr']?>">
                    </div>
                    <div class="col-md-4">
						<input type="text" placeholder="Provizija (koristiti decimalnu tačku)" name="provizija" value="<?php echo $mn1['provizija']?>">
                    </div>
					-->
                    <div class="col-md-4">
                        <?php 
                        if($mn1['vesti']==1) $che="checked"; else $che="";
                        ?>
                        <span><input class="mr-10" type="checkbox" name="vesti" value="1" class="checkbox" <?php echo $che?>>Želim da dobijam vesti sa sajta</span>
                    </div>
					<!--
                      <div class="col-sm-12">
						<label for="avatar">Logo ili avatar. Dozvoljeni format: .jpg, .png i .gif. Preporučena visina slike: 150px.</label>
						<input type="file" placeholder="Tekući račun" id="avatar" name="avatar">
                    </div>
                        <?php
if(is_file($page_path2."/avatars/".$mn1['user_id']."/".$mn1['avatar'])) {
?>
      <div class="col-sm-12">
      <img src="<?php echo $patH."/avatars/".$mn1['user_id']."/".$mn1['avatar']?>" style='max-width:150px'>
      <br>
<input  type="checkbox" name="brisi" value="1" class="checkbox"> Obriši avatar/logo
<input type="hidden" name="stara_slika" value='<?php echo $mn1['avatar']?>' />
      </div>
      <?php } ?>
	  -->
                    <div class="col-sm-12">
						<input type="hidden" name="change_cand" value='<?php echo $_GET['id']?>' />
						<button type="submit" class="btn btn-default float-right">Sačuvaj izmene</button>
					</div>
				</div>
            </form>
		</div>
    </div>
</section>          
<?php } ?>                        
</body></html>