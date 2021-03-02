<?php 
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
?> 
 
<?php 
$smi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='$_POST[box]' AND box_position='$_POST[box_position]' AND id_page='$_POST[id_page]' AND id_text='$_POST[id_text]'");
 
if(mysqli_num_rows($smi)==0)
{ 
if($_POST[box_position]==0 and $_POST[id_page]==0) $gore=", gd='0'";
if($_POST[box_position]==2 and $_POST[id_page]==0) $gore=", gd='1'";
mysqli_query($conn, "INSERT INTO page_text SET box='$_POST[box]', box_position='$_POST[box_position]', id_page='$_POST[id_page]', id_text='$_POST[id_text]'$gore");
}
else
mysqli_query($conn, "DELETE FROM page_text WHERE box='$_POST[box]' AND box_position='$_POST[box_position]' AND id_page='$_POST[id_page]' AND id_text='$_POST[id_text]'");
 
echo "<li id='sortid_0'></li>";
echo "<li><b>Pozicija $_POST[box_position]</b></li>";
$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='$_POST[box]' AND box_position='$_POST[box_position]' AND id_page='$_POST[id_page]' ORDER BY pozicija ASC");
while($mi1=mysqli_fetch_assoc($mi))
{
if($mi1[id_text]>0)
{
$it=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$mi1[id_text]");
$it1=mysqli_fetch_array($it);
echo "<li id='sortid_$mi1[id]' style='padding:3px;background:#218FBF;width:100%;float:left;color:white;margin:1px 0px;'>$it1[naslovslo]</li>";
}
}
echo "";
?>