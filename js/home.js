
var insights = {

	count : false,

	elements : jQuery("#home_insights .insight a"),

	active : function() {
		return jQuery(".insight a.active").first().index(this.elements);
	},

	change : function() {
		var index = insights.active();
		jQuery(".insight a.active").removeClass("active");

		if (jQuery(this).hasClass("left")) {
			var goto = (index == 0) ? insights.count : insights.count - 1;
		} else {
			var goto = (index == insights.count) ? 0 : insights.count + 1;
		}
		alert('goto ' + goto);
		jQuery(".insight a").get(goto).addClass("active");
	},

	init : function() {
		this.elements.first().addClass("active");
		this.count = this.elements.size();
		jQuery("#home_insights .arrow").click(this.change);
		//jQuery("#home_insights .arrow.right").click(this.right);
	}

}

insights.init();