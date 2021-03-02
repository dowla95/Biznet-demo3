<?php 
echo "<div style='float:left;width:100%;height:10px;'></div>";
$ar=mysqli_query($conn, "SELECT * FROM flash WHERE  idstrane=$fi1[id] AND akt='Y' AND id_page=$fi1[id_page]");
$t=1;
while($ar1=@mysqli_fetch_array($ar))
{

$nas=explode("<>",$ar1[naslov]);
$b=$t%2;
if($b==1 and $t>0)
echo "<div style='float:left;width:100%;height:20px;'></div>";

echo "<div style='float:left;margin-right:10px;'>";
echo "<div class='naslov'>$nas[$ufi]</div>";
?>
<div id="container<?php echo $ar1['id']?>">Please download <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> .</div> 
 
<script type="text/javascript"> 
var s1 = new SWFObject("<?php echo $patH?>/player.swf","mediaplayer","247","200","10"); //samo izmenite sirinu i visinu 
s1.addParam("allowfullscreen","true"); 
s1.addVariable("width","247"); //opet, promenite sirinu 
s1.addVariable("height","200"); //kao i visinu 
s1.addVariable("file","<?php echo $patH?>/files/<?php echo $ar1[opis]?>"); //i ovde upisite putanju do fajla 
s1.write("container<?php echo $ar1['id']?>"); 
</script>
<?php 
echo "</div>";
$t++;
}
echo "<div style='float:left;width:100%;height:10px;'></div>";
$ar=mysqli_query($conn, "SELECT * FROM youtube WHERE  idstrane=$fi1[id] AND akt='Y' AND id_page=$fi1[id_page]");
$t=1;
while($ar1=@mysqli_fetch_array($ar))
{
$nas=explode("<>",$ar1[naslov]);
$b=$t%2;
if($b==1 and $t>0)
echo "<div style='float:left;width:100%;height:20px;'></div>";

echo "<div style='float:left;margin-right:10px;'>";
//echo "<div class='naslov'>$nas[$ufi]</div>";
$pro_v=str_replace("watch?v=","embed/",$ar1[link]);
$pro_v=str_replace("youtu.be","www.youtube.com/embed",$pro_v);
?>
<iframe title="YouTube video player" width="267" height="230" src="<?php echo $pro_v;?>" frameborder="0" allowfullscreen></iframe>

<?php 
echo "</div>";
$t++;
}
echo "<div style='float:left;width:100%;height:10px;'></div>";
?>
