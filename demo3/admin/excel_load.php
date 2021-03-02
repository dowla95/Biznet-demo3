<div class='detaljno_smestaj whites'>
 
	<div class='naslov_smestaj_padd'><h1 class="border_ha">Učitavanje cena MTS paketa iz Excel fajla</h1></div>

<?php 

//if(!mysqli_query($conn, "ALTER TABLE `page` DROP `podnaslovslo`, DROP `h1slo`")) echo mysqli_error();

if($_POST[save_novi_jezik])
{

$im=mysqli_query($conn, "SELECT * FROM prol WHERE id_text IN (SELECT id FROM pro WHERE akt=1)");
    //$im=mysqli_query($conn, "SELECT * FROM prol WHERE naslov LIKE '%".$Row[1]."%'");
$nasl=array();    
while($im1=mysqli_fetch_assoc($im))
{ $rep=strtoupper(trim($im1['naslov']));
      /*  $rep=str_replace(" BLUE","",$rep);
        $rep=str_replace(" BLACK","",$rep);
        $rep=str_replace(" WHITE","",$rep);
		$rep=str_replace(" LITE BLK","",$rep);*/
        $nasl[$im1['id']]=$rep;
}

 $fileToDelete = glob('../excel_files/*');
foreach($fileToDelete as $file){ 
  if(is_file($file))
    unlink($file); 
}
if($_FILES['slika']['tmp_name'])
{
$slika =UploadSlika($_FILES['slika']['name'],$_FILES['slika']['tmp_name'],$_FILES['slika']['type'],$page_path2.SUBFOLDER."/excel_files/");
}

mysqli_query($conn, "TRUNCATE TABLE cene_paketa"); 

/**
 * XLS parsing uses php-excel-reader from http://code.google.com/p/php-excel-reader/
 */
//	header('Content-Type: text/html; charset=utf-8');

	
$Filepath="../excel_files/".$slika;
	// Excel reader from http://code.google.com/p/php-excel-reader/
	require('../excel_read/php-excel-reader/excel_reader2.php');
	require('../excel_read/SpreadsheetReader.php');

	date_default_timezone_set('UTC');

	$StartMem = memory_get_usage();
 
	try
	{
		$Spreadsheet = new SpreadsheetReader($Filepath);
		$BaseMem = memory_get_usage();

		$Sheets = $Spreadsheet -> Sheets();
 
		foreach ($Sheets as $Index => $Name)
		{
		 
			$Time = microtime(true);

			$Spreadsheet -> ChangeSheet($Index);

			foreach ($Spreadsheet as $Key => $Row)
			{
			 
				if ($Row)
				{
        if($Row[0]=="Biznet")
        {			 

                                        
    $broj=array_search(strtoupper(trim($Row[1])),$nasl);
      if($broj>0)
      {
      mysqli_query($conn, "INSERT INTO cene_paketa SET id_pro=$broj, cena='".$Row[5]."', paket='".$Row[10]."'");
      if(mysqli_insert_id($conn)>0)
			echo $Row[1]."------".$Row[5]."---------".$Row[10]."<br>";
      } 
       }
				}
				else
				{
					var_dump($Row);
				}
				$CurrentMem = memory_get_usage();
		
			 
		
				if ($Key && ($Key % 500 == 0))
				{
				 
				}
			}
		
		 
		}
		
	}
	catch (Exception $E)
	{
		echo $E -> getMessage();
	}
 

}

 
?> 
  
 
<ul class='forme_klasicne'>
 
 
 
 <br class='clear' /><br /><br />
<li>

 
 <form method="post" action=""   enctype="multipart/form-data">
Excel Fajl: <input type="file" name="slika" class='inputli' />

<input type='submit' name='save_novi_jezik' class="submit_dugmici_blue" value='Učitaj cene iz excel fajla' style='position:relative;top:2px;'>
</form>
<br /><br />
 </li>
 </ul>
<br />



		
</div> 




			

