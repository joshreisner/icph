//@codekit-prepend "jquery-1.9.1.js";
//@codekit-prepend "jquery.mousewheel.js";
//@codekit-prepend "jquery.jscrollpane.js";
//@codekit-prepend "bootstrap.js";

jQuery(function(){
	//@codekit-prepend "timeline.js";
	//@codekit-prepend "overlay.js";
	
	//console log helper
	if (typeof console === "undefined") window.console = { log: function () {} };

	//automatically open window if there's a hash
	if (location.hash && (location.hash !== "#contact")) overlay.show(location.hash);

	//open overlays when hash link clicked
	$(window).on('hashchange', function() {
		if (location.hash && (location.hash !== "#contact")) {
			overlay.show(location.hash);
		} else {
			overlay.hide();
		}
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
	jQuery("#browse").on("click", "h3", function(){
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
	
	//era page jscrollpane
	jQuery('.scroll-pane').jScrollPane();

});
