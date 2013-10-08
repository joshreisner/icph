var overlay = {
	show : function() {
		var hash = window.location.hash;
		if (hash.length && (hash.substr(0, 1) == '#')) hash = hash.substr(1);
		if (!hash.length) return this.hide();

		if (jQuery.inArray(hash, eras) != -1) {
			if (body.hasClass("timeline")) {
				jQuery("#timeline a.arrow").remove();
				jQuery("#timeline").append('<a class="arrow left"><div class="cap"><i class="icon-left-open-big"></i></div></a><a class="arrow right"><div class="cap"><i class="icon-right-open-big"></i></div></a>');
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
				
				//check to make sure overlay covers 100% height of the window
				if (jQuery("#overlay").height() < jQuery(document).height()) {
					jQuery("#overlay").height(jQuery(document).height());
				}

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
				}).hover(function(){
					if (jQuery(this).hasClass('left')) {
						jQuery(this).animate({'left':0}, 100);
					} else {
						jQuery(this).animate({'right':0}, 100);
					}
				},function(){
					if (jQuery(this).hasClass('left')) {
						jQuery(this).animate({'left':-140}, 100);
					} else {
						jQuery(this).animate({'right':-140}, 100);
					}
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