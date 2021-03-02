<?php 
include("Connections/conn.php");
$idd = @preg_replace('#[^0-9]#i', '', $_GET['id']);
$pro=mysqli_query($conn, "SELECT * FROM adrese_poslodavci WHERE id=".safe($idd)."");
$hr1=mysqli_fetch_array($pro); 
$grad=mysqli_query($conn, "SELECT * FROM gradovi WHERE id=$hr1[id_grada]");
$grad1=mysqli_fetch_array($grad);  
?>
<script type="text/javascript" src="<?php echo $patH?>/js/jquery-1.3.2.min.js"></script>
 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyD-pZh2t-lUWX-mIaqbzjLE6jnkKksgsqg"
      type="text/javascript"></script>
    <script type="text/javascript">

 function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        var center = new GLatLng(44.8170565, 20.458802);
        map.setCenter(center, 15);
        geocoder = new GClientGeocoder();
        var marker = new GMarker(center, {draggable: false});  
        map.addOverlay(marker);
    
map.openInfoWindow(map.getCenter(),
                   document.createTextNode("Hello, world"));
      //  document.getElementById("lat").innerHTML = center.lat().toFixed(5);
      //  document.getElementById("lng").innerHTML = center.lng().toFixed(5);

 

      }
    }

	   function showAddress(address) {
	   var map = new GMap2(document.getElementById("map"));
       map.addControl(new GSmallMapControl());
       map.addControl(new GMapTypeControl());
       if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
          
            if (!point) {
              alert(address + " not found");
            } else {
	//	  document.getElementById("lat").innerHTML = point.lat().toFixed(5);
	  // document.getElementById("lng").innerHTML = point.lng().toFixed(5);

		 map.clearOverlays()
			map.setCenter(point, 16);
   var marker = new GMarker(point, {draggable: false});  
		 map.addOverlay(marker);
map.openInfoWindow(map.getCenter(),
 
    document.createTextNode("<?php echo $hr1[naziv_preduzeca]?> - <?php echo $hr1[adresa]?>, <?php echo str_replace('Inostranstvo','',$grad1[grad])?>"));
 

            }
          }
        );
      }
    }
    </script>
  <?php 
  if($grad1[grad]=="Inostranstvo")
  {
  ?>
<body onload="load(); showAddress('<?php echo str_replace(" bb","",$hr1[adresa])?>')" onunload="GUnload()" >  
  <?php 
  }else{
  ?>
<body onload="load(); showAddress('<?php echo str_replace(" bb","",$hr1[adresa])?>, <?php echo $grad1[grad]?>')" onunload="GUnload()" >
<?php 
}
?>
<div align="center" id="map" style="width: 500px; height: 400px"></div>    
