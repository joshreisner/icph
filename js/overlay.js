var overlay = {
	show : function(hash) {
		if (hash === "#") return this.hide();
	
		jQuery.ajax({
			url : "/" + hash.substr(1) + "/?overlay=true",
			success : function(data) {
				overlay.hide();
				jQuery("body").append(data);
			},
			error : function() {
				//must clear this bad URL
				location.href = "/";
			}
		});
	},
	hide : function() {
		jQuery("div#overlay_backdrop").remove();
		jQuery("div#overlay").remove();
	}
};