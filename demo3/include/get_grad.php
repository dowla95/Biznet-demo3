<?php 
include("Connections/conn.php");
if($_POST[delis1]>0) 
$id_kat=$_POST[delis1];

$id=$_POST[delis];

$dr=mysqli_query($conn, "SELECT * FROM gradovi WHERE drzava=".safe($id)." ORDER BY grad  ASC");
echo "<option value=''>- Odaberite grad -</option>";
while($dr1=mysqli_fetch_array($dr))
{
if($id_kat==$dr1['id']) $sel="selected"; else $sel="";
echo "<option value='$dr1['id']' $sel>$dr1[grad]</option>";
}
 
 
?>
