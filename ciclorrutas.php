<?php 
require_once 'funciones.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Ciclorrutas</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }

    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
    
function initialize() {
  var mapOptions = {
    zoom: 12,
    center: new google.maps.LatLng(4.65385,-74.058409),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);     

  <?php 
  $ciclorrutas=darCiclorrutas();
  $n=0;
  foreach($ciclorrutas as $ciclorruta){ 

	$n++;

	echo"
	var flightPlanCoordinates$n = [";
	$lospuntos=array();
	$puntos=explode(';',$ciclorruta["ruta"]);
	foreach ($puntos as $punto){
		if(!empty($punto)){
			$coord=explode(',',$punto);
			$lospuntos[]="new google.maps.LatLng(".$coord[1].", ".$coord[0].")";
		}
	}
	
	echo implode(',',$lospuntos);
	
	echo"];
	
	var flightPath$n = new google.maps.Polyline({
		path: flightPlanCoordinates$n,
		strokeColor: '#FF0000',
		strokeOpacity: 1.0,
		strokeWeight: 5,
		map:map
	});
    ";

}
?>


                           

  
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

<?php

?>