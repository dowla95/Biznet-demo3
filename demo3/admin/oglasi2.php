<br class='clear' />
?>
</td>
<td><?php echo $og1['br_pregleda']?></td>
<td>
<?php 
$hg=mysqli_query($conn, "SELECT * FROM kontakt WHERE id_oglasa='$og1[id]' AND id_por=0");

echo "<a href='$patHA/index.php?base=admin&page=poruke&id=$og1[id]'>";
echo mysqli_num_rows($hg);
echo "</a>";
?>
</td>
<td>
<?php 
$ku=mysqli_query($conn, "SELECT * FROM comments WHERE id_pro='$og1[id]' AND tip=0");
echo "<a href='$patHA/index.php?base=admin&page=comments&id_ap=$og1[id]&tip=0'>";
echo mysqli_num_rows($ku);
echo "</a>";
?>
</td>
<td>
<select id="paket" onchange="paket(this.value,'<?php echo $og1[id]?>')">
<?php 
for($i=0;$i<=$settings['number_packets'];$i++)
{
if($og1[paket]==$i) $spak="selected"; else $spak="";
echo "<option value='$i-$og1[id]' $spak>paket $i</option>";
}
?>
</select>
</td>
<td>
<?php 
if($og1[akt]=="Y") $che="checked"; else $che="";
?>
<input type='checkbox' value='1' <?php echo $che?> onclick="akti('<?php echo $og1[id]?>', 'akti')" />
</td>
<td>
<?php 
if($og1[akt2]==1) $cheh="checked"; else $cheh="";
?>
<input type='checkbox' value='1' <?php echo $cheh?> onclick="akti('<?php echo $og1[id]?>', 'oglasi_konurisanje')" />
</td>
<td>
<?php 
if($og1[sms]==1) $sheh="checked"; else $sheh="";
?>
<input type='checkbox' value='1' <?php echo $sheh?> onclick="akti('<?php echo $og1[id]?>', 'sms')" />
</td>

<td>
<?php 
?>
<a href='<?php echo $patHA?>/settings_show.php?id=<?php echo $og1[id]?>&tip=1' class='iframeB'><?php 
echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM settings_show WHERE idupisa=$og1[id] AND tip=1"));?></a>
</td> 
<td>
<a href="<?php echo $patHA?>/index.php?base=admin&page=izmena-oglas&id=<?php echo $og1[id]?>&korak=1" class="edit_oglas"><img src="<?php echo $patHA?>/images/b_edit.png" /></a>&nbsp;&nbsp;
<a href="javascript:;" class="edit_oglas" onclick="obrisime(<?php echo $og1[id]?>,'delete_oglas')"><img src="<?php echo $patHA?>/images/b_drop.png" /></a>
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
//$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 order by ISNULL(pozicija), pozicija ASC");
//$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 order by -pozicija DESC");
//while($fi1=mysqli_fetch_array($fi))
//echo $fi1[nameAdsslo]." - $fi1[pozicija]<br />"; 
?>
<div class='pagination_o'>	
	<?php 
$hah=preg_replace("/&p=[0-9]/","",curPageURL());
 if($br_upisa>$ByPage1)
echo $pagedResults->fetchPagedNavigation(curPageURL()."&p=");
  ?>
</div>
<?php 
   
  ?>
<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
		<form method="get" action="">
    <h3>Pronađite oglas</h3>
    Ukucajte pojam iz naziva oglasa:
    <br />
    <input type="hidden" name="base" value="<?php echo $_GET[base]?>" />
    <input type="hidden" name="page" value="<?php echo $_GET[page]?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='pojams' class='input_poljes'  value="<?php echo $_GET[pojams]?>">
    <br />
    <br />
    Email korisnika: 
     <input type='email' name='emails' class='input_poljes' value="<?php echo $_GET[emails]?>" >
    <br />
    <br />
   Mesto:<br />
    <select name="id_city" class='selecte'>
    <option value=''>----</option>
    <?php 
$gg=mysqli_query($conn, "SELECT * FROM city_name order by naziv asc");
while($gg1=mysqli_fetch_array($gg))
{
if($id_city_get==$gg1[id]) $tcity="selected"; else $tcity="";
    echo "<option value='$gg1[id]' $tcity>".$gg1["naziv$lang"]."</option>";
}
    ?>
    </select>
    <br /><br />
    Paket<br />
    <select  name="paket" class='selecte'>
    <option value=''>---</option>
<?php 
for($i=0;$i<=$settings['number_packets'];$i++)
{
if($_GET['paket']==$i and $_GET['paket']!="") $spak="selected"; else $spak="";
echo "<option value='$i' $spak>paket $i</option>";
}
?>
</select>
    <br /><br />
    <?php 
    if($_GET['admino']==1) $admino1="checked";
    else if($_GET['admino']==2) $admino2="checked"; else $admino="checked";
    if($_GET['tipi1']==1) $tipi1="checked";
    if($_GET['tipi2']==1) $tipi2="checked";
    ?> 