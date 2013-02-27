jQuery(function(){
	//@codekit-prepend "timeline.js";
	//@codekit-prepend "overlay.js";
	
	//console log helper
	if (typeof console === "undefined") window.console = { log: function () {} };

	//automatically open window if there's a hash
	if (location.hash && (location.hash !== "#contact")) overlay.show(location.hash);
	
	//set links to open overlays
	jQuery("a").live('click', function(){
		var href = jQuery(this).attr("href");
		if (href.substr(0, 1) === "#") overlay.show(href);
	});
	
	//header
	jQuery("li.search").hover(function(){
		jQuery(this).find("input").first().focus();
	});

	//initialize timeline if appropriate
	if (jQuery("body").hasClass("timeline")) timeline.init();
	
	//slider click
	jQuery("#slider_policy li.first").click(function(){
		jQuery(this).parent().toggleClass("active");
		var $icon = jQuery(this).find("i").first();
		if ($icon.hasClass("icon-plus-sign")) {
			$icon.removeClass("icon-plus-sign").addClass("icon-minus-sign");
		} else {
			$icon.removeClass("icon-minus-sign").addClass("icon-plus-sign");
		}
	});
	
	//set browse page accordion
	jQuery("#browse h3").live("click", function(){
		jQuery(this).parent().find("ul").slideToggle();
		var $icon = jQuery(this).find("i").first();
		if ($icon.hasClass("icon-plus-sign")) {
			$icon.removeClass("icon-plus-sign").addClass("icon-minus-sign");
		} else {
			$icon.removeClass("icon-minus-sign").addClass("icon-plus-sign");
		}
	});
	
	//set browse page links
	jQuery("#browse .header a").click(function(){
		jQuery("#browse .header a").removeClass("active");
		jQuery(this).addClass("active");
		var type = jQuery(this).html().toLowerCase();
		jQuery.ajax({
			url : "/wp-admin/admin-ajax.php",
			type : "POST",
			data : "action=browse&type=" + type,
			success : function(data) {
				jQuery("#browse .content").html(data);
			}
		});
	});
});
