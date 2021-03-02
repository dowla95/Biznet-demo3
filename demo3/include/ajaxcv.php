<?php 
include('../Connections/conn.php');
$tip=$_POST['tip_fajla']; 
$valid_formats = array("jpg", "JPG", "gif", "GIF", "png", "PNG", "jpeg", "JPEG");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES[$tip]['name'];
      $tmp = $_FILES[$tip]['tmp_name'];
      $type=$_FILES[$tip]['type'];
      if(isset($_FILES[$tip]['name']))
      {
        $axi=explode('.', $name);
        $ext= end($axi);
    }
				//	list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
if($tmp)
{
$slika =UploadSlika($name,$tmp,$type,$page_path2."/private/temp_files/");}
  
     if($slika!="" and is_file($page_path2."/private/temp_files/$slika"))
     {
 
     echo filtriraj($slika);
     }				
						}
						else
           echo 1;
 
				
			exit;
		}
?>
