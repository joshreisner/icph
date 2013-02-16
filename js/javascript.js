jQuery(function(){
	
	// 1/ global
	//automatically open window if there's a hash
	if (location.hash) overlayShow(location.hash);
	
	//set links to open overlays
	jQuery("a").live('click', function(){
		var href = jQuery(this).attr("href");
		if (href.substr(0, 1) == "#") overlayShow(href);
	});


	// 2/ timeline	

	//set initial scroll and variables
	if (jQuery("body").hasClass("home")) {
		var $timeline = jQuery('ul#timeline'), timeline_interval, timeline_direction;
		var sliderLeft = jQuery("ul#slider li").first().position().left;
		var eras = new Array("early_ny", "nineteenth", "progressive", "great_depression", "today");
		var eraLeft = new Array();
		for (var i = 0; i < eras.length; i++) eraLeft[eras[i]] = jQuery("ul#timeline li#" + eras[i]).position().left;
	
		timelineJump("progressive");
	}
	
	jQuery("ul#slider li").click(function(){
		var target = jQuery(this).attr("class");
		target = target.replace(" first", "").replace(" last", "").replace(" active", "");
		timelineJump(target);
	});
	
	//set arrow
	jQuery(".timeline_mask div.arrow").hover(
		function() {
			timeline_direction = (jQuery(this).hasClass("left")) ? 1 : -1;
			timeline_interval = setInterval(timelineMove, 30);
		},
		function() {
			clearInterval(timeline_interval);
		}
	);


	// 3/ browse page
	//set accordion
	jQuery("#browse h3").live("click", function(){
		jQuery(this).parent().find("ul").slideToggle();
	});
	
	//set links
	jQuery("#browse .header a").click(function(){
		jQuery("#browse .header a").removeClass("active");
		jQuery(this).addClass("active");
		var type = jQuery(this).html().toLowerCase();
		jQuery.ajax({
			url : "/wp-admin/admin-ajax.php",
			type : "POST",
			data : "action=browse&type=" + type,
			success : function(data) {
				jQuery("#browse .content").html(data);
			}
		});
	});


	//functions
	function overlayShow(hash) {
		overlayHide();
		if (hash == "#") return;
		jQuery.ajax({
			url : "/" + hash.substr(1) + "/?overlay=true",
			success : function(data) {
				jQuery("body").append(data);
			},
			error : function(data) {
				alert("error");
			}
		});
	}
	
	function overlayHide() {
		jQuery("div#overlay_backdrop").remove();
		jQuery("div#overlay").remove();
	}
	
	function sliderUpdate() {
		//update the slider to
		var currentMargin = 0 - parseInt(jQuery("ul#timeline").css("marginLeft")) + sliderLeft;
		var currentEra = eras[0];
		for (var i = 0; i < eras.length; i++) {
			if (eraLeft[eras[i]] <= currentMargin) currentEra = eras[i];
			//alert(eras[i] + " " + currentEra + " " + eraLeft[eras[i]] + " " + currentMargin);
		}
		jQuery("ul#slider li").removeClass("active");
		jQuery("ul#slider li." + currentEra).addClass("active");
	}
	
	function timelineJump(which) {
		//jump the timeline such that it lines up with the left side of the slider
		//alert("-" + (eraLeft[which] - sliderLeft) + "px");
		jQuery("ul#timeline").css("marginLeft", (0 - (eraLeft[which] - sliderLeft)) + "px");
		sliderUpdate();
	}
	
	function timelineMove() {
		$timeline.css({ marginLeft : parseInt($timeline.css('marginLeft')) + (timeline_direction * 10) });
		sliderUpdate();
	}

});
