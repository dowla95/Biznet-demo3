<?php 
session_start(); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
<META http-equiv=content-type content="text/html; charset=utf-8" />
<meta name="generator" content="PSPad editor, www.pspad.com">
<link href="<?php echo $patH?>/panel/js_css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $patH?>/panel/js_css/style_m.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $patH?>/panel/js_css/style_page.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $patH?>/panel/jscripts/tiny_mce/tiny_mce.js"></script>

 <script type="text/javascript" src="<?php echo $patH?>/panel/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript">

tinyMCE.init({
	//	editor_selector : "mceEditor",
    editor_deselector : "mceNoEditor",
		mode : "textareas",
		theme : "advanced",
width : "780",
height : "400",

file_browser_callback : "tinyBrowser",

plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

// Theme options

//		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",

		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",

		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",

		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",

		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",

		theme_advanced_toolbar_location : "top",

		theme_advanced_toolbar_align : "left",

		theme_advanced_statusbar_location : "bottom",

		theme_advanced_resizing : true,

 theme_advanced_font_sizes : "8px=8px, 10px=10px, 11px=11px, 12px=12px, 13px=13px,  14px=14px, 16px=16px, 18px=18px, 20px=20px, 22px=22px, 24px=24px, 26px=26px",

		// Example content CSS (should be your site CSS)
		// using false to ensure that the default browser settings are used for best Accessibility
		// ACCESSIBILITY SETTINGS
		// Use browser preferred colors for dialogs.
		browser_preferred_colors : true,
		detect_highcontrast : true, 
theme_advanced_resizing_use_cookie : false,
 		relative_urls : false,
remove_script_host : false,
        convert_urls : false
	});
function toggleEditor(id) {
if (!tinyMCE.get(id))
tinyMCE.execCommand('mceAddControl', false, id);
else
tinyMCE.execCommand('mceRemoveControl', false, id);
}

</script>
 
  </head>
  <body>
  <?php 
$tabela=$exp_tab[0];
$tabela1=$exp_tab[1];
if($_GET[vrsta]) 
{
$se=mysql_query("SELECT * FROM $tabela WHERE id=$_GET[idupisa]");
$se1=mysql_fetch_array($se);
$naslov=htmlspecialchars(stripslashes($se1[naslov]));
$podnaslov=htmlspecialchars(stripslashes($se1[podnaslov]));
$opis=$se1[opis];

$opis1=$se1[opis1];
$nonvest1=str_replace("\r", "", $opis1);
$nonvest1=str_replace("\t", "", $nonvest1);
$nonvest1=str_replace("\n", "", $nonvest1);
$opis1=addslashes($nonvest1);
//$nonvest=str_replace('\\', '', $nonvest);
//$nonvest=str_replace("/", "", $nonvest);
$cena=$se1[cena];
$cena1=$se1[cena1];
$povrsina=$se1[povrsina];
$lokacija=$se1[lokacija];
$slika1=$se1[slika1];$slika2=$se1[slika2];$slika3=$se1[slika3];
$slika4=$se1[slika4];$slika5=$se1[slika5];$slika6=$se1[slika6];
$katidd=$se1[katid];
}else 
{
$tabela=$exp_tab[0];
$tabela1=$exp_tab[1];
$cena="";
}
if(!$_GET[vrsta]) $opis="";
?>

  <table width="100%" height="500" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
  <tr bgcolor="#D7D7D7"> 
<td align="left" valign="top" bgcolor="#E5E5E5" >

<form method="post" action="" enctype="multipart/form-data" onSubmit="return submitForm();" style="padding:10px;">
<?php 
if($mess_error!="")
echo "<div style='position:relative;top:-10px;width:100%;background:#F0F0EE;border:1px solid red;border-top:0px;color:red;font-weight:bold;'><div style='padding:10px;'>$mess_error</div></div>";
?>    
<a href="admin.php?id=<?php echo $_GET[id]?><?php echo $querys?>" style='float:right;'>Idi na listanje prozivoda</a>

          <table style="font-size:12px;color:black;font-weight:bold;width:80%;">
            <tr valign='top'>   
     <td>Naziv:<br><input type="text" name="naslov" size="30" value="<?php echo $_POST[naslov]?$_POST[naslov]:$naslov?>"><br>
     Marka-Tip:<br><input type="text" name="podnaslov" size="30" value="<?php echo $_POST[podnaslov]?$_POST[podnaslov]:$podnaslov?>">
    
    </td>
     <td><?php echo $cmsniz[all][12]?><br><input type='text' name='cena' size='15' value='<?php echo $_POST[cena]?$_POST[cena]:$cena?>'>
<!--  <br>Stara cena:<br>
     <input type="text" name="cena1" size="15" value="<?php echo $_POST[cena1]?$_POST[cena1]:$cena1?>">--></td>
     
<td colspan=2 valign='top'>
             
            <?php 
            
echo "Kategorija (Vrsta proizvoda)<br>";
      include("select_lista1.php");  
      echo "<br>";
      //echo "<input type='hidden' name='idkat' value='331' />";
      $sel_gal=mysql_query("SELECT * FROM kateg_proizvoda_new1 WHERE id_page='$_GET[id]' AND firma=1 ORDER BY  ime ASC");
echo "Firme:<br>";
echo "<select name='idfirme' >";
echo "<option value='' $fir>Izaberite firmu</option>";
while ($sel_gal1=mysql_fetch_array($sel_gal)){
if($se1[idfirme]==$sel_gal1[id]) $fir="SELECTED"; else $fir="";
echo "<option value='$sel_gal1[id]' $fir>$sel_gal1[ime]</option>";
}
echo "</select>";   
            ?>
            
            <br /><br />
            Na lageru:
            <?php 
            if($se1[nalageru]==1 or $_POST[lager]==1) $che="CHECKED"; else $che="";
            if($se1[nalageru]==0) $che1="CHECKED"; else $che1="";
            ?>
     Da:<input type="radio" name="lager" <?php echo $che?>  value="1">&nbsp;&nbsp;
     Ne:<input type="radio" name="lager" <?php echo $che1?> value="0">
           
       </td>
            </tr>
          
            <tr><td  colspan="3">   
<b>Filter stavke</b><br />
       
 <div style='width:600px;height:400px;overflow:auto;border:1px solid #999;font-weight:normal;'>
 <?php 
 $fis=mysql_query("SELECT * FROM kateg_proizvoda_new1 WHERE id_parent=0 AND firma=0");
 echo "<input type='hidden' name='ukus' value='".mysql_num_rows($fis)."' />";
 $i=0;
 while($fis1=mysql_fetch_array($fis))
 {
 ?>
<div style='width:100%;padding:1px 0px;background:#eee;margin-top:4px;'><b><?php echo $fis1[ime]?></b></div>
<?php 
 $dis=mysql_query("SELECT * FROM kateg_proizvoda_new1 WHERE id_parent=$fis1[id]");
 $j=0;
 while($dis1=mysql_fetch_array($dis))
 {
 if($_GET[vrsta]!="")
{
$eh=mysql_num_rows(mysql_query("SELECT * FROM filter_pro WHERE id_pro=$_GET[idupisa]  AND id_fil=$dis1[id]"));
if($eh>0) $chekme="checked"; else $chekme="";
}else
{
if(@in_array($dis1[id],$_POST[filter]))
$chekme="checked"; else $chekme="";
}
 ?>
<input value="<?php echo $dis1[id]?>" type='radio' name="filt<?php echo $i?>" id="ime<?php echo $i?><?php echo $j?>" <?php echo $chekme?> /> <label for="ime<?php echo $i?><?php echo $j?>"><?php echo $dis1[ime]?></label><br />
  <?php 
  $j++;
  }
  ?>

<?php 
$i++;
}
?> 
</div>
<br />
   </td>
   <td>
<?php 
$tip=explode("-",$se1[idtip]);
echo "
<table style='width:100%;color:red;font-size:11px;'>
";

for($f=1;$f<count($tipov);$f++)
{
if($br=array_search($f,$tip)) $ste="CHECKED"; else $ste="";
if($f!=4 and $f!=5)
echo "<tr><td><input type='checkbox' name='tip$f' $ste value='$f'> $tipov[$f]</td></tr>";

}
echo "</table>";
    ?>
   </td>
   </tr>
<tr><td  colspan="4" valign='top'>
<div class="tehnologije">
<?php 
$teh=mysql_query("SELECT * FROM strane WHERE id_page=88 AND akt='Y'");
while($teh1=mysql_fetch_assoc($teh))
{
if($_GET[vrsta]!="")
{
$eh=mysql_num_rows(mysql_query("SELECT * FROM teh_pro WHERE id_pro=$_GET[idupisa]  AND id_teh=$teh1[id]"));
if($eh>0) $chekme="checked"; else $chekme="";
}
echo "<input type='checkbox' value='$teh1[id]' name='teh[]' $chekme />$teh1[naslov]<br />";
}
?>
</div>
</td></tr>

            <tr>
          <td colspan="2">
          <?php if($_GET[vrsta] and !empty($slika1)) echo "<a href=\"../images/".$slika1."\" target=\"_blank\"><img src=\"../images/".$slika1."\" width='80'  alt=\"Thumbnail\" border=\"1\"></a> 
          Izbrisi: <input type='checkbox' name='a1' value='1'>
          ";?>
           <input type="file" name="slika1"></td>
           <td colspan="2"><?php 
           
           //echo $cmsniz[all1][11]2:
           //if($_GET[vrsta] and !empty($slika2)) echo "<a href=\"../galerija/".$slika2."\" target=\"_blank\"><img src=\"../images/".$slika2."\" width='30' height='30' alt=\"Thumbnail\" border=\"1\"></a><br>
          //Izbrisi: <input type='checkbox' name='a2' value='2'>";
          //<input type="file" name="slika2">
          ?>
            <br></td>
            </tr>
           
           <input type='hidden' name='tabela_upisa' value="<?php echo $tabela?>">
           <input type='hidden' name='id_page' value="<?php echo $_GET[id]?>">
              <tr><td colspan="3">
              <?php $ex=explode('.',$sn1[fajl]);
              if($_GET[vrsta]){
          echo "<input type='hidden' name='mestoizmene' value='$ex[0]'>";
          echo "<input type='hidden' name='idupisa' value='$_GET[idupisa]'>";
          echo "<input type='hidden' name='tabela' value='$tabela'>";
          echo "<input type='hidden' name='sl1' value='$slika1'>";
           echo "<input type='hidden' name='sl2' value='$slika2'>";
               }else{
              ?>
              <input type="hidden" name="mestoupisa" value="<?php echo $exp_tab[0]?>">
                 <input type='hidden' name='id_page' value="<?php echo $_GET[id]?>">
              <?php } ?>
             
              </td></tr>
              
            </table>
          <textarea id="elm1" name="rte1" rows="15" cols="80" style="width: 80%">
  <?php echo $_POST[rte1]?$_POST[rte1]:$opis ; ?>  
    </textarea>
 <input type="submit" <?php echo $cmsniz[all1][8]?>>
  </form>
  </td></tr></table>
 </body>
</html>
