jQuery(function(){
	
	//automatically open window if there's a hash
	if (location.hash) overlayShow(location.hash);
	
	//set links to open overlays
	jQuery("a").live('click', function(){
		var href = jQuery(this).attr("href");
		if (href.substr(0, 1) == "#") overlayShow(href);
	});

	var timeline = {
	
		$timeline		: jQuery('#timeline ul'), 
		$slider_eras	: jQuery("ul#slider li"),
		interval		: false, 
		increment		: 0,
		offset			: false,
		eras			: ["early_ny", "nineteenth", "progressive", "great_depression", "today"],
		positions		: [],
		
		init : function(){
		
			//set up vars
			this.offset = this.$slider_eras.first().position().left;
			for (var i = 0; i < this.eras.length; i++) this.positions[this.eras[i]] = jQuery("#timeline li#" + this.eras[i]).position().left;
			
			//start on progressive era
			this.jump("progressive");
			
			//set slider era links
			this.$slider_eras.click(function(){
				var target = jQuery(this).attr("class");
				target = target.replace(" first", "").replace(" last", "").replace(" active", "");
				timeline.jump(target);
			});
			
			//set arrow
			jQuery("#timeline div.arrow").hover(
				function() {
					timeline.increment = (jQuery(this).hasClass("left")) ? 7 : -7;
					timeline.interval = setInterval(timeline.move, 10);
				},
				function() {
					clearInterval(timeline.interval);
				}
			);
		},
		jump : function(which) {
			//jump to an era on the timeline
			this.$timeline.css("marginLeft", (0 - (this.positions[which] - this.offset)) + "px");
			this.update();
		},
		move : function() {
			timeline.$timeline.css({ marginLeft : parseInt(timeline.$timeline.css('marginLeft')) + (timeline.increment) });
			timeline.update();
		},
		update : function() {
			//update the slider to reflect current timeline scroll
			var currentMargin = 0 - parseInt(this.$timeline.css("marginLeft")) + this.offset;
			var currentEra = this.eras[0];
			for (var i = 0; i < this.eras.length; i++) {
				if (this.positions[this.eras[i]] <= currentMargin) currentEra = this.eras[i];
			}
			this.$slider_eras.removeClass("active");
			jQuery("ul#slider li." + currentEra).addClass("active");
		},
	}

	//initialize timeline if appropriate
	if (jQuery("body").hasClass("timeline")) timeline.init();
	
	//set browse page accordion
	jQuery("#browse h3").live("click", function(){
		jQuery(this).parent().find("ul").slideToggle();
	});
	
	//set browse page links
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
		if (hash == "#") return overlayHide();

		jQuery.ajax({
			url : "/" + hash.substr(1) + "/?overlay=true",
			success : function(data) {
				overlayHide();
				jQuery("body").append(data);
			},
			error : function(data) {
				//must clear this bad URL
				location.href = "/";
			}
		});
	}
	
	function overlayHide() {
		jQuery("div#overlay_backdrop").remove();
		jQuery("div#overlay").remove();
	}

});
