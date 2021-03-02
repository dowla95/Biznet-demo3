<?php 
include("configs.php");

$mysqli = new mysqli($hostname_conn, $username_conn, $password_conn,$database_conn);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

include($page_path2."/private/include/functions.php"); 
$nodom=str_replace("$patH1/","",curPageURL());

$nodom_ex=explode("/",$nodom);

$query="SELECT * FROM language WHERE akt='Y'";
if ($result = $mysqli->query($query)) {
 
while($row = $result->fetch_assoc())
{
$jezici[]=$row['jezik'];
if($nodom_ex[0]==$row['jezik'])
$lang=$row['jezik'];
echo $row['jezik'];
}
$result->free();
}
/*if($lang=="") $lang="slo"; 
 
if($lang=='slo')
$patH1=$patH1;
  else
$patH1=$patH1."/".$lang;
if($lang=="" or $lang=="slo")
$cpage=trim(strip_tags($nodom_ex[0]));
else
$cpage=trim(strip_tags($nodom_ex[1]));
*/
$query = "SELECT * FROM page LIMIT 1";
if ($result = $mysqli->query($query)) {
    /* Get field information for all columns */
    $finfo = $result->fetch_fields();
    foreach ($finfo as $val) {
        printf("Name:     %s\n", $val->name);
    }
    $result->close();
}
/* close connection */
$cpage=trim(strip_tags($nodom_ex[0]));
$page=mysqli_query($conn, "SELECT * FROM page WHERE ulinkslo=".safe($cpage)."");
$page1=mysqli_fetch_assoc($page);
if($page1['id']>0)
{
$lang="slo";
}
else
{
}
if($lang=="") $lang="slo"; 
if($lang=='slo')
$patH1=$patH1;
  else
$patH1=$patH1."/".$lang;
$search_values=explode("?",curPageURL());
$base_arr=base_ret($_GET['base']);
$base_arr_r=base_ret_rev(curPageURL());
//echo $base_arr_r[0];
$strana = $_SERVER['PHP_SELF'];
$exp_str=explode("/",$strana);
$rev_str=array_reverse($exp_str);
$file_exp=explode(".php",$rev_str[0]);
$file_p="$file_exp[0]".".php";

$sett=mysqli_query($conn, "SELECT * FROM settings");
while($sett1=mysqli_fetch_assoc($sett))
{
$polje=$sett1['fields'];
$settings[$polje]=$sett1['vrednosti'];
}
//include("$page_path2/private/dir/login1.php");
if($lang=='slo')
include($page_path2."/private/language/srb.php");
else
include($page_path2."/private/language/$lang.php");
$ge=array("");
$geti=array("");
putenv ("TZ=Europe/Belgrade");
?>