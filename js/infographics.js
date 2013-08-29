// object literal for timeline sliding and jumping

var infographics = {

	$arrow_left		: false,
	$arrow_right	: false,
	$element		: false,

	interval		: false,
	increment		: 0,

	margin_limit	: 0,
	margin_current	: 0,
	
	init : function(){

		this.$element		= jQuery('.row.infographics ul');
		this.$arrow_left	= jQuery('.row.infographics a.arrow.left');
		this.$arrow_right	= jQuery('.row.infographics a.arrow.right');

		var width = 0;
		this.$element.children("li").each(function(){
			width += jQuery(this).width();
			//window.console.log('width ' + jQuery(this).width());
		});

		this.margin_limit = 0 - (width - this.$element.parent().width());

		this.$element.width(width + 'px');
		
		window.console.log('width is ' + width + ' and parent is ' + this.$element.parent().width() + ' and margin_limit is ' + this.margin_limit);


		//set arrows
		jQuery("body").on("mouseenter", ".row.infographics  a.arrow", function(){
			infographics.increment = (jQuery(this).hasClass("left")) ? 7 : -7;
			infographics.interval 	= setInterval(infographics.move, 10);
		});

		jQuery("body").on("mouseleave", ".row.infographics  a.arrow", function(){
			clearInterval(infographics.interval);
		});

	},

	move : function() {

		infographics.margin_current = parseInt(infographics.$element.css('marginLeft'), 10) + infographics.increment;

		//window.console.log('new margin is ' + infographics.margin_current);

		//when at limit, stop interval and hide arrow
		if (infographics.margin_current >= 0) {
			infographics.margin_current = 0;
			infographics.$arrow_left.hide();
			clearInterval(infographics.interval);
		} else if (infographics.$arrow_left.is(":hidden")) {
			infographics.$arrow_left.show();
		}
		
		if (infographics.margin_current <= infographics.margin_limit) {
			infographics.margin_current = infographics.margin_limit;
			infographics.$arrow_right.hide();
			clearInterval(infographics.interval);
		} else if (infographics.$arrow_right.is(":hidden")) {
			infographics.$arrow_right.show();
		}

		infographics.$element.css({ marginLeft : infographics.margin_current });

	}

};