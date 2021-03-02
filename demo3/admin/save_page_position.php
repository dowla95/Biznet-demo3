<?php
include("../Connections/conn_admin.php");
$nizi=explode("###",$_POST['ara']);
array_shift($nizi);


$i=1;
$novi=array();
foreach($nizi as $key => $value)
{
$nizi1=explode("-",$value);
$cc=count($nizi1);
$nizi1=array_reverse($nizi1);
//echo $nizi1[0]." ===== $value<br />";
$novi[$cc][]=$nizi1[1]."-".$nizi1[0];
//echo $value." nivo 1<br>";
if($nizi1[1]!="") $idp=$nizi1[1]; else $idp=0;
//if(!mysqli_query($conn, "UPDATE page SET nivo=$cc, position=$i, id_parent=$idp WHERE id=$nizi1[0]")) echo mysqli_error();

$i++;
}
/*echo "<pre>";
print_r($novi);
echo "</pre>";*/
//echo $_POST['ara'];
foreach($novi as $kk=> $vv)
{
  foreach($vv as $key=> $val)
  {
  $nizi1=explode("-",$val);
  if($nizi1[0]!="") $idp=$nizi1[0]; else $idp=0;
  if(!mysqli_query($conn, "UPDATE page SET nivo=$kk, position=$key, id_parent=$idp WHERE id=$nizi1[1]")) echo mysqli_error();
  }
}
?>