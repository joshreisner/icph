var overlay = {
	show : function(hash) {
		if (hash === "#") return this.hide();
	
		jQuery("div#overlay_backdrop").remove();
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
				jQuery(".navigation").affix({offset:60});
				
				//set the height of the side nav
				var windowHeight = jQuery(window).height() - 36;
				jQuery("div.navigation .scroll-pane").css({height: windowHeight + 'px'});
				
				//jscrollpane, with hooks for scroll-spying
				var articlesY = 0;
				var imagesY = jQuery("ul#articles").height();
				var documentsY = imagesY + jQuery("div.gallery.images").height();
				var navScroller = jQuery('.navigation .scroll-pane').jScrollPane().bind('jsp-scroll-y', function(event, scrollPositionY, isAtTop, isAtBottom) {
					//window.console.log('scrollPositionY=', scrollPositionY, 'isAtTop=', isAtTop, 'isAtBottom=', isAtBottom);
					//window.console.log(scrollPositionY + "--" + imagesY);
					var shouldBeHighlighted = "articles";
					if ((scrollPositionY >= documentsY) || isAtBottom) {
						shouldBeHighlighted = "documents";
					} else if (scrollPositionY >= imagesY) {
						shouldBeHighlighted = "images";
					}
					
					if (!jQuery("#navbar a." + shouldBeHighlighted).hasClass("active")) {
						jQuery("#navbar a.active").removeClass("active");
						jQuery("#navbar a." + shouldBeHighlighted).addClass("active");
					}
				});
				
				//navbar links
				jQuery("#navbar a").click(function(e){
					e.preventDefault();
					if (jQuery(this).hasClass("articles")) {
						navScroller.data('jsp').scrollTo(0, articlesY);
					} else if (jQuery(this).hasClass("images")) {
						navScroller.data('jsp').scrollTo(0, imagesY);
					} else if (jQuery(this).hasClass("documents")) {
						navScroller.data('jsp').scrollTo(0, documentsY);
					}
				});

				
				//magnifying glass
				var mGlass = false;
				jQuery(".attachment a.mag").click(function(){
					if (mGlass) {
						jQuery(this).html("<i class='icon-zoom-in'></i> Magnifying Glass On");
						mGlass = false;
						jQuery("#overlay div.body").html(jQuery("div.mglass_picture_box").html());
					} else {
						jQuery(this).html("<i class='icon-zoom-out'></i> Magnifying Glass Off");
						mGlass = new MGlass("zoomable", jQuery("#zoomable").attr("data-full"));
					}
				});
				
				//close on click outside
				jQuery("#overlay_backdrop").click(function(){
					overlay.hide();
					location.href = "#";
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