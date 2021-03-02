<?php 
include("../Connections/conn_admin.php");
 
if($hide_cats==1)
{
$nizi=$_POST['id'];
 
$fsi=mysqli_query($conn, "SELECT * FROM  categories_group WHERE akt=1 AND tip=0 AND id IN (SELECT id_kat FROM pages_kat WHERE id_page=$nizi) ORDER BY name ASC");
while($fsi1=mysqli_fetch_assoc($fsi))
{  
$tz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  nivo=1  AND id_cat=$fsi1[id] ORDER BY p.position ASC");
if(mysqli_num_rows($tz)>0)
{        
?> 
<span>Dodeli upis - <?php echo $fsi1['name']?></span>
<?php 
if($fsi1['multi']==1) 
{
$imulti_class=" selectG1";
$imulti='multiple="multiple"';
$prazno="";
}else
{
$imulti_class="";
$imulti='';
$prazno="<option value=''>---</option>";
}
?> 
<select name="kat[]" class='selecte<?php echo $imulti_class?>' <?php echo $imulti?>>
                  
                      <?php 
 echo $prazno;
$tz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  nivo=1  AND id_cat=$fsi1[id] ORDER BY p.position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
     
$hz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$tz1[id_page]   ORDER BY p.position ASC");                       

if(mysqli_num_rows($hz)>0) $dis1="disabled"; else $dis1="";     
                      ?>
<option  value="<?php echo $tz1[id_page]?>" <?php echo $dis1?>><?php echo $tz1["naziv"]?></option>
						         	 <?php 
  

   while($hz1=mysqli_fetch_array($hz))
     {

$rz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$hz1[id_page]  ORDER BY p.position ASC");
                               
if(mysqli_num_rows($rz)>0) $dis2="disabled"; else $dis2="";
                      ?>
<option value="<?php echo $hz1[id_page]?>" <?php echo $dis2?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option>

<?php 
  

   while($pz1=mysqli_fetch_array($pz))
     {
                      ?>
<option value="<?php echo $pz1[id_page]?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pz1["naziv"]?></option>
						         	 <?php 
                      }

						          
                      }
                      }
                        ?>
</select>             
 
 <br />
  <br />
  <?php 
  }
  }
}  
?>