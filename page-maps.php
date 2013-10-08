<?php
//maps page
$body_class = 'maps';
get_header();
?>
<script src="//maps.google.com/maps/api/js?key=AIzaSyADB0wyHm58AKLfOefVvZ13G-oZq3UftWY&sensor=false"></script>
<script src="//maptilercdn.s3.amazonaws.com/klokantech.js"></script>
<script src="/wp-content/themes/icph/js/infobox.js"></script>

<?php
foreach ($eras as $era) {
	?>
	<div class="mapwrapper <?php echo $era->post_name?>">
		<div class="map" id="map<?php echo $era->ID?>"></div>
		<div class="zoom in" id="zoom-in<?php echo $era->ID?>"></div>
		<div class="zoom out" id="zoom-out<?php echo $era->ID?>"></div>

		<div class="pan">
			<div class="left" id="pan-left<?php echo $era->ID?>"></div>
			<div class="right" id="pan-right<?php echo $era->ID?>"></div>
			<div class="up" id="pan-up<?php echo $era->ID?>"></div>
			<div class="down" id="pan-down<?php echo $era->ID?>"></div>
		</div>

		<div id="description">
			<a class="control close"><i class="icon-cancel-circled"></i></a>
			<a class="control expand"><i class="icon-plus-circled"></i></a>
			<h3><?php echo get_post_meta($era->ID, 'map_title', true)?></h3>
			<h3 class="minimized"><?php echo get_post_meta($era->ID, 'map_title_short', true)?></h3>
			<div class="content scroll-pane">
				<div><?php echo nl2br(get_post_meta($era->ID, 'map_description', true))?></div>
			</div>
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
		
		<?php if (in_array($era->post_name, array('progressive', 'nineteenth', 'great_depression', 'early_ny'))) {?>
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
		<?php } else { ?>
			map<?php echo $era->ID?>.setMapTypeId(google.maps.MapTypeId.ROADMAP);

		<?php } ?>
		
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
echo icph_slider();

get_footer();