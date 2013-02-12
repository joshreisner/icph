jQuery(function(){
	//auto open a window for a single
	if (location.hash) showOverlay(location.hash);
	
	/*
	jQuery("a").each(function(){
		var href = jQuery(this).attr("href");
		if (href.substr(0, 1) == "#") {
			jQuery(this).click(function(){
				showOverlay(href);
			});
		}
	});
	*/
	
	jQuery("a").live('click', function(){
		var href = jQuery(this).attr("href");
		if (href.substr(0, 1) == "#") showOverlay(href);
	});
	
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