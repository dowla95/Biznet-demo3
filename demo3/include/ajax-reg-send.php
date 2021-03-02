<?php 
session_start();
include("../Connections/conn.php");
include("Izvrsenja.php");
$niv=array($msgr,$ende);
echo json_encode($niv);
?>