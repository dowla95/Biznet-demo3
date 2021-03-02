<?php 
include('Connections/conn.php');
session_start();
$path = "uploads/";
//	$valid_formats = array("jpg", "png", "gif", "JPG", "JPEG", "GIF", "PNG");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			if(strlen($name))
				{
        $ext= end(explode('.', $name));
 
				//	list($txt, $ext) = explode(".", $name);
					//if(in_array($ext,$valid_formats)){
							$tmp = $_FILES['photoimg']['tmp_name'];
 
if($tmp)
{$slika =UploadSlika($name,$tmp,$_FILES['photoimg']['type'],$page_path2."/private/temp_files/");}
					/*	}
						else
            {
						echo "<span style='color:red;display:block;padding-bottom:10px;'>Slika je pogresnog formata!</span>";
            }*/	
				}
			else{
				echo "<span style='color:red;display:block;padding-bottom:10px;'>Izaberite sliku!</span>";
         
        }
			exit;
		}
?>