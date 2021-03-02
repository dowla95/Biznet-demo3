<?php 
echo "<div style='width:100%;float:left;padding-top:10px;'>";
read_files("idstrane",$fi1['id'],$fi1['id_page'],$patH,$page_path2);
echo "</div>";
echo "<div style='width:100%;float:left;padding-top:10px;'>"; 
$ar=mysqli_query($conn, "SELECT * FROM slike_paintb WHERE  idstrane=$fi1[id] AND akt='Y' AND id_page=$fi1[id_page]");
$t=1;
while($ar1=@mysqli_fetch_array($ar))
{
$img=image_size2(115,'',$ar1['slika'],"private/galerija");
$im=explode("-",$img);
$width=115;
$height=$im[1];
if($im[1]>90){
$img=image_size2('',90,$ar1['slika'],"private/galerija");
$im=explode("-",$img);
$height=90;
$width=$im[0];
}
$b=$t%4;
if($b==1 and $t>0)
echo "<div style='float:left;width:100%;height:10px;'></div>";
echo "<div style='float:left;'>";
echo "<a href='".$patH."/galerija/$ar1[slika]' title='$vr1[ime]'  rel='shadowbox[Mixed];'><img src='".$patH."/galerija/thumb/$ar1[slika]' title='$fi1[naslov]' width='$width' height='$height' style='margin-right:3px;border:1px solid #f1f1f1;padding:2px;' /></a>";
echo "</div>";
$t++;
}
echo "</div>";
?>