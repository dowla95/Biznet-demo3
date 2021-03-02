<?php 
session_start();
$sid=session_id();
if($_SESSION['userids']>0)
{
include("../Connections/conn_admin.php");
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/Belgrade');
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
/** Include PHPExcel */
require_once  '../excel-php/Classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Amazonka")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("BizNet file");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'ID2')
            ->setCellValue('C1', 'Item title')
            ->setCellValue('D1', 'Final URL')
            ->setCellValue('E1', 'Image URL')
            ->setCellValue('F1', 'Item subtitle')
            ->setCellValue('G1', 'Item description')
            ->setCellValue('H1', 'Item category')
            ->setCellValue('I1', 'Price')
            ->setCellValue('J1', 'Sale price')
            ->setCellValue('K1', 'Contextual keywords')
            ->setCellValue('L1', 'Item address')
            ->setCellValue('M1', 'Tracking template')
            ->setCellValue('N1', 'Custom parameter')
            ->setCellValue('O1', 'EAN KOD');
			
			
			
$fi=mysqli_query($conn, "SELECT * FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id
WHERE p.tip=4  AND p.akt='1'  GROUP BY p.id ORDER BY  pl.naslov ASC");
$i=2;
while($fi1=mysqli_fetch_assoc($fi))
{
 $ean = (string) $fi1['link'];
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE p.id=$fi1[brend] AND  p.nivo=1 AND  p.akt=1 AND p.id_cat=27");
   $tz1=mysqli_fetch_array($tz);
// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $fi1['id'])
            ->setCellValue('B'.$i, '')
            ->setCellValue('C'.$i, $fi1['naslov'])
            ->setCellValue('D'.$i, 'https://amazonka.rs/proizvodi/'.$fi1['ulink'].'/')
            ->setCellValue('E'.$i, 'https://amazonka.rs/galerija/thumb/'.$fi1['slika'])
            ->setCellValue('F'.$i, $fi1['marka'])
            ->setCellValue('G'.$i, $fi1['altslike'])
            ->setCellValue('H'.$i, 'Amazonka - '.$tz1['naziv'])
            ->setCellValue('I'.$i, ($fi1['cena']*$settings['evro_iznos']).' RSD')
            ->setCellValue('J'.$i, 'RSD')
            ->setCellValue('K'.$i, '')
            ->setCellValue('L'.$i, '')
            ->setCellValue('M'.$i, '')
            ->setCellValue('N'.$i, '')
            ->setCellValue('O'.$i, $ean);
$i++;
}

$fi=mysqli_query($conn, "SELECT * FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id
WHERE p.tip=5  AND p.akt='1'  GROUP BY p.id ORDER BY  pl.naslov ASC");
while($fi1=mysqli_fetch_assoc($fi))
{
 $ean = (string) $fi1['link'];
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE p.id=$fi1[brend] AND  p.nivo=1 AND  p.akt=1 AND p.id_cat=27");
   $tz1=mysqli_fetch_array($tz);
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
       WHERE p.id=$fi1[kategorija]");
   $az1=mysqli_fetch_array($az);
$sz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
       WHERE p.id=$az1[id_parent]");
   $sz1=mysqli_fetch_array($sz);
// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $fi1['id'])
            ->setCellValue('B'.$i, '')
            ->setCellValue('C'.$i, $fi1['naslov'])
            ->setCellValue('D'.$i, 'https://amazonka.rs/proizvodi/'.$fi1['ulink'].'/')
            ->setCellValue('E'.$i, 'https://amazonka.rs/galerija/thumb/'.$fi1['slika'])
            ->setCellValue('F'.$i, $fi1['marka'])
            ->setCellValue('G'.$i, $fi1['altslike'])
            ->setCellValue('H'.$i, 'Amazonka - '.$sz1['naziv'].' - '.$az1['naziv'])
            ->setCellValue('I'.$i, ($fi1['cena']*$settings['evro_iznos']).' RSD')
            ->setCellValue('J'.$i, 'RSD')
            ->setCellValue('K'.$i, '')
            ->setCellValue('L'.$i, '')
            ->setCellValue('M'.$i, '')
            ->setCellValue('N'.$i, '')
            ->setCellValue('O'.$i, $ean);
$i++;
}


$fi=mysqli_query($conn, "SELECT * FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id
WHERE p.tip=6  AND p.akt='1'  GROUP BY p.id ORDER BY  pl.naslov ASC");
$i=2;
while($fi1=mysqli_fetch_assoc($fi))
{
 $ean = (string) $fi1['link'];
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE p.id=$fi1[brend] AND  p.nivo=1 AND  p.akt=1 AND p.id_cat=27");
   $tz1=mysqli_fetch_array($tz);
// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $fi1['id'])
            ->setCellValue('B'.$i, '')
            ->setCellValue('C'.$i, $fi1['naslov'])
            ->setCellValue('D'.$i, 'https://amazonka.rs/televizori/'.$fi1['ulink'].'/')
            ->setCellValue('E'.$i, 'https://amazonka.rs/galerija/thumb/'.$fi1['slika'])
            ->setCellValue('F'.$i, $fi1['marka'])
            ->setCellValue('G'.$i, $fi1['altslike'])
            ->setCellValue('H'.$i, 'Amazonka - '.$tz1['naziv'])
            ->setCellValue('I'.$i, ($fi1['cena']*$settings['evro_iznos']).' RSD')
            ->setCellValue('J'.$i, 'RSD')
            ->setCellValue('K'.$i, '')
            ->setCellValue('L'.$i, '')
            ->setCellValue('M'.$i, '')
            ->setCellValue('N'.$i, '')
            ->setCellValue('O'.$i, $ean);
$i++;
}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Custom Feed Template - BizNet');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="amazonka-kozmetika.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
}