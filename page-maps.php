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
    div.goog-slider-horizontal { display: none; }
</style>

<div id="mapwrapper">
	<div id="map"></div>
</div>

<script>
	var map = new google.maps.Map(document.getElementById('map'), {
		streetViewControl: false,
		panControl: false,
		scrollwheel: false,
		zoomControl: false,
		mapTypeControl: false,
		opacitycontrol: false
	});
	var mapBounds = new google.maps.LatLngBounds(
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
	zoomIn.innerHTML = '<i class="icon-plus-circled"></i>';
	zoomIn.style.color = 'white';
	zoomIn.style.textAlign = 'center';
	zoomIn.style.lineHeight = '30px';
	zoomIn.style.fontSize = '20px';
	zoomIn.style.backgroundColor = 'black';
	zoomIn.style.opacity = .5;
	zoomIn.style.width = '30px';
	zoomIn.style.height = '30px';
	zoomIn.style.cursor = 'pointer';
	controlDiv.appendChild(zoomIn);

	var zoomOut = document.createElement('div');
	zoomOut.innerHTML = '<i class="icon-minus-circled"></i>';
	zoomOut.style.color = 'white';
	zoomOut.style.textAlign = 'center';
	zoomOut.style.lineHeight = '30px';
	zoomOut.style.fontSize = '20px';
	zoomOut.style.backgroundColor = 'black';
	zoomOut.style.opacity = .5;
	zoomOut.style.width = '30px';
	zoomOut.style.height = '30px';
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
	
	//tile definitions.  it used to be that the minima and maxima were all different for each level of zoom
	//now it's all the same, but i'm not sure if i should change the way the algorithm works
	var tiles = {
		10 : {
			301 : { min: 384, max: 385 }
		},
		11 : {
			602 : { min: 768, max: 770 },
			603 : { min: 768, max: 770 }
		},
		12 : {
			1205 : { min: 1537, max: 1540 },
			1206 : { min: 1537, max: 1540 },
			1207 : { min: 1537, max: 1540 }
		},
		13 : {
			2410 : { min: 3074, max: 3081 },
			2411 : { min: 3074, max: 3081 },
			2412 : { min: 3074, max: 3081 },
			2413 : { min: 3074, max: 3081 },
			2414 : { min: 3074, max: 3081 }
		},
		14 : {
			4821 : { min: 6149, max: 6162 },
			4822 : { min: 6149, max: 6162 },
			4823 : { min: 6149, max: 6162 },
			4824 : { min: 6149, max: 6162 },
			4825 : { min: 6149, max: 6162 },
			4826 : { min: 6149, max: 6162 },
			4827 : { min: 6149, max: 6162 },
			4828 : { min: 6149, max: 6162 }
		},
		15 : {
			9643 : { min: 12299, max: 12324 },
			9644 : { min: 12299, max: 12324 },
			9645 : { min: 12299, max: 12324 },
			9646 : { min: 12299, max: 12324 },
			9647 : { min: 12299, max: 12324 },
			9648 : { min: 12299, max: 12324 },
			9649 : { min: 12299, max: 12324 },
			9650 : { min: 12299, max: 12324 },
			9651 : { min: 12299, max: 12324 },
			9652 : { min: 12299, max: 12324 },
			9653 : { min: 12299, max: 12324 },
			9654 : { min: 12299, max: 12324 },
			9655 : { min: 12299, max: 12324 },
			9656 : { min: 12299, max: 12324 },
			9657 : { min: 12299, max: 12324 }
		}
	}
	
	var mapGetTile = function(x,y,z) { 
		//if ((z in tiles) && (x in tiles[z]) && (y >= tiles[z][x].min) && (y <= tiles[z][x].max)) {
			return "/wp-content/themes/icph/img/eras/progressive/tiles/" + z + "/" + x + "/" + y + ".png";
		//} else {
		//	return "/wp-content/themes/icph/img/blank_tile.jpg";
		//}
	}

	var maptiler = new klokantech.MapTilerMapType(map, mapGetTile, mapBounds, mapMinZoom, mapMaxZoom);
	var opacitycontrol = new klokantech.OpacityControl(map, maptiler);

	infowindow = new InfoBox({alignBottom:true, closeBoxURL: ""});
	
	//doesn't work
	//google.maps.event.addListener(infowindow, 'opened', function(){
	//	jQuery('div.content', this.div_).jScrollPane({autoReinitialise: true});
	//});

	<?php
	$points = get_posts('post_type=map_point&status=published&numberposts=-1');
	$count = count($points);
	for ($i = 0; $i < $count; $i++) {
		$title = str_replace("'", '', $points[$i]->post_title);
		$content = str_replace("'", '', nl2br($points[$i]->post_content));
		$content = str_replace("\n", '', $content);
		$content = str_replace("\r", '', $content);
		$latitude = get_post_meta($points[$i]->ID, 'geo_latitude', true);
		$longitude = get_post_meta($points[$i]->ID, 'geo_longitude', true);
		
		$related = get_related_links('post', $points[$i]->ID);
		if (count($related)) {
			$main_related_link = array_shift($related);
			$post = get_post($main_related_link['id']);
			$title = '<a href="#' . $post->post_name . '">' . $title . '</a>';
			
			//if there are more related links, append as UL
			if (count($related)) {
				$content .= '<br><br>Related:<ul>';
				foreach ($related as $secondary_related_link) {
					$post = get_post($secondary_related_link['id']);
					$content .= '<li><a href="#' . $post->post_name . '">' . $secondary_related_link['title'] . '</a></li>';
				}
				$content .= '</ul>';
			}
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
				var content = document.createElement("div");
				content.innerHTML = '<a class="close"><i class="icon-cancel-circled"></i></a><div class="title"><?php echo $title?></div><div class="content"><?php echo $content?></div>';

				$(content).find("a.close").click(function(){
					infowindow.close(map, marker<?php echo $i?>);
				})
				
				//$(content).find("div.content").jScrollPane(); //works, but is invisible

				infowindow.setContent(content);
				infowindow.open(map, marker<?php echo $i?>);
			});
			<?php
		} else {
			
			echo '
			// ' . $title . ' ommitted because of empty coordinates
			';

		}
	}?>
	
</script>

<div id="description">
	<a class="close"><i class="icon-cancel-circled"></i></a>
	<h3>Settlement Houses in New York City: 1886 to 1929</h3>
	<h3 class="minimized">Settlement Houses</h3>
	<div class="content scroll-pane">
		<p>Over the late nineteenth and early twentieth centuries many settlement houses opened in New York City. These settlements provided sites for the middle-class to live and provide assistance to the poor. This map shows the original location of these settlements, the poorest neighborhoods in the city at the time. Intended to be directed by the needs of the local community, settlements became important service providers in New York’s poor communities. Settlement workers also became leading advocates for social reforms using data collected in their work to support public playgrounds, housing reform, restrictions on child labor, and pensions for widowed mothers. Today many of these organizations continue to be important social service providers.</p>
	</div>
</div>

<?php
get_footer();