var insights = {

	count : false,

	elements : jQuery("#home_insights .insight a"),

	init : function() {
		this.elements.first().addClass("active");
		this.count = this.elements.size() - 1;

		jQuery("#home_insights .arrow a").click(function(e){
			e.preventDefault();
			var direction = (jQuery(this).hasClass('left')) ? 'left' : 'right';
			insights.move(direction);
		});
	},

	move : function(direction) {
		var index = jQuery("#home_insights .insight a.active").removeClass("active").index();

		if (direction == 'left') {
			var goto = (index == 0) ? this.count : index - 1;
		} else {
			var goto = (index == this.count) ? 0 : index + 1;
		}

		//window.console.log('index is ' + index + ' goto was ' + goto + ' and count is ' + this.count);

		//this.elements.get(goto).addClass("active");
		jQuery(".insight a:nth-child(" + (goto + 1) + ")").addClass("active");
	}

}