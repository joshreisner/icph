var overlay = {
	show : function() {
		var hash = window.location.hash;
		if (hash.length && (hash.substr(0, 1) == '#')) hash = hash.substr(1);
		if (!hash.length) return this.hide();

		if (jQuery.inArray(hash, eras) != -1) {
			if (body.hasClass("timeline")) {
				timeline.jump(hash);
				return false;
			} else if (body.hasClass("maps")) {
				jQuery("#slider li." + hash).click();
				return false;
			}
			return false;
		} else if (hash == "contact") {
			return false;
		}

		window.console.log('running overlay.show for ' + hash);		
	
		jQuery("div#overlay_backdrop").remove();
		jQuery("body").append("<div id='overlay_loading'></div>");
		
		jQuery.ajax({
			url : "/" + hash + "/?overlay=true",
			success : function(data) {
				jQuery("#overlay_loading").remove();
				jQuery("div#overlay_backdrop").remove();
				jQuery("div#overlay").remove();

				jQuery("body").append(data);
				jQuery("#overlay_loading").remove();
				window.scrollTo(0, 0);
				jQuery("#overlay").fadeIn();
				
				//escape key to close overlay
				jQuery("body").keydown(function(e){
					//bind the escape key to overlay-closing
					if (e.keyCode === 27) {
						window.console.log('escape key detected');
						window.location.hash = '';
					}
				});
				
				//affix
				jQuery(".navigation").affix({offset:60});
				
				//set the height of the side nav
				var windowHeight = jQuery(window).height() - 36;
				jQuery("div.navigation .scroll-pane").css({height: windowHeight + 'px'});
				
				//jscrollpane, with hooks for scroll-spying
				var articlesY = 0;
				var imagesY = jQuery("ul#articles").height();
				var documentsY = imagesY + jQuery("div.gallery.images").height();
				var navScroller = jQuery('.navigation .scroll-pane').jScrollPane();
				
				//close on click outside
				jQuery("#overlay_backdrop").click(function(){
					window.location.hash = '';
				});
				
				//arrows
				jQuery("a.arrow").click(function(e){
					e.stopPropagation();
				});
				
				jQuery("a.back").click(function(e){
					e.preventDefault();
					jQuery("div.body").show();
					jQuery("div.header a.close").show();
					jQuery("div.header a.back").hide();
					jQuery("div.attachments").hide();
				});
			},
			error : function() {
				//must clear this bad URL
				window.location.hash = '';
			}
		});
	},
	hide : function() {
		window.console.log('hiding window');
		jQuery("div#overlay_backdrop").fadeOut();
		jQuery("div#overlay").fadeOut(function(){
			jQuery("#overlay_loading").remove();
			jQuery("div#overlay_backdrop").remove();
			jQuery("div#overlay").remove();
		});
	}
};