jQuery(function(){
	//auto open a window for a single
	if (location.hash) showOverlay(location.hash);
	
	//global open an overlay
	jQuery("a").live('click', function(){
		var href = jQuery(this).attr("href");
		if (href.substr(0, 1) == "#") showOverlay(href);
	});
	
	//timeline scroll
	if (jQuery("body").hasClass("home")) {
		//alert(jQuery("ul#timeline li#progressive").offsetLeft);
	}
	
	//browse page
	jQuery("#browse h3").click(function(){
		jQuery(this).parent().find("ul").slideToggle();
	});
});

function showOverlay(hash) {
	hideOverlay();
	if (hash == "#") return;
	jQuery.ajax({
		url : "/" + hash.substr(1) + "/?overlay=true",
		success : function(data) {
			jQuery("body").append(data);
		},
		error : function(data) {
			alert("error");
		}
	});
}

function hideOverlay() {
	jQuery("div#overlay_backdrop").remove();
	jQuery("div#overlay").remove();
}