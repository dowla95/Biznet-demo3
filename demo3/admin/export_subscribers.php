<?php 
include("../Connections/conn_admin.php");

$output="";

$text = mysqli_query($conn, "SELECT email FROM subscribers ORDER BY email ASC");
while($text1 = mysqli_fetch_assoc($text))
{


$output .="\n".$text1['email'].PHP_EOL;
}
header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Cache-Control: private",false);
      header("Content-Transfer-Encoding: binary;\n");
      header("Content-Disposition: attachment; filename=\"emails-".date("d-m-Y-H-i-s").".txt\";\n");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
      header("Content-Description: File Transfer");
      header("Content-Length: ".strlen($output).";\n");
      echo $output;

?>