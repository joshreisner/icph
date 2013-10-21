<?php
//maps page
$body_class = 'maps';
get_header();
?>
<script src="//maps.google.com/maps/api/js?key=AIzaSyADB0wyHm58AKLfOefVvZ13G-oZq3UftWY&amp;sensor=false"></script>
<script src="//maptilercdn.s3.amazonaws.com/klokantech.js"></script>
<script src="<?php bloginfo('template_directory');?>/js/infobox.js"></script>

<?php
foreach ($eras as $era) {
	?>
	<div class="mapwrapper <?php echo $era->post_name?>">
		<div class="map" id="map<?php echo $era->ID?>"></div>

		<?php if ($era->post_name == 'today') {?>
			<a id="toggle-1980" class="toggle"><img src="<?php bloginfo('template_directory');?>/img/map/toggle/1980.png"></a>
		<?php }?>

		<div class="zoom in" id="zoom-in<?php echo $era->ID?>"></div>
		<div class="zoom out" id="zoom-out<?php echo $era->ID?>"></div>

		<div class="pan">
			<div class="left" id="pan-left<?php echo $era->ID?>"></div>
			<div class="right" id="pan-right<?php echo $era->ID?>"></div>
			<div class="up" id="pan-up<?php echo $era->ID?>"></div>
			<div class="down" id="pan-down<?php echo $era->ID?>"></div>
		</div>

		<div id="description">
			<?php if ($era->post_name == 'today') {?>
				<h3>Concentration of Poor New Yorkers</h3>
				<dl>
					<dt class="high"><h3>High</h3></dt>
					<dd>High areas on the map denote large concentrations of poor persons in a given year.</dd>

					<dt class="low"><h3>Low</h3></dt>
					<dd>Low areas refer to locations where few poor persons are living.  In other words, areas where more affluent persons are present.</dd>
				</dl>
				
				<p>Note: Tests for global spatial autocorrelation using Moran's l were significant (p=.001).  All clusters
					using local indicators of spatial association were significant (p<.005).</p>
				<p>Source: Minnesota Population Center, National Historical Geographic Information System: Version 2.0
					Minneapolis, MN: University of Minnesota 2011</p>
			<?php } else {?>
			<a class="control close"><i class="icon-cancel-circled"></i></a>
			<a class="control expand"><i class="icon-plus-circled"></i></a>
			<h3><?php echo get_post_meta($era->ID, 'map_title', true)?></h3>
			<h3 class="minimized"><?php echo get_post_meta($era->ID, 'map_title_short', true)?></h3>
			<div class="content scroll-pane">
				<div><?php echo nl2br(get_post_meta($era->ID, 'map_description', true))?></div>
			</div>
			<?php }?>
		</div>
	</div>
	
	<script>
		var map<?php echo $era->ID?> = new google.maps.Map(document.getElementById('map<?php echo $era->ID?>'), {
			scrollwheel: false,
			streetViewControl: false,
			panControl: false,
			scrollwheel: false,
			zoomControl: false,
			mapTypeControl: false,
			zoom: 14,
			backgroundColor: '#d8d1c9',
			center: new google.maps.LatLng(40.725, -73.965)
		});
			
		google.maps.event.addDomListener(document.getElementById("zoom-in<?php echo $era->ID?>"), 'click', function() {
			map<?php echo $era->ID?>.setZoom(map<?php echo $era->ID?>.getZoom() + 1);
		});
		
		google.maps.event.addDomListener(document.getElementById("zoom-out<?php echo $era->ID?>"), 'click', function() {
			map<?php echo $era->ID?>.setZoom(map<?php echo $era->ID?>.getZoom() - 1);
		});
		
		google.maps.event.addDomListener(document.getElementById("pan-left<?php echo $era->ID?>"), 'click', function() {
			map<?php echo $era->ID?>.panBy(-100, 0);
		});
		
		google.maps.event.addDomListener(document.getElementById("pan-right<?php echo $era->ID?>"), 'click', function() {
			map<?php echo $era->ID?>.panBy(100, 0);
		});
		
		google.maps.event.addDomListener(document.getElementById("pan-up<?php echo $era->ID?>"), 'click', function() {
			map<?php echo $era->ID?>.panBy(0, -100);
		});
		
		google.maps.event.addDomListener(document.getElementById("pan-down<?php echo $era->ID?>"), 'click', function() {
			map<?php echo $era->ID?>.panBy(0, 100);
		});
		
		var mapBounds = new google.maps.LatLngBounds(
			new google.maps.LatLng(0.682437, -94.027215),
			new google.maps.LatLng(60.880905, -53.901394)
		);
		map<?php echo $era->ID?>.fitBounds(mapBounds);
		
		google.maps.event.addListenerOnce(map<?php echo $era->ID?>, 'bounds_changed', function() {
	    	this.setZoom(14);
	    	this.setCenter(new google.maps.LatLng(40.725, -73.965));
		});
		//setTimeout(function(){google.maps.event.removeListener(zoomChangeBoundsListener)}, 2000);

		var mapGetTile = function(x,y,z) { 
			return "/wp-content/themes/icph/img/eras/<?php echo $era->post_name?>/tiles/" + z + "/" + x + "/" + y + ".png";
		}
	
		var maptiler = new klokantech.MapTilerMapType(map<?php echo $era->ID?>, mapGetTile, mapBounds, 10, 15);

		
		infowindow = new InfoBox({alignBottom:true, closeBoxURL: ""});
		
		<?php
		$points = get_posts('post_type=map_point&status=published&numberposts=-1&meta_key=era&meta_value=' . $era->ID);
		foreach ($points as $point) {
			$title = str_replace("'", '&rsquo;', $point->post_title);
			$content = str_replace("'", '&rsquo;', $point->post_content);
			$content = str_replace(array("\r\n", "\r", "\n"), '<br>', $content); //extra linebreaking

			$latitude = get_post_meta($point->ID, 'geo_latitude', true);
			$longitude = get_post_meta($point->ID, 'geo_longitude', true);
	
			if ($related = get_related_links('post', $point->ID)) {
				$main_related_link = array_shift($related);
				$post = get_post($main_related_link['id']);
				$title = '<a href="#' . $post->post_name . '">' . $title . '</a>';
				
				//if there are more related links, append as UL
				if (count($related)) {
					$content .= '<div class="related"><strong>Related:</strong><ul>';
					foreach ($related as $secondary_related_link) {
						$post = get_post($secondary_related_link['id']);
						$content .= '<li><a href="#' . $post->post_name . '">' . $secondary_related_link['title'] . '</a></li>';
					}
					$content .= '</ul></div>';
				}
			}
			
			if (!empty($latitude) && !empty($longitude)) {
				?>
				var marker<?php echo $point->ID?> = new google.maps.Marker({
					position: new google.maps.LatLng(<?php echo $latitude?>, <?php echo $longitude?>),
					map: map<?php echo $era->ID?>,
					title: '<?php echo $title?>',
					icon: '/wp-content/themes/icph/img/eras/<?php echo $era->post_name?>/marker.png'
				});
				
				google.maps.event.addListener(marker<?php echo $point->ID?>, 'click', function(e) {
					var content = document.createElement("div");
					content.innerHTML = '<a class="control close"><i class="icon-cancel-circled"></i></a><div class="title"><?php echo $title?></div><div class="content"><?php echo $content?></div>';
	
					jQuery(content).find("a.close").click(function(){
						infowindow.close(map<?php echo $era->ID?>, marker<?php echo $point->ID?>);
					})
					
					infowindow.setContent(content);
					infowindow.open(map<?php echo $era->ID?>, marker<?php echo $point->ID?>);
	
					//jQuery("div.content").jScrollPane(); //works, but is invisible
				});
	
				<?php
			} else {
				echo PHP_EOL . '// ' . $point->post_title . ' ommitted because of empty coordinates' . PHP_EOL;
			}
		}?>
		
	</script>
<?php
}
?>

<!-- specially added map for 2000-->
	<div class="mapwrapper today-2000">
		<div class="map" id="map2000"></div>
		<a id="toggle-2000" class="toggle"><img src="http://povertyhistory.dev/wp-content/themes/icph/img/map/toggle/2000.png"></a>
		
		<div class="zoom in" id="zoom-in2000"></div>
		<div class="zoom out" id="zoom-out2000"></div>

		<div class="pan">
			<div class="left" id="pan-left2000"></div>
			<div class="right" id="pan-right2000"></div>
			<div class="up" id="pan-up2000"></div>
			<div class="down" id="pan-down2000"></div>
		</div>

		<div id="description">
			<h3>Concentration of Poor New Yorkers</h3>
			<dl>
				<dt class="high"><h3>High</h3></dt>
				<dd>High areas on the map denote large concentrations of poor persons in a given year.</dd>

				<dt class="low"><h3>Low</h3></dt>
				<dd>Low areas refer to locations where few poor persons are living.  In other words, areas where more affluent persons are present.</dd>
			</dl>
			
			<p>Note: Tests for global spatial autocorrelation using Moran's l were significant (p=.001).  All clusters
				using local indicators of spatial association were significant (p<.005).</p>
			<p>Source: Minnesota Population Center, National Historical Geographic Information System: Version 2.0
				Minneapolis, MN: University of Minnesota 2011</p>
		</div>
	</div>
	
	<script>
		var map2000 = new google.maps.Map(document.getElementById('map2000'), {
			scrollwheel: false,
			streetViewControl: false,
			panControl: false,
			scrollwheel: false,
			zoomControl: false,
			mapTypeControl: false,
			zoom: 14,
			backgroundColor: '#d8d1c9',
			center: new google.maps.LatLng(40.725, -73.965)
		});
			
		google.maps.event.addDomListener(document.getElementById("zoom-in2000"), 'click', function() {
			map2000.setZoom(map2000.getZoom() + 1);
		});
		
		google.maps.event.addDomListener(document.getElementById("zoom-out2000"), 'click', function() {
			map2000.setZoom(map2000.getZoom() - 1);
		});
		
		google.maps.event.addDomListener(document.getElementById("pan-left2000"), 'click', function() {
			map2000.panBy(-100, 0);
		});
		
		google.maps.event.addDomListener(document.getElementById("pan-right2000"), 'click', function() {
			map2000.panBy(100, 0);
		});
		
		google.maps.event.addDomListener(document.getElementById("pan-up2000"), 'click', function() {
			map2000.panBy(0, -100);
		});
		
		google.maps.event.addDomListener(document.getElementById("pan-down2000"), 'click', function() {
			map2000.panBy(0, 100);
		});
		
		var mapBounds = new google.maps.LatLngBounds(
			new google.maps.LatLng(0.682437, -94.027215),
			new google.maps.LatLng(60.880905, -53.901394)
		);
		map2000.fitBounds(mapBounds);
		
		google.maps.event.addListenerOnce(map2000, 'bounds_changed', function() {
	    	this.setZoom(14);
	    	this.setCenter(new google.maps.LatLng(40.725, -73.965));
		});
		//setTimeout(function(){google.maps.event.removeListener(zoomChangeBoundsListener)}, 2000);

		var mapGetTile = function(x,y,z) { 
			return "/wp-content/themes/icph/img/eras/today/tiles-2000/" + z + "/" + x + "/" + y + ".png";
		}
	
		var maptiler = new klokantech.MapTilerMapType(map2000, mapGetTile, mapBounds, 10, 15);

		
		infowindow = new InfoBox({alignBottom:true, closeBoxURL: ""});
		
				
	</script>
<!-- end specially added map for 2000 -->

<?php echo icph_slider();

get_footer();