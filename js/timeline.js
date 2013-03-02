// object literal for timeline sliding and jumping

var timeline = {

	$timeline		: jQuery('#timeline ul'),
	$slider_eras	: jQuery("ul#slider li"),
	interval		: false,
	increment		: 0,
	slider_start	: false,
	slider_end		: false,
	eras			: ["early_ny", "nineteenth", "progressive", "great_depression", "today"],
	positions		: [],
	
	init : function(){
	
		for (var i = 0; i < this.eras.length; i++) {
			this.positions[this.eras[i]] = jQuery("#timeline li#" + this.eras[i]).position().left;
		}
		
		//set up vars
		this.slider_start	= this.$slider_eras.first().position().left;
		this.slider_end		= (0 - this.positions.today + this.slider_start);
		
		//start on progressive era
		this.jump("progressive");
		
		//set slider era links
		this.$slider_eras.click(function(){
			var target = jQuery(this).attr("class");
			target = target.replace(" first", "").replace(" last", "").replace(" active", "");
			timeline.jump(target);
		});
		
		//set arrow
		jQuery("#timeline a.arrow").hover(
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
		var currentEra = this.eras[0];
		for (var i = 0; i < this.eras.length; i++) {
			if (this.positions[this.eras[i]] <= currentMargin) currentEra = this.eras[i];
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