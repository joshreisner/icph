<?php
//maps page
$body_class = 'maps';
get_header();
?>
    <script src="//maps.google.com/maps/api/js?sensor=false"></script>
    <script src="//maptilercdn.s3.amazonaws.com/klokantech.js"></script>

    <style>
      html, body, #map { width:100%; height:100%; margin:0; padding:0; }
    </style>

    <div id="map"></div>

	<script>
		var map;
		var mapMinZoom = 10;
		var mapMaxZoom = 15;
		var mapBounds = new google.maps.LatLngBounds(
			new google.maps.LatLng(40.682437, -74.027215),
			new google.maps.LatLng(40.880905, -73.901394)
		);
		var mapGetTile = function(x,y,z) { 
			return "/wp-content/themes/icph/img/eras/progressive/tiles/" + z + "/" + x + "/" + y + ".png";
		}

		var opts = {
			streetViewControl: false,
			center: new google.maps.LatLng(0,0),
			zoom: 14 //10
		};
		map = new google.maps.Map(document.getElementById('map'), opts);
		map.setMapTypeId(google.maps.MapTypeId.HYBRID);
		map.fitBounds(mapBounds);
		var maptiler = new klokantech.MapTilerMapType(map, mapGetTile, mapBounds, mapMinZoom, mapMaxZoom);
		var opacitycontrol = new klokantech.OpacityControl(map, maptiler);
	</script>

<?php
get_footer();