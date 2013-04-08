var overlay = {
	show : function(hash) {
		if (hash === "#") return this.hide();
	
		jQuery("body").append("<div id='overlay_loading'></div>");
		
		jQuery.ajax({
			url : "/" + hash.substr(1) + "/?overlay=true",
			success : function(data) {
				overlay.hide();
				jQuery("body").append(data);
				jQuery("#overlay_loading").remove();
				
				//escape key to close overlay
				jQuery("body").keydown(function(e){
					//bind the escape key to overlay-closing
					//window.alert(e.keyCode);
					if (e.keyCode === 27) {
						overlay.hide();
						location.href = "#";
					}
				});
				
				//affix
				jQuery(".navigation").affix({offset:143});
				
				//jscrollpane
				jQuery('.scroll-pane').jScrollPane();
				
				jQuery("#overlay_backdrop").click(function(){
					overlay.hide();
					location.href = "#";
				});
				
				jQuery("a.arrow").click(function(e){
					e.stopPropagation();
				});
				
			},
			error : function() {
				//must clear this bad URL
				location.href = "/";
			}
		});
	},
	hide : function() {
		jQuery("#overlay_loading").remove();
		jQuery("div#overlay_backdrop").remove();
		jQuery("div#overlay").remove();
	}
};