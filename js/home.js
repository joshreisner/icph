var insights = {

	count : false,

	elements : jQuery("#home_insights .insight a"),

	active : function() {
		return jQuery(".insight a.active").first().index(this.elements);
	},

	init : function() {
		this.elements.first().addClass("active");
		this.count = this.elements.size() - 1;
	},

	move : function(direction) {
		var index = insights.active();
		jQuery(".insight a.active").removeClass("active");

		if (direction == 'left') {
			var goto = (index == 0) ? this.count : index - 1;
		} else {
			var goto = (index == this.count) ? 0 : index + 1;
		}

		window.console.log('goto was ' + goto + ' and count is ' + this.count + " and index is " + index);

		//this.elements.get(goto).addClass("active");
		jQuery(".insight a:nth-child(" + (goto + 1) + ")").addClass("active");
	}

}