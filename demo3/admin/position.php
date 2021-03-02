 <?php 
 
include("../Connections/conn_admin.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Total Management
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9 " />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="<?php echo $patHA?>/css/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
      <!--
      .style1 {font-size: 24px}
      -->
    </style>  
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>    
 
  
<script type="text/javascript" src="<?php echo $patHA?>/js/jquery-ui-1.8.23.custom.min.js"></script>
 <script>
 
  
    $(document).ready(function(){
    $("#sorting .ul").sortable({
      stop: function(){
        qString = $(this).sortable("serialize");
   // alert(qString)
    
       // $('#msg').fadeIn("slow");
        //$('#msg').html("Updating...");
        $.ajax({
          type: "POST",
   
      url: "<?php echo $patHA?>/save_position.php",
          data: qString,
          cache: false,
          beforeSend: function(html){
          
       $("#sorting .ul").css("opacity", "0.6");
      // $("#sorting .ul").append("load...");
          },
          success: function(html){
         
          $("#sorting .ul").css("opacity", "1.0")
          $("#sli").remove();
        $('#msgar').html(html);
          }
        });
      }
    });
        //$("#sorting .ul").disableSelection();
  });   
  
   
</script>
 <style>

 #sorting ul
 {
  padding:0px;
 margin:0px;
 }
 #sorting
 {
 width:100%;
 width:500px;

 }
  #sorting li{
 list-style:none;  
    float:left;
    margin-right:10px;
    cursor:move;
    position:relative;
  }
 
  
</style> 


 

 
</script>
 
  </head>
<body style='font-family:arial;font-size:14px;'>
<div id="msgar"></div>
<div style='float:left;width:100%;' >
 
           
              <h3>Pozicije objekata na naslovnoj strani</h3>
    <?php 
    
 
echo "<div  id='sorting' ><ul  class='ul' style='float:left;'><li id='new_image'></li><li id='sortid_0'></li>";
 
$str=mysqli_query($conn, "SELECT * FROM slike_paintb WHERE idupisa=0 AND tip=2 ORDER BY id DESC");
while($st=mysqli_fetch_array($str))
{
echo "<li style='width:100%;float:left;' id='sortid_$st[id]'>";
echo "<table class='users' cellspacing='2' style='width:100%;'>";
echo "<tr  style='background:#f1f1f1;'><td width='20'>$st[pozicija]</td>";
echo "<td style='width:550px;font-weight:bold;'>$st[naslov]</td>";
 
 
echo "</tr>";
echo "</table>";
echo "</li>";
}
 
?>                        
</div>
 
 
</body>
</html>
