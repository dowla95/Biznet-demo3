<?php 
session_start();
include("Connections/conn.php");
include("include/Izvrsenja.php");

echo json_encode($status);
?>