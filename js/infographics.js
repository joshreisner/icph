// object literal for timeline sliding and jumping

var infographics = {

	$infographics	: false,
	interval		: false,
	increment		: 0,
	
	init : function(){

		this.$infographics	= jQuery('.row.infographics ul');
		//this.slider_start	= this.$slider_eras.first().position().left;
		//this.slider_end		= (0 - (jQuery("#timeline li").last().position().left - this.slider_start));
				
		//set arrows
		jQuery("body").on("mouseenter", ".row.infographics  a.arrow", function(){
			infographics.increment = (jQuery(this).hasClass("left")) ? 7 : -7;
			infographics.interval = setInterval(infographics.move, 10);
		});
		jQuery("body").on("mouseleave", ".row.infographics  a.arrow", function(){
			clearInterval(infographics.interval);
		});

	},
	move : function() {
		var newMargin = parseInt(infographics.$infographics.css('marginLeft'), 10) + (infographics.increment);
		window.console.log('moving by ' + newMargin);
		//if (newMargin > infographics.slider_start)	newMargin = infographics.slider_start;
		//if (newMargin < infographics.slider_end)	newMargin = infographics.slider_end;
		infographics.$infographics.css({ marginLeft : newMargin });
		//infographics.update();
	},
	update : function() {
		//update the slider to reflect current timeline scroll
		var currentMargin = 0 - parseInt(this.$infographics.css("marginLeft"), 10) + this.slider_start;
		var currentMarginEnd = parseInt(this.$infographics.css("marginLeft"), 10);

		//when at limit, stop interval and hide arrow
		if (currentMargin === 0) {
			jQuery(".row.infographics div.arrow.left").hide();
			clearInterval(timeline.interval);
		} else if (jQuery("#timeline div.arrow.left").is(":hidden")) {
			jQuery(".row.infographics div.arrow.left").show();
		}
		
		if (currentMarginEnd === infographics.slider_end) {
			jQuery(".row.infographics div.arrow.right").hide();
			clearInterval(infographics.interval);
		} else if (jQuery(".row.infographics div.arrow.right").is(":hidden")) {
			jQuery(".row.infographics div.arrow.right").show();
		}
	}
};