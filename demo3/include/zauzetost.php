<?php 
include("../Connections/conn.php");
echo "<div style='float:left;width:100%px;height:10px;'>
<a href='javascript:void(0)' onclick=\"ds_sh2('','close','1',1,1,$_GET[cal])\" style='border:0px;'>
<img src='$patH/images/cancel.png'  border='0'></a>
</div>";
$n=mysqli_query($conn, "SELECT * FROM proizvodi WHERE id='$_GET[id_sobe]' AND id_page='$_GET[cal]'");
$tr=mysqli_fetch_array($n);
if($tr) echo ""; else echo mysqli_error();
echo "<div style='color:black;font-weight:normal;padding:3px;border:1px solid black;font-size:13px;text-align:justify;background:white;'><span style='font-weight:bold;font-size:15px;'>$tr[naslov]</span><br>";
 $text=$tr['opis']; 
echo $text; 
echo "</div>";
?>
