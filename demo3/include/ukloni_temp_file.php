<?php 
session_start();
include("../Connections/conn.php");
unlink("$page_path2/private/temp_files/$_POST[file]");
?>
