<?php 
session_start();
include("../Connections/conn.php");
$ide = preg_replace('#[^0-9]#i', '', $_GET['pro']);
if($ide>0)
{
if(!$_COOKIE['soglasi']) $_SESSION['soglasi']="";
if(!$_SESSION['soglasi'] and isset($_COOKIE['soglasi'])) $_SESSION['soglasi']=$_COOKIE['soglasi'];
$nizic=explode(",",$_SESSION['soglasi']);
if($nizic[0]=="")
array_shift($nizic);
if(!in_array($ide,$nizic))
{
$nizic[]=$ide;
$novi=implode(",",$nizic);
$_SESSION['soglasi']=$novi;
}else
{
if (($key = array_search($ide, $nizic)) !== false) 
    unset($nizic[$key]);
$novi=implode(",",$nizic);
$_SESSION['soglasi']=$novi;

}
setcookie("soglasi", $novi, time()+60*60*24*30, "/");
header("location: $patH/lista-zelja/");
} 
?>