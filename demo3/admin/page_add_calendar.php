<?php 
include("tiny_mce.php");
?>
<div class='detaljno_smestaj whites'>
 
 
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td width="40%">

	<div class='naslov_smestaj_padd'><h1 class="border_ha">Upis teksta za Kalendar</h1></div>
</td>
 <td align='right'><a href="<?php echo $patHA?>/index.php?base=admin&page=page_calendar&cal=<?php echo $_GET['cal']?>"><span style='padding:6px 10px;font-size:15px;'>UPISANI TEKSTOVI KALENDARA</span></a>
<div class='trakica_pozadina'></div>
</td>
 
 

</tr>
</table>        
 
 
<?php 
if($_POST[save_tekst_calendar])
{
if(mysqli_query($conn, "INSERT * INTO proizvodi SET naslov='$_POST[naslov]', opis='$_POST[opis]', id_page='$_GET[cal]'"))
{
$msr="Tekst je upisan. Vratite se na prethodnu stranicu i uredite datume: ";
$msr .='<a href="'.$patHA.'/index.php?base=admin&page=page_calendar&cal='.$_GET['cal'].'"><span style="padding:6px 10px;font-size:15px;">UPISANI TEKSTOVI KALENDARA</span></a>';
}
}
if($msr!="")
echo "<div class='infos1'><div>$msr</div></div>";
 
 
?> 
   
<form method="post" action="" enctype="multipart/form-data">
 
 

 
       
<br />
 <div class="ui-tabs">
 
 
	<div id="tabs-1" class="ui-tabs-panel">
 

 
 U naslovu<br />

 <input type="text" name='naslov' class='selecte' style='' />
 
 <br />
<br />
 
 
<br /><label>Opis</label><br />
<textarea cols="80" id="editor" name="opis" rows="10" style="width:100%"></textarea>

 
</div>
</div>
 
 
 
 
</div>
<br class='clear' />
<br /> 
 
<input type='submit' name='save_tekst_calendar' class="submit_dugmici_blue" value='<?php echo $langa['language'][4]?>'>
 
<br />

</form>
 
</div>