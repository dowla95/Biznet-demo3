<?php 
include("../Connections/conn_admin.php");
$nizi=explode("###",$_POST['ara']);
array_shift($nizi);

mysqli_query($conn, "DELETE FROM menus_list WHERE id_menu='$_GET[id]'");
$i=0;
foreach($nizi as $key => $value)
{
$nizi1=explode("-",$value);
$cc=count($nizi1);
if($cc==1)
{
//echo $value." nivo 1<br>";
if(!mysqli_query($conn, "INSERT INTO menus_list SET id=$value, id_parent=0, nivo=1, id_menu='$_GET[id]', position=$i")) echo mysqli_error();
}
else
if($cc==2)
//echo $value." nivo 2<br>";
mysqli_query($conn, "INSERT INTO menus_list SET id=$nizi1[1], id_parent=$nizi1[0], nivo=2, id_menu='$_GET[id]', position=$i");
else
if($cc==3)
//echo $value." nivo 3<br>";
mysqli_query($conn, "INSERT INTO menus_list SET id=$nizi1[2], id_parent=$nizi1[1], nivo=3, id_menu='$_GET[id]', position=$i");
else
if($cc==4)
//echo $value." nivo 4<br>";
mysqli_query($conn, "INSERT INTO menus_list SET id=$nizi1[3], id_parent=$nizi1[2], nivo=4, id_menu='$_GET[id]', position=$i");
$i++;
}
echo "Izmenjeno";
?>