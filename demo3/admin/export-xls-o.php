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
$objPHPExcel->getProperties()->setCreator("Biz Net")
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
            ->setCellValue('N1', 'Custom parameter');

$fi=mysqli_query($conn, "SELECT * FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id
WHERE p.tip=5  AND p.akt='1'  GROUP BY p.id ORDER BY  pl.naslov ASC LIMIT 5");
$i=2;
while($fi1=mysqli_fetch_assoc($fi))
{

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
echo $fi1['naslov']."<br>";
$i++;
}
// Rename worksheet

}