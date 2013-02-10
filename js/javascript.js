jQuery(function(){
	if (location.hash) {
		showOverlay(location.hash.substr(1));
	}
});

function showOverlay(which) {
	jQuery.ajax({
		url : "/" + which + "/?overlay=true",
		success : function(data) {
			//if (!jQuery("div#overlay_backdrop").size()) jQuery("body").append("<div id='overlay_backdrop'/>");
			//if (!jQuery("div#overlay").size()) jQuery("body").append("<div id='overlay'/>");
			//jQuery("div#overlay").html(data);
			hideOverlay();
			jQuery("body").append(data);
			
			//set up any jquery events on these added elements
			jQuery("div#overlay a.close").click(hideOverlay);
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