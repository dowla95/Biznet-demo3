<?php 
include("header-top-add-user.php");
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
    <link href="<?php echo $uvoz?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $patH?>/fonts/pro/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="<?php echo $patH?>/css/prettyPhoto.css" rel="stylesheet">

	<link href="<?php echo $patH?>/css/main.css" rel="stylesheet">
	<link href="<?php echo $uvoz?>/css/responsive.css" rel="stylesheet">
<script src="<?php echo $patH?>/js/jquery.js"></script>
<script src="<?php echo $patH?>/js/js.js"></script>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
</head><!--/head-->
<body>
<section id="form"><!--form-->
		<div class="container">
			<div class="row">
 
					<div class="login-form col-sm-12"><!--sign up form-->
<h1 style='font-size:16px;color:red;'>Upis novog emaila</h1>
<?php 
if(isset($_POST['reg_sub']))
{
$uh=mysqli_num_rows(mysqli_query($conn, "SELECT email FROM subscribers WHERE email='$_POST[email]' AND NOT id=$_GET[id]"));
if($uh>0)
$msgr="Email vec postoji u bazi!";
else
{
mysqli_query($conn, "UPDATE subscribers SET email='$_POST[email]' WHERE id=$_GET[id]");
$msgr="Email <b>$_POST[email]</b> je izmenjen";
}
}
if($msgr!="")
echo "<div class='infob'><div class='info_box'><div>$msgr</div></div></div>";


$su=mysqli_query($conn, "SELECT * FROM subscribers WHERE id='$_GET[id]'");
$su1=mysqli_fetch_assoc($su);
?>    	

						<form action="" method="post">
                     
                        <div class="col-sm-4" style="padding-left:0px;">
							<input type="email"  value="<?php echo $su1['email']?>" name='email' placeholder="Email adresa*" required>
                        </div>
                         
                        <div class="col-sm-4">
<input type="hidden" name="reg_sub" value='1' />                                          
							<button type="submit" class="btn btn-default">Sačuvaj</button>
						</div>
                        </form>
					</div><!--/sign up form-->

			</div>
		</div>
	</section><!--/form-->
  </body>
  </html>