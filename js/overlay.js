var overlay = {
	show : function(hash) {
		if (hash === "#") return this.hide();
	
		jQuery.ajax({
			url : "/" + hash.substr(1) + "/?overlay=true",
			success : function(data) {
				overlay.hide();
				jQuery("body").append(data);
				/* jQuery("div#overlay_backdrop").click(function(){
					//clicking off the overlay closes it
					overlay.hide();
					location.href = "#";
				});*/
				jQuery("body").keydown(function(e){
					//bind the escape key to overlay-closing
					//window.alert(e.keyCode);
					if (e.keyCode === 27) {
						overlay.hide();
						location.href = "#";
					}
				});
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