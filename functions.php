<?php

//setup
//add_theme_support('menus');
add_filter('body_class', 'icph_body_class');


//custom functions
function icph_body_class($classes)  {
	global $post;
	foreach(explode('/', $_SERVER['REQUEST_URI']) as $category) {
		if (!empty($category)) $classes[] = trim($category);
	}
	if ($post && $post->ID) {
		foreach((get_the_category($post->ID)) as $category) $classes[] = trim($category->category_nicename);
	}
	return array_unique($classes);
}

