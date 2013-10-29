//@codekit-prepend "jquery.mousewheel.js";
//@codekit-prepend "jquery.jscrollpane.js";
//@codekit-prepend "jquery-ui.js";
//@codekit-prepend "bootstrap.js";

jQuery(function(){
	//@codekit-prepend "timeline.js";
	//@codekit-prepend "overlay.js";
	//@codekit-prepend "insights.js";
	//@codekit-prepend "infographics.js";


	//console log helper
	if (typeof console === "undefined") window.console = { log: function () {} };


	//global variables needed everywhere
	body = jQuery("body");
	eras = ["early_ny", "nineteenth", "progressive", "great_depression", "today"];


	//header
	$search = jQuery("input#search");
	jQuery("#header #nav > li").hover(function(){
		jQuery(this).find("ul.dropdown").fadeIn('fast');
	},function(){
		jQuery(this).find("ul.dropdown").fadeOut('fast');		
	});
	
	jQuery("#header #tools > li").hover(function(){
		jQuery(this).find("ul.dropdown").fadeIn('fast', function(){
			$search.focus();
		});
	},function(){
		if (jQuery(this).hasClass("search") && $search.is(":focus")) {
		} else {
			jQuery(this).find("ul.dropdown").fadeOut('fast');			
		}
	});

	$search.blur(function(){
		jQuery("li.search ul.dropdown").fadeOut('fast');
	});
	
	//fading circle thumbnails
	jQuery("a.thumbnail").hover(function(){
		jQuery(this).find("img").fadeOut();
	},function(){
		jQuery(this).find("img").fadeIn();		
	});

	//search
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

	//all results button
	jQuery("li.search li.all a").click(function(){
		jQuery(this).closest("ul.dropdown").find("form").first().submit();
	})


	//insights could be on home or about
	if (jQuery("#home_insights").size()) insights.init();		

	
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

		jQuery("#home .column").hover(function(){
			//zoom and fade home columns (would be simpler to animate backgroundSize but jQuery cannot)

			var duration = 400;
			var $upper = jQuery(this).find(".upper");
			if ($upper.hasClass("zoomed")) return;
			jQuery(this).find("ul").fadeIn();
			var old_width	= $upper.width();
			var old_height	= $upper.height();
			var new_width	= old_width * 1.1;
			var new_height	= old_height * 1.1;
			var marginx		= (new_width - old_width) / 2;
			var marginy		= (new_height - old_height) / 2;
			$upper.attr("data-width", old_width).attr("data-height", old_height).addClass("zoomed");
			$upper.animate({
				width: new_width, 
				height: new_height,
				marginLeft: "-" + marginx + "px",
				marginTop: "-" + marginy + "px"
			},{
			  duration: duration,
			  queue: false
			});
			$upper.fadeTo(duration, 1);
		}, function(){
			var duration = 400;
			jQuery(this).find("ul").fadeOut(duration);
			var $upper = jQuery(this).find(".upper");
			$upper.fadeTo(duration, .5).animate({
				marginLeft:0,
				marginTop:0,
				width:$upper.attr("data-width"),
				height:$upper.attr("data-height")
			},{
			  duration: duration,
			  queue: false,
			  complete: function(){
				$upper.removeClass("zoomed");
			}});
		});

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
			var new_era = jQuery(this).attr("class").replace(" first", "").replace(" last", ""); //HACK
			changeMapEraTo(new_era);
			jQuery("#slider li.active").removeClass("active");
			jQuery(this).addClass("active");
		});

		jQuery("a.toggle").click(function(){
			if (jQuery(this).attr("id") == "toggle-1980") {
				changeMapEraTo("today-2000");
			} else {
				changeMapEraTo("today");				
			}
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
	if (window.location.hash.length > 1) overlay.show();

	//open overlays when hash link clicked
	jQuery(window).on('hashchange', function() {
		overlay.show();
	});

	function changeMapEraTo(new_era) {
		var old_era = jQuery("#slider li.active").attr("class").replace(" first", "").replace(" active", "").replace(" last", ""); //HACK
		var old_id  = jQuery(".mapwrapper." + old_era).find(".map").attr("id");
		var center  = window[old_id].getCenter();
		var zoom    = window[old_id].getZoom();
		if (zoom == 3) {
			zoom = 14;
			center = new google.maps.LatLng(40.725, -73.965);
		}
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
	}
	
});