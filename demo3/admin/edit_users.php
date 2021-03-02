<?php 
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
include("$page_path3/Izvrsenja.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $patHA?>/css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
<?php 
   if(strlen($msgr)>2)
         {
         ?>   
         <div class='box'><div>
         <?php echo $msgr?>
         </div></div>
         <?php 
         }
   $nov="novi_user";       
 if($_GET[novi]>0 or $_GET[change]>0)
 {        
         ?>

<div style='display:block'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
		<form method="post" action="">
     <?php 

 
 if($_GET[change]>0)
 {
 $nov="izmeni_user";
 $tr=mysqli_query($conn, "SELECT * FROM users WHERE user_id=$_GET[change]");
 $tr1=mysqli_fetch_array($tr);
 $ar=mysqli_query($conn, "SELECT * FROM users_info WHERE user_id=$tr1[user_id]");
 $ar1=mysqli_fetch_array($ar);
 echo "<input type='hidden' name='user_id' value='$tr1[user_id]' />";
 }
  if($_GET[change]>0)
  echo "<h3>Izmena korisnika</h3>";
  else
  echo "<h3>Upis novog korisnika</h3>";
 ?>
 
    
    
    
    
    Ime i prezime
    <input type='text' name='ime' class='input_poljes'  value="<?php echo $_POST[ime]?$_POST[ime]:$ar1[name]?>">
    <br />
    <br />
     Adresa
    <input type='text' name='adresa' class='input_poljes'  value="<?php echo $_POST[adresa]?$_POST[adresa]:$ar1[address]?>">
    <br />
    <br />
     Grad
    <input type='text' name='grad' class='input_poljes'  value="<?php echo $_POST[grad]?$_POST[grad]:$ar1[city]?>">
    <br />
    <br />
     Telefon
    <input type='text' name='telefon' class='input_poljes'  value="<?php echo $_POST[telefon]?$_POST[telefon]:$ar1[phone]?>">
    <br />
    <br />
     Mobilni
    <input type='text' name='mobilni' class='input_poljes'  value="<?php echo $_POST[mobilni]?$_POST[mobilni]:$ar1[mobile]?>">
    <br />
    <br />
    Email korisnika: 
  <input type='text' name='emails' class='input_poljes' value="<?php echo $_POST[emails]?$_POST[emails]:$tr1[email]?>" >
    <br />
    <br />
    Lozinka: 
  <input type='text' name='sifra' class='input_poljes' value="" /> 
    <br /><br />
    <input type="submit" value="Sačuvaj podatke" name='<?php echo $nov?>' class='submit_dugmici_blue' />
    </form>
			</div>
		</div>       
<?php 
}
?>
