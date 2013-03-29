<?php
//maps page
$body_class = 'maps';
get_header();
?>
<script src="//maps.google.com/maps/api/js?key=AIzaSyADB0wyHm58AKLfOefVvZ13G-oZq3UftWY&sensor=false"></script>
<script src="//maptilercdn.s3.amazonaws.com/klokantech.js"></script>
<script src="/wp-content/themes/icph/js/infobox.js"></script>

<style>
    html, body, #map { width:100%; height:100%; margin:0; padding:0; }
</style>

<div id="mapwrapper">
	<div id="map"></div>
</div>

<script>
	var map = new google.maps.Map(document.getElementById('map'), {
		streetViewControl: false,
		panControl: false,
		scrollwheel: false,
		zoomControl: false
	});
	var mapBounds = new google.maps.LatLngBounds(
		new google.maps.LatLng(40.682437, -74.027215),
		new google.maps.LatLng(40.880905, -73.901394)
	);
	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
	map.fitBounds(mapBounds);

	//workaround to fix zoom
	zoomChangeBoundsListener = google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
    	this.setZoom(14);
    	//this.setOptions({disableDoubleClickZoom: true});
    	this.setCenter(new google.maps.LatLng(40.725, -73.965));
	});
	setTimeout(function(){google.maps.event.removeListener(zoomChangeBoundsListener)}, 2000);

	var controlDiv = document.createElement('div');
	controlDiv.style.padding = '70px 20px';

	var zoomIn = document.createElement('div');
	zoomIn.innerHTML = '+';
	zoomIn.style.color = 'white';
	zoomIn.style.textAlign = 'center';
	zoomIn.style.lineHeight = '50px';
	zoomIn.style.fontSize = '20px';
	zoomIn.style.backgroundColor = 'black';
	zoomIn.style.width = '50px';
	zoomIn.style.height = '50px';
	zoomIn.style.cursor = 'pointer';
	controlDiv.appendChild(zoomIn);

	var zoomOut = document.createElement('div');
	zoomOut.innerHTML = '-';
	zoomOut.style.color = 'white';
	zoomOut.style.textAlign = 'center';
	zoomOut.style.lineHeight = '50px';
	zoomOut.style.fontSize = '20px';
	zoomOut.style.backgroundColor = 'black';
	zoomOut.style.width = '50px';
	zoomOut.style.height = '50px';
	zoomOut.style.marginTop = '10px';
	zoomOut.style.cursor = 'pointer';
	controlDiv.appendChild(zoomOut);

	map.controls[google.maps.ControlPosition.TOP_LEFT].push(controlDiv);

	google.maps.event.addDomListener(zoomIn, 'click', function() {
		var zoom = map.getZoom();
		map.setZoom(zoom + 1);
	});
	
	google.maps.event.addDomListener(zoomOut, 'click', function() {
		var zoom = map.getZoom();
		map.setZoom(zoom - 1);
	});
	
	var mapMinZoom = 12;
	var mapMaxZoom = 15;
	var mapGetTile = function(x,y,z) { 
		return "/wp-content/themes/icph/img/eras/progressive/tiles/" + z + "/" + x + "/" + y + ".png";
	}

	var maptiler = new klokantech.MapTilerMapType(map, mapGetTile, mapBounds, mapMinZoom, mapMaxZoom);
	var opacitycontrol = new klokantech.OpacityControl(map, maptiler);

	infowindow = new InfoBox({closeBoxURL:"",alignBottom:true});

	<?php
	$points = get_posts('post_type=map_point&status=published&numberposts=-1');
	$count = count($points);
	for ($i = 0; $i < $count; $i++) {
		$title = str_replace("'", '', $points[$i]->post_title);
		$content = str_replace("'", '', $points[$i]->post_content);
		$latitude = get_post_meta($points[$i]->ID, 'geo_latitude', true);
		$longitude = get_post_meta($points[$i]->ID, 'geo_longitude', true);
		
		$related = get_related_links('post', $points[$i]->ID);
		if (count($related)) {
			//unshift $related
			$post = get_post($related[0]['id']);
			$title = '<a href="#' . $post->post_name . '">' . $title . '</a>';
		}
		
		if (!empty($latitude) && !empty($longitude)) {
			?>
			var marker<?php echo $i?> = new google.maps.Marker({
				position: new google.maps.LatLng(<?php echo $latitude?>, <?php echo $longitude?>),
				map: map,
				icon: '/wp-content/themes/icph/img/eras/progressive/marker.png'
			});
			
			google.maps.event.addListener(marker<?php echo $i?>, 'click', function(e) {
				infowindow.setContent('<div class="title"><?php echo $title?></div><div class="content"><?php echo $content?></div>');
				infowindow.open(map, marker<?php echo $i?>);
				jQuery(".content").jScrollPane();
			});
			<?php
		} else {
			
			echo '
			// ' . $title . ' ommitted because of empty coordinates
			';

		}
	}?>
	
</script>

<?php
get_footer();