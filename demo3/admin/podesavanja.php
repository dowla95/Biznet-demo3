<div class='detaljno_smestaj whites'>
 
<div class='naslov_smestaj_padd'><h1 class="border_ha">Podešavanja</h1></div>

<?php 
if($_POST['izmene_stavkes'])
{
 $la=mysqli_query($conn, "SELECT * FROM settings");
 while($la1=mysqli_fetch_array($la))
 {
 $polje=$la1['fields'];
if(!mysqli_query($conn, "UPDATE settings SET vrednosti='$_POST[$polje]' WHERE fields='$polje'")) echo mysqli_error();
 }
 echo "<div class='infos1'><div>Izmenjeno</div></div>"; 
}
?> 
  
<form method="post" action="<?php echo $patHA?>/index.php?base=admin&page=podesavanja">
<ul class='forme_klasicne'>
<?php 
$se=mysqli_query($conn, "SELECT * FROM settings ORDER BY id ASC");
while($se1=mysqli_fetch_array($se))
{
if($se1[tip]==1)
{
?> 
 <li>
<?php echo $se1['naziv']?>: <br />
<input type="text" name='<?php echo $se1['fields']?>' class='selecte' value="<?php echo $se1['vrednosti']?>" />
</li>        
 <?php 
 }
 else
 {
?> 
 <li>
<?php echo $se1[naziv]?>: <br />
<textarea name='<?php echo $se1['fields']?>' class='selecte'><?php echo $se1['vrednosti']?></textarea>
</li>        
 <?php 
 }
}
 ?>
<li>

<input type='submit' name='izmene_stavkes' class="submit_dugmici_blue" value='Sačuvaj izmene'>
 </li>

 </ul>
<br />

</form>
		
</div> 