// object literal for timeline sliding and jumping

var timeline = {

	$timeline		: false,
	$slider_eras	: false,
	interval		: false,
	increment		: 0,
	slider_start	: false,
	slider_end		: false,
	positions		: false,
	
	init : function(){
		this.positions = [];
		this.$timeline = jQuery('#timeline ul');
		this.$slider_eras = jQuery("ul#slider li");

		//because not all eras were entered / can't depend on each era having years
		for (var i = 0; i < eras.length; i++) {
			if (jQuery("#timeline li." + eras[i]).size()) {
				this.positions[eras[i]] = jQuery("#timeline li." + eras[i]).first().position().left;
			} else {
				this.positions[eras[i]] = jQuery("#timeline li").not('.overview').first().position().left;
			}
		}
		
		//set up vars
		this.slider_start	= this.$slider_eras.first().position().left;
		this.slider_end		= (0 - (jQuery("#timeline li").last().position().left - this.slider_start));
		
		//line up the first era with the left of the slider
		this.jump(eras[0]);
		
		//set slider era links
		this.$slider_eras.unbind("click").click(function(){
			var target = jQuery(this).attr("class");
			target = target.replace(" first", "").replace(" last", "").replace(" active", "");
			timeline.jump(target);
		});
		
		//set arrows
		body.off("mouseenter", "#timeline a.arrow").on("mouseenter", "#timeline a.arrow", function(){
			timeline.increment = (jQuery(this).hasClass("left")) ? 7 : -7;
			timeline.interval = setInterval(timeline.move, 10);
		}).off("mouseleave", "#timeline a.arrow").on("mouseleave", "#timeline a.arrow", function(){
			clearInterval(timeline.interval);
		});

		jQuery("#slider_policy li a").off("click").on("click", function(e) {
			e.preventDefault();
			var category = jQuery(this).attr('href').substr(1);
			jQuery("#slider_policy li").removeClass('active');
			if (category) jQuery(this).parent().addClass('active');
			jQuery.post("/wp-admin/admin-ajax.php", {
				action : 'timeline',
				category : category,
				type : jQuery(this).html().toLowerCase()
			}, function(data) {
				if (category) {
					jQuery("#slider_policy li.last").show();
				} else {
					jQuery("#slider_policy li.last").hide();
				}

				jQuery("#timeline_wrapper").html(data).find("div.policy_description").fadeIn();
				timeline.init();
				jQuery('#timeline_wrapper .description').jScrollPane();
				//jQuery('.policy_description .jspPane').css({width:'410px'});
			});
		});

		jQuery("#timeline_wrapper").off("click", ".policy_description a.close").on("click", ".policy_description a.close", function(e){
			e.preventDefault();
			jQuery(this).closest(".policy_description").fadeOut();
		});

	},
	jump : function(which) {
		//jump to an era on the timeline
		jQuery(window).scrollTop(0);
		this.$timeline.css("marginLeft", (0 - (this.positions[which] - this.slider_start)) + "px");
		this.update();
	},
	move : function() {
		var newMargin = parseInt(timeline.$timeline.css('marginLeft'), 10) + (timeline.increment);
		if (newMargin > timeline.slider_start)	newMargin = timeline.slider_start;
		if (newMargin < timeline.slider_end)	newMargin = timeline.slider_end;
		timeline.$timeline.css({ marginLeft : newMargin });
		timeline.update();
	},
	update : function() {
		//update the slider to reflect current timeline scroll
		var currentMargin = 0 - parseInt(this.$timeline.css("marginLeft"), 10) + this.slider_start;
		var currentMarginEnd = parseInt(this.$timeline.css("marginLeft"), 10);
		var currentEra = eras[0];
		for (var i = 0; i < eras.length; i++) {
			if (this.positions[eras[i]] <= currentMargin) currentEra = eras[i];
		}
		this.$slider_eras.removeClass("active");
		jQuery("ul#slider li." + currentEra).addClass("active");

		//when at limit, stop interval and hide arrow
		if (currentMargin === 0) {
			jQuery("#timeline div.arrow.left").hide();
			clearInterval(timeline.interval);
		} else if (jQuery("#timeline div.arrow.left").is(":hidden")) {
			jQuery("#timeline div.arrow.left").show();
		}
		
		if (currentMarginEnd === timeline.slider_end) {
			jQuery("#timeline div.arrow.right").hide();
			clearInterval(timeline.interval);
		} else if (jQuery("#timeline div.arrow.right").is(":hidden")) {
			jQuery("#timeline div.arrow.right").show();
		}
	}
};