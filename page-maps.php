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
		//new google.maps.LatLng(20.682437, -74.027215),
		//new google.maps.LatLng(40.880905, -73.901394)
		new google.maps.LatLng(0.682437, -94.027215),
		new google.maps.LatLng(60.880905, -53.901394)
	);
	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
	map.fitBounds(mapBounds);

	//workaround to fix zoom
	var center_latitude = 40.725;
	var center_longitude = -73.965;
	
	zoomChangeBoundsListener = google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
    	this.setZoom(14);
    	//this.setOptions({disableDoubleClickZoom: true});
    	this.setCenter(new google.maps.LatLng(center_latitude, center_longitude));
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
	zoomIn.style.opacity = .5;
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
	zoomOut.style.opacity = .5;
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
	
	var mapMinZoom = 10;
	var mapMaxZoom = 15;
	var tiles = {
		10 : {
			301 : { min: 384, max: 385 }
		},
		11 : {
			602 : { min: 769, max: 770 },
			603 : { min: 768, max: 770 }
		},
		12 : {
			1205 : { min: 1538, max: 1540 },
			1206 : { min: 1537, max: 1540 },
			1207 : { min: 1537, max: 1540 }
		},
		13 : {
			2411 : { min: 3077, max: 3080 },
			2412 : { min: 3074, max: 3080 },
			2413 : { min: 3074, max: 3080 },
			2414 : { min: 3075, max: 3080 }
		},
		14 : {
			4822 : { min: 6156, max: 6161 },
			4823 : { min: 6155, max: 6161 },
			4824 : { min: 6153, max: 6161 },
			4825 : { min: 6149, max: 6161 },
			4826 : { min: 6149, max: 6161 },
			4827 : { min: 6149, max: 6161 },
			4828 : { min: 6150, max: 6161 }
		},
		15 : {
			9645 : { min: 12313, max: 12323 },
			9646 : { min: 12311, max: 12323 },
			9647 : { min: 12311, max: 12323 },
			9648 : { min: 12306, max: 12323 },
			9649 : { min: 12306, max: 12323 },
			9650 : { min: 12299, max: 12323 },
			9651 : { min: 12299, max: 12323 },
			9652 : { min: 12299, max: 12323 },
			9653 : { min: 12299, max: 12323 },
			9654 : { min: 12299, max: 12323 },
			9655 : { min: 12299, max: 12323 },
			9656 : { min: 12300, max: 12323 },
			9657 : { min: 12300, max: 12323 }
		}
	}
	
	var mapGetTile = function(x,y,z) { 
		if ((z in tiles) && (x in tiles[z]) && (y >= tiles[z][x].min) && (y <= tiles[z][x].max)) {
			return "/wp-content/themes/icph/img/eras/progressive/tiles/" + z + "/" + x + "/" + y + ".png";
		} else {
			return "/wp-content/themes/icph/img/blank_tile.jpg";
		}
	}

	var maptiler = new klokantech.MapTilerMapType(map, mapGetTile, mapBounds, mapMinZoom, mapMaxZoom);
	var opacitycontrol = new klokantech.OpacityControl(map, maptiler);

	infowindow = new InfoBox({closeBoxURL:"",alignBottom:true});
	
	infowindow_static = new InfoBox({closeBoxURL:"", position: new google.maps.LatLng(center_latitude + .0217, center_longitude + .03)});
	infowindow_static.setContent('<div class="title">Settlement Houses in New York City: 1886 to 1929</div><div class="content"><p>Over the late nineteenth and early twentieth centuries many settlement houses opened in New York City. These settlements provided sites for the middle-class to live and provide assistance to the poor. This map shows the original location of these settlements, the poorest neighborhoods in the city at the time. Intended to be directed by the needs of the local community, settlements became important service providers in New York’s poor communities. Settlement workers also became leading advocates for social reforms using data collected in their work to support public playgrounds, housing reform, restrictions on child labor, and pensions for widowed mothers. Today many of these organizations continue to be important social service providers.</p></div>');
	infowindow_static.open(map);


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
				title: '<?php echo $title?>',
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