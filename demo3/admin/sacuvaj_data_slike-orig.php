<?php 
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
$id=$_POST['idslike'];
$column=array("");
$column_imp=implode(",",$column);
if($_POST['akti']==1) $akti="Y"; else $akti="N";
if($_POST['poc']==1) $akti1="Y"; else $akti1="N";
if($_POST['pozicija']!="") $pozicija=",pozicija='$_POST[pozicija]'";
else $pozicija= ",pozicija=NULL"; 
if($akti1!="") $poce=", poc='$akti1'";
/*if($_POST['subtip']!='') {
$ep=explode("-",$_POST['subtip']);
if(mb_eregi("-",$_POST['subtip'])) {
$pi=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM slike WHERE tip=3 and subtip=$ep[0]"));
if($pi==$ep[1]) {
echo "Vec ste dodali maksimalan broj slika ovog tipa ".$nizSub[$_POST['subtip']];
exit();
}
}
$subtip=", subtip=".$ep[0];} else */$subtip="";
if(!mysqli_query($conn, "UPDATE $_POST[tabli] SET akt='$akti', link=".safe($_POST["link"])."$poce$pozicija$subtip  WHERE id=$id")) echo mysqli_error();
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
{
$lang=$la1['jezik'];
$column="alt=".safe($_POST["alt$lang"]).", title=".safe($_POST["title$lang"]).", ulink=".safe($_POST["ulink$lang"]);
if(!mysqli_query($conn, "UPDATE slike_lang SET $column WHERE id_slike=$id AND lang='$lang'")) echo mysqli_error();
}
//if(mysqli_affected_rows()>0)
///echo "IZMENJENO";
?>