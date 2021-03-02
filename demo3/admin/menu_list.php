 <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="ui-sortable/design.css"/>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
 
<script src="accord-menu/woco.accordion.min.js"></script>
		<link href="accord-menu/woco-accordion.css" rel="stylesheet">
		<style>.accordion{width:100%;}</style>
     <script>
function geti()
  {
  //alert($(".spacer").html())
  //x = new Array();
 var offset_p = $(".zapaste").offset(); 
  var ar="";
$('.spacer  li').each(function(i)
{
var offset = $(this).offset();
diff=Math.round(offset.left)-Math.round(offset_p.left);
v1=$(this).attr('id');
if(diff==0)
ar +="###"+v1;
$(this).children('ul').children('li').each(function(i)
{
var pp=$(this).parent("ul").parent("li").attr('id');
var offset = $(this).offset();
diff=Math.round(offset.left)-Math.round(offset_p.left);
if(diff==70) 
ar +="###"+pp+"-"+$(this).attr('id');
//alert(pp+"-"+$(this).attr('id'));
$(this).children('ul').children('li').each(function(i)
{
var pp1=$(this).parent("ul").parent("li").attr('id');

var offset = $(this).offset();
diff=Math.round(offset.left)-Math.round(offset_p.left);

if(diff==140) 
ar +="###"+pp+"-"+pp1+"-"+$(this).attr('id');
//alert(pp+"-"+pp1+"-"+$(this).attr('id'));

$(this).children('ul').children('li').each(function(i)
{

var pp2=$(this).parent("ul").parent("li").attr('id');
var offset = $(this).offset();
diff=Math.round(offset.left)-Math.round(offset_p.left);

if(diff==210) 
ar +="###"+pp+"-"+pp1+"-"+pp2+"-"+$(this).attr('id');
//alert(pp+"-"+pp1+"-"+pp2+"-"+$(this).attr('id'));
});
});
});
});

$.ajax({
type: "POST",
//dataType: "json",
url: "<?php echo $patHA?>/save_menu.php?id=<?php echo $_GET['id_kat']?>",
data: {ara:ar},
cache: false,
success: function(datas){
$('#rezu').html(datas);
}
});
  }
function kopi(i)
{
var ovo=$(".copy"+i).html();
$(".zapaste").html(ovo);
}
function rem(i)
{
$(".zapaste").html("");
}
  </script>  
<br class='clear' />
<br />
<?php 
$ska=mysqli_query($conn, "SELECT * FROM categories_group WHERE id=$_GET[id_kat]");
$ska1=mysqli_fetch_assoc($ska);
?>
<div class='naslov_smestaj'><h1>UREDJIVANJE STAVKE MENIJA - <span style='color:#444;'><?php echo $ska1["name"]?></span></h1></div><br />
<br />
<script>
 function gog(id)
{
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id_kat="+id
}
</script>
<b>Izaberi ostale menije za izmenu</b>
<select name="" onchange="gog(this.value)" class='selecte'>
<?php 
$mo=mysqli_query($conn, "SELECT * FROM categories_group WHERE tip=1 ORDER BY name ASC");
while($mo1=mysqli_fetch_assoc($mo))
{
if($_GET['id_kat']==$mo1['id']) $sss="selected"; else $sss="";
echo "<option value='$mo1[id]' $sss>$mo1[name]</option>";
}
?>
</select>   
<br /><br />
<table style='width:100%;'>
 <tr valign="top">
 <td width="50%">
  <h3 class='title' id='title0'></h3>
			<h2>Stranice sajta</h2>
      <div>
      <a href='javascript:;' onclick="kopi(0)" style='position:relative;top:-4px;left:10px;'>Copy and paste all</a>
  <ul class='space first-space copy0' id='space1' style='margin-top:-40px;'>
<?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 ORDER BY p.position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
  if($tz1['ide']==$_GET['id']) $sele="selected"; else $sele="";
  //if($tz1['ide']==1 or $tz1['ide']==31 or $tz1['ide']==49) $no=" d-none"; else $no="";
?>
    <li class='route<?php echo $no?>' id="<?php echo $tz1['ide']?>">
      <h3 class='title' id='title1'><?php echo $tz1["naziv"]?> <?php if($admi1['master']==1) echo $tz1['ide']; else echo "";?></h3>
      <span class='ui-icon ui-icon-arrow-4-diag'></span>
      <ul class='space' id='space2'>
      <?php
$hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND p.id_parent=$tz1[ide] ORDER BY p.position ASC");
if(mysqli_num_rows($hz)>0)
{
   while($hz1=mysqli_fetch_array($hz))
     {
?>
       <li class='route' id="<?php echo $hz1['ide']?>">
          <h3 class='title' id='title3'><?php echo $hz1["naziv"]?> <?php echo $hz1['ide']?></h3>
          <span class='ui-icon ui-icon-arrow-4-diag'></span>
          <ul class='space' id='space3'>
           <?php 
$pz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND p.id_parent=$hz1[ide] ORDER BY p.position ASC");
$rez=mysqli_num_rows($pz);
if($rez>0)
{
   while($pz1=mysqli_fetch_array($pz))
     {
      ?>
       <li class='route' id="<?php echo $pz1['ide']?>">
          <h3 class='title' id='title3'><?php echo $pz1["naziv"]?> <?php echo $pz1['ide']?></h3>
          <span class='ui-icon ui-icon-arrow-4-diag'></span>
          <ul class='space' id='space4'>
          </ul>
        </li>
     <?php 
     }
     }
     ?> 
          </ul>
        </li>
     <?php 
     }
     }
     ?> 
      </ul>
    </li>                      
<?php 
}
?>
</ul>
</div>  
      
  <?php 
  $i=1;
  $ka=mysqli_query($conn, "SELECT * FROM categories_group WHERE tip='0' AND akt='1'");
  while($ka1=mysqli_fetch_assoc($ka))
  {    
  ?>
	<h1><?php echo $ka1['name']?></h1>
  
      <div>
      <a href='javascript:;' onclick="kopi('<?php echo $i?>')" style='position:relative;top:-4px;left:10px;'>Copy and paste all</a>
  <ul class='space first-space copy<?php echo $i?>' id='space1'  style='margin-top:-40px;'>
    

                      <?php 
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND p.id_cat=$ka1[id] ORDER BY p.position ASC");
 
   while($tz1=mysqli_fetch_array($tz))
     {
      
  if($tz1[id]==$_GET['id']) $sele="selected"; else $sele="";
                      ?>
                      
    <li class='route' id="<?php echo $tz1['ide']?>">
      <h3 class='title' id='title1'><?php echo $tz1["naziv"]?> <?php echo $tz1['ide']?></h3>
      <span class='ui-icon ui-icon-arrow-4-diag'></span>
      <ul class='space' id='space2'>
      <?php 
$hz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND p.id_parent=$tz1[ide] ORDER BY p.position ASC");       

if(mysqli_num_rows($hz)>0)
{
   while($hz1=mysqli_fetch_array($hz))
     {
      ?>
       <li class='route' id="<?php echo $hz1['ide']?>">
          <h3 class='title' id='title3'><?php echo $hz1["naziv"]?> <?php echo $hz1['ide']?></h3>
          <span class='ui-icon ui-icon-arrow-4-diag'></span>
          <ul class='space' id='space3'>
          
           <?php 
$pz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  p.nivo=1 AND p.id_parent=$hz1[ide] ORDER BY p.position ASC");
if(mysqli_num_rows($pz)>0)
{
   while($pz1=mysqli_fetch_array($pz))
     {
      ?>
       <li class='route' id="<?php echo $pz1['ide']?>">
          <h3 class='title' id='title3'><?php echo $pz1["naziv"]?> <?php echo $pz1['ide']?></h3>
          <span class='ui-icon ui-icon-arrow-4-diag'></span>
          <ul class='space' id='space4'>
          </ul>
        </li>
     <?php 
     }
     }
     ?>
          </ul>
        </li>
     <?php 
     }
     }
     ?> 
      </ul>
    </li>                      
<?php 
}
?>
  </ul>
</div>  
      <?php 
      $i++;
      }
      ?>
 
  </td>
  <td style='width:50%;'>

<a href="javascript:;" style='position:relative;left:10px;' onclick="geti()" class='submit_dugmici_blue'>SAČUVAJ STAVKE MENIJA</a>

<div id="rezu" style="margin-top:10px;color:#f00;"></div>
  <h3 class='title' id='title0'></h3>
  <a href='javascript:;' onclick="rem()" style='position:relative;top:10px;left:10px;'>Remove all</a>
  <ul class='space first-space spacer zapaste' id='space1' style='margin-top:-10px;'>
 
                      <?php 
                
$tz=mysqli_query($conn, "SELECT * FROM menus_list  WHERE nivo=1 AND id_menu=$_GET[id_kat] ORDER BY position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
$im=mysqli_query($conn, "SELECT * FROM pagel WHERE id_page=$tz1[id] AND lang='$firstlang'");
$im1=mysqli_fetch_assoc($im);        
                      ?>
                      
    <li class='route' id="<?php echo $tz1['id']?>">
      <h3 class='title' id='title1'><?php echo $im1["naziv"]?> <?php if($admi1['master']==1) echo $tz1['id']; else echo "";?></h3>
      <span class='ui-icon ui-icon-arrow-4-diag'></span>
      <ul class='space' id='space2'>
      <?php 
$hz=mysqli_query($conn, "SELECT * FROM menus_list  WHERE id_parent=$tz1[id]  AND id_menu=$_GET[id_kat] ORDER BY position ASC");
if(mysqli_num_rows($hz)>0)
{
   while($hz1=mysqli_fetch_array($hz))
     {
$ima=mysqli_query($conn, "SELECT * FROM pagel WHERE id_page=$hz1[id] AND lang='$firstlang'");
$ima1=mysqli_fetch_assoc($ima);     
      ?>
       <li class='route' id="<?php echo $hz1['id']?>">
          <h3 class='title' id='title3'><?php echo $ima1["naziv"]?> <?php if($admi1['master']==1) echo $hz1['id']; else echo "";?></h3>
          <span class='ui-icon ui-icon-arrow-4-diag'></span>
          <ul class='space' id='space3'>
          
           <?php 
$pz=mysqli_query($conn, "SELECT * FROM menus_list  WHERE id_parent=$hz1[id]  AND id_menu=$_GET[id_kat] ORDER BY position ASC");
if(mysqli_num_rows($pz)>0)
{
   while($pz1=mysqli_fetch_array($pz))
     {
$imaz=mysqli_query($conn, "SELECT * FROM pagel WHERE id=$pz1[id] AND lang='$firstlang'");
$imaz1=mysqli_fetch_assoc($imaz);  
      ?>
       <li class='route' id="<?php echo $pz1['id']?>">
          <h3 class='title' id='title3'><?php echo $imaz1["naziv"]?> <?php if($admi1['master']==1) echo $pz1['id']; else echo "";?></h3>
          <span class='ui-icon ui-icon-arrow-4-diag'></span>
          <ul class='space' id='space4'>
          
           <?php 
$paz=mysqli_query($conn, "SELECT * FROM menus_list  WHERE id_parent=$pz1[id]  AND id_menu=$_GET[id_kat] ORDER BY position ASC");
if(mysqli_num_rows($paz)>0)
{
   while($paz1=mysqli_fetch_array($paz))
     {
$imas=mysqli_query($conn, "SELECT * FROM page WHERE id=$paz1[id]");
$imas1=mysqli_fetch_assoc($imas);  
      ?>
       <li class='route' id="<?php echo $paz1['id']?>">
          <h3 class='title' id='title4'><?php echo $imas1["naziv$firstlang"]?> <?php echo $paz1['id']?></h3>
          <span class='ui-icon ui-icon-arrow-4-diag'></span>
          <ul class='space' id='space5'>

          </ul>
        </li>
     <?php 
     }
     }
     ?> 
          </ul>
        </li>
     <?php 
     }
     }
     ?>  
          </ul>
        </li>
     <?php 
     }
     }
     ?> 
      </ul>
    </li>                      
<?php 
}
?>
  </ul>
  <br /><br />
  <a href="javascript:;" style='position:relative;left:10px;' onclick="geti()" class='submit_dugmici_blue'>SAČUVAJ STAVKE MENIJA</a>
</td>
</tr>
</table>

<div id="aaa"></div>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script> 
<script type='text/javascript' src="ui-sortable/responder.js"></script>              

 	<script>
			$(".accordion").accordion();
		</script>