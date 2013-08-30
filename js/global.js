//@codekit-prepend "jquery-1.9.1.js";
//@codekit-prepend "jquery.mousewheel.js";
//@codekit-prepend "jquery.jscrollpane.js";
//@codekit-prepend "bootstrap.js";

jQuery(function(){
	//@codekit-prepend "timeline.js";
	//@codekit-prepend "overlay.js";
	//@codekit-prepend "home.js";
	//@codekit-prepend "infographics.js";

	//console log helper
	if (typeof console === "undefined") window.console = { log: function () {} };

	//global variables needed everywhere
	body = jQuery("body");
	eras = ["early_ny", "nineteenth", "progressive", "great_depression", "today"];

	//header
	jQuery("li.search").hover(function(){
		jQuery(this).find("input").first().focus();
	},function(){
		jQuery(this).find("input").first().blur();
	});
	
	//hide placeholder on focus
	jQuery("input").focus(function(){
		jQuery(this).attr("data-placeholder", jQuery(this).attr("placeholder"));
		jQuery(this).attr("placeholder", "");
	}).blur(function(){
		jQuery(this).attr("placeholder", jQuery(this).attr("data-placeholder"));
		jQuery(this).attr("data-placeholder", "");
	});
	
	jQuery("li.search i").click(function(){
		jQuery("input#search").val("");
	});
	
	//page-specific javascript
	if (body.hasClass("home")) {

		//scroll-away header
		jQuery(window).scroll(function(){
			//alert(typeof(jQuery(window)));
			if (jQuery(window).scrollTop() > 80) {
				body.addClass("scrolled");
			} else {
				body.removeClass("scrolled");
			}
		});

		jQuery("#home_insights .arrow a").click(function(e){
			e.preventDefault();
			var direction = (jQuery(this).hasClass('left')) ? 'left' : 'right';
			insights.move(direction);
		});

		insights.init();		

	} else if (body.hasClass("timeline")) {

		//initialize timeline if appropriate
		timeline.init();

	} else if (body.hasClass("maps")) {

		//description box
		jQuery("div#description a.close").click(function(e){
			jQuery(this).parent().toggleClass("minimized");
			e.stopPropagation();
		});

		jQuery("body").on("click", "div#description.minimized", function(){
			jQuery(this).toggleClass("minimized");
		});
	
		jQuery("#slider li.progressive").addClass("active");
		
		jQuery("#slider li").click(function(){
			if (jQuery(this).hasClass("active")) return;
			var old_era = jQuery("#slider li.active").attr("class").replace(" first", "").replace(" active", "").replace(" last", ""); //HACK
			var old_id = jQuery(".mapwrapper." + old_era).find(".map").attr("id");
			var center = window[old_id].getCenter();
			var zoom = window[old_id].getZoom();
			if (zoom == 3) {
				zoom = 14;
				center = new google.maps.LatLng(40.725, -73.965);
			}
			//alert(center.lat());
			jQuery("#slider li.active").removeClass("active");
			var new_era = jQuery(this).attr("class").replace(" first", "").replace(" last", ""); //HACK
			jQuery(this).addClass("active");
			jQuery(".mapwrapper").hide();
			jQuery(".mapwrapper." + new_era).show();
			var new_id = jQuery(".mapwrapper." + new_era).find(".map").attr("id");
			google.maps.event.addListenerOnce(window[new_id], 'bounds_changed', function() {
				window.console.log('bounds changed');
		    	this.setCenter(center);
		    	this.setZoom(zoom);
			});
			google.maps.event.trigger(window[new_id], 'resize');
	    	window[new_id].setCenter(center);
	    	window[new_id].setZoom(zoom);
		});

	} else if (body.hasClass("page-id-32")) {

		//set browse page accordion
		jQuery("#browse").on("click", "h3", function(){
			jQuery(this).parent().find("ul").slideToggle();
			var $icon = jQuery(this).find("i").first();
			if ($icon.hasClass("icon-plus-circled")) {
				$icon.removeClass("icon-plus-circled").addClass("icon-minus-circled");
			} else {
				$icon.removeClass("icon-minus-circled").addClass("icon-plus-circled");
			}
		});

		//set browse page links
		jQuery("#browse .header a").click(function(e){
			e.preventDefault();
			jQuery("#browse .header a").removeClass("active");
			jQuery(this).addClass("active");
			jQuery.post("/wp-admin/admin-ajax.php", {
				action : 'browse',
				type : jQuery(this).html().toLowerCase() 
			}, function(data) {
				jQuery("#browse .content").html(data);
			});
		});

	} else if (body.hasClass("single-era")) {

		//start up infografix scroller
		infographics.init();
	}

	//automatically open window if there's a hash
	if (location.hash) overlay.show(location.hash);

	//open overlays when hash link clicked
	$(window).on('hashchange', function() {
		overlay.show(location.hash);
	});
	
});