<?php 
$adm=mysqli_query($conn, "SELECT * FROM users_admin WHERE user_id=$_SESSION[userids] AND tip=1");
$admt=mysqli_fetch_array($adm);
if ($admt['tip']==1) {
?>
<br class='clear' />
<br />
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td width="40%">
<div class='naslov_smestaj'><h1>Administratori</h1></div>
</td>
 <td align='right'><a href="?novi=1" ><span style='padding:6px 10px;font-size:15px;'>Upiši novog admina</span></a>
<div class='trakica_pozadina'></div>
</td>
</tr>
</table>              
<?php 
$fi=mysqli_query($conn, "SELECT * FROM users_admin WHERE user_id>0 AND master=0 ORDER BY user_id DESC");
$hahord=preg_replace("/&ord=[0-9]/","",curPageURL());
 ?>
 <div id='sorting'>
<table class='upitnici_oglasi'>
<tbody id="slickbox1">
<!--<tr>
    <th colspan="3">Lista upitnika</th>
  </tr>-->
  <tr class="yellow" id="sortid_0"> 
    <td>Ime</td>
	<td>Tip</td>
    <td>Email</td>
    <td>Datum</td>
    <td>Aktivnost</td>   
    <td>Akcije</td>
  </tr>
<?php 
$i=0;
while($og1=mysqli_fetch_array($fi)){
if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';
$msg_id=$og1['id']; 
if($og1['tip']==1) $atip="Glavni administrator";
elseif($og1['tip']==2) $atip="Admin";
elseif($og1['tip']==3) $atip="Moderator";
//$brogs=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM oglasi WHERE user_id='$og1[user_id]' AND paket>0"));
//if($brogs>0) $ba="background:#FBEEEE;"; else $ba=""; 
?>
<tr id="sortid_<?php echo $og1['user_id']?>" style='<?php echo $ba?>'>
<td><?php echo $og1['name']?></td>
<td><?php echo $atip?></td>
<td><?php echo $og1['email']?></td>
<td>
<?php 
echo $og1['date'];
?>
</td>
<td>
<?php 
if($og1['akt']=="Y") $che="checked"; else $che="";
?>
<?php 
if($og1['email']!="aleksandrou@gmail.com" or $_SESSION['emails']=="aleksandrou@gmail.com")
{
?>
<input type='checkbox' value='1' <?php echo $che?> onclick="akti('<?php echo $og1['user_id']?>', 'akti_us_admin')" />
<?php 
}
?>
</td>
<td>
<?php 
if($og1['email']!="aleksandrou@gmail.com" or $_SESSION['emails']=="aleksandrou@gmail.com")
{
?>
<a href="<?php echo $patHA?>/?change=<?php echo $og1['user_id']?>" class="olovcica"><i class="fas fa-pencil-alt"></i></a>&nbsp;&nbsp;
<a href="javascript:;" class="crvena" onclick="obrisime(<?php echo $og1['user_id']?>,'delete_admin')"><i class="fal fa-trash-alt"></i></a>
<?php 
}
?>
</td>
</tr>
<?php 
$i++;
}
?>
</tbody>
  </table>
  </div>
  <?php 
} else {
$fit=mysqli_query($conn, "SELECT * FROM users_admin WHERE user_id>0 AND master=0 AND user_id=$_SESSION[userids]");
$ogi=mysqli_fetch_assoc($fit);
echo "<h1 class='text-center mb-20'>".$ogi['name'].", dobrodosli u administratorski panel ".$settingsc['site_name']."!</h1>
<p>Ulogovani ste sa email adresom: <b>".$ogi['email']."</b> i privilegijama koje ima <b>ADMIN</b> sajta.</p>
";
}
         if(strlen($msgr)>2)
         {
         ?>   
         <div class='box'><div>
         <?php echo $msgr?>
         </div></div>
         <?php 
         }
   $nov="novi_admin";       
 if($_GET['novi']>0 or $_GET['change']>0)
 {        
         ?>

<div style='display:block'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
		<form method="post" action="">
     <?php 
 if($_GET['change']>0)
 {
 $nov="izmeni_admin";
 $tr=mysqli_query($conn, "SELECT * FROM users_admin WHERE user_id=$_GET[change]");
 $tr1=mysqli_fetch_array($tr);
 if($tr1['tip']==1) $adtip="Glavni administrator";
elseif($tr1['tip']==2) $adtip="Admin";
elseif($tr1['tip']==3) $adtip="Moderator";
 echo "<input type='hidden' name='user_id' value='$tr1[user_id]' />";
 }
  if($_GET['change']>0)
  echo "<h3>Izmena administratora</h3>";
  else
  echo "<h3>Upis novog administratora</h3>";
 ?>
    Ime i prezime
    <input type='text' name='ime' class='input_poljes'  value="<?php echo $_POST['ime']?$_POST['ime']:$tr1['name']?>">
    <br />
    <br />
	Tip
<select name="tip" class="selecte">
<option value="<?php echo $tr1['tip']?>"><?php echo $adtip?></option>
<option value="1">Glavni administrator</option>
<option value="2">Admin</option>
<option value="3">Moderator</option>
</select>
    <br />
    <br />
    Email korisnika: 
  <input type='text' name='emails' class='input_poljes' value="<?php echo $_POST['emails']?$_POST['emails']:$tr1['email']?>" >
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